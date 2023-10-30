<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eksekutif extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'dashboard/eksekutif/' );

	}

	function index() {
		$this->show();
		// $this->get_user_location_v1();
	}

	function show() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['title'] = 'Dashboard Eksekutif';
		$data['cari'] = $this->form_cari();
		$data['base_url'] = $this->dir;
		$data['extra_script'] = '
		<script>
		$(document).ready( function(){
			$("#select-propinsi").on( "change", function(){
				let params = {
					"location_id": $(this).val(),
					"level": "3",
					"title": "Kabupaten",
				}
				if ( $(this).val() == "0" ) {
					$( "#select-kabupaten").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
					$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
					$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					
				} else {
					get_location(params);
					$( "#select-kabupaten").html( "<option value=\'0\'>Loading... </option>" );
				}
				
			});

			$("#select-kabupaten").on( "change", function(){
				let params = {
					"location_id": $(this).val(),
					"select-propinsi": $("#select-propinsi").val(),
					"level": "4",
					"title": "Kecamatan",
				}
				
				if ( $(this).val() == "0" ) {
					$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
					$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
				
				} else {
					get_location(params);
					$( "#select-kecamatan").html( "<option value=\'0\'>Loading... </option>" );   
				}
				
			});

			$("#select-kecamatan").on( "change", function(){
				let params = {
					"location_id": $(this).val(),
					"select-propinsi": $("#select-propinsi").val(),
					"select-kabupaten": $("#select-kabupaten").val(),
					"level": "5",
					"title": "Kelurahan",
				}
				if ( $(this).val() == "0" ) {
					$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
				} else {
					get_location(params);
					$( "#select-kelurahan").html( "<option value=\'0\'>Loading... </option>" ); 
				}
				
			});

			var get_location = ( params ) => {
				$.ajax({
					url: "' . $this->dir . 'get_show_location",
					type: "GET",
					data: $.param(params),
					dataType: "json",
					beforeSend: function( xhr ) {
						$("#modalLoader").modal("show");
					},
					success : function(data) {

						let option = `<option value="0"> -- Semua ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
						$.each( data, function(k,v) {
							option += `<option value="${k}">${v}</option>`;
						});
				
						$("#select-" + params.title.toLowerCase() ).html( option );
					},
				});
			};
		});
	</script>
		';

		$this->template->title( 'Dashboard Eksekutif' );
		$this->template->content( "admin/dashboard/new-eksekutif", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function form_cari() {
		
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();
		
		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		
		// if (strtolower($this->user_info['user_name']) == 'root') 
		// {
		// 	$params_propinsi = "exec [dbo].[get_level_dashboard] 1,0,0,0";
		// }
		// else
		// {
			// $params_propinsi = "exec [dbo].[get_level_dashboard_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		$params_propinsi = "exec [dbo].[get_level_dashboard_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
			// "exec [dbo].[get_level_dashboard] 1,0,0,0";
			// "exec [dbo].[get_level_dashboard_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
			
		// }
		
		$query_propinsi = $this->db->query($params_propinsi);

		foreach ( $query_propinsi->result() as $key => $value ) {
			$option_propinsi .= '<option value="' . $value->kode_propinsi . '">' . $value->propinsi . '</option>';
		}

		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
				<div class="form-group col-md-3">
				<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" >
					' . $option_propinsi . '
				</select>
					</div>
					<div class="form-group col-md-3">
					<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" >
					' . $option_kota . '
				</select>
					</div>
					<div class="form-group col-md-3">
					<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control">
					' . $option_kecamatan . '
				</select>
					</div> 
					<div class="form-group col-md-3">
						<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
					</div>
				</div> 
			</div>
		';

		return $form_cari;
	}


	function get_user_location_v1() {
		
		$user_location = $this->user_info['user_location'];
		$username = '';
		$res_loc = '';
		$level_id = '';
		$textprop = '';
		$textkab = '';
		$textkec = '';
		$textkel = '';


		$params_user = "
		WITH CTE_TableName AS (

			select c.level ,cast(c.location_id as varchar(100)) location_id
									 from core_user_profile a
										  left JOIN user_location b on a.user_profile_id = b.user_location_user_account_id
										  left JOIN ref_locations c on b.user_location_location_id = c.location_id
										  where a.user_profile_id = '" . $this->user_info['user_id'] . "'
									group by c.level ,c.location_id
									
	 
			
								)
						SELECT t0.level
							, STUFF((
								SELECT ',' + t1.location_id
								FROM CTE_TableName t1
								WHERE t1.level = t0.level
								ORDER BY t1.location_id
								FOR XML PATH('')), 1, LEN(','), '') AS location_id
						FROM CTE_TableName t0
						GROUP BY t0.level
						ORDER BY level;
		";


	// 	$params_user = "
	// 	select c.level level,string_agg(c.location_id,',') as location_id
	// 	from core_user_profile a
	// 		 left JOIN user_location b on a.user_profile_id = b.user_location_user_account_id
	// 		 left JOIN ref_locations c on b.user_location_location_id = c.location_id
	//    where a.user_profile_id = '" . $this->user_info['user_id'] . "'
	//    group by level
	//    order by level";

	   $query_user = $this->db->query($params_user);
	   
	   foreach ( $query_user->result_array() as $key => $value ) {
			
			if($value['level'] == 2) 
			{
				$textprop = "id_provinsi  in (" .$value['location_id']. ") OR ";
			};
			if($value['level'] == 3)
			{
				$textkab = "id_kabupaten in (" .$value['location_id']. ") OR ";
			}; 
			if($value['level'] == 4)
			{
				$textkec = "id_kecamatan in (" .$value['location_id']. ") OR ";
			}; 
			if($value['level'] == 5)
			{
				$textkel = "id_kelurahan in (" .$value['location_id']. ")  OR ";
			};

		}

		$text = SUBSTR($textprop . $textkab . $textkec . $textkel,0,-3)  ;
		
		$res_loc = [
			'text' => $text,
			'username' => $this->user_info['user_name']
		];
		
		return $res_loc;
	}

	function get_user_location() {
		
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '0';
		$regency_id = '0';
		$district_id = '0';
		$village_id = '0';
		$kode_propinsi = '0';
		$loc1 = '';
		if ( ! empty( $user_location ) ) {
			$count = count( $user_location );
			$no = 1;
			foreach ( $user_location as $loc ) {
				$params_location = [
					'table' => 'dbo.master_location',
					'where' => [
						'location_id' => $loc
					]
				];
				$query = get_data( $params_location );
				$country_id = $query->row( 'country_id' ) . ( ( $no < $count ) ? ',' : '' );
				$province_id = $query->row( 'province_id' ) . ( ( $no < $count ) ? ',' : '' );
				$regency_id = $query->row( 'regency_id' ) . ( ( $no < $count ) ? ',' : '' );
				$district_id = $query->row( 'district_id' ) . ( ( $no < $count ) ? ',' : '' );
				$village_id = $query->row( 'village_id' ) . ( ( $no < $count ) ? ',' : '' );
				$kode_propinsi = $query->row( 'kode_propinsi' ) . ( ( $no < $count ) ? ',' : '' );
				$kode_propinsi1 = $kode_propinsi . '' . $kode_propinsi1;

				$no++;
			}
		}
		$loc1 = rtrim($loc1, ", ");
		
		$res_loc = [
			'country_id' => $country_id,
			'province_id' => $province_id,
			'regency_id' => $regency_id,
			'district_id' => $district_id,
			'village_id' => $village_id,
			'kode_propinsi' => $kode_propinsi,
			'loc1' => $loc1
		];
		return $res_loc;
	}

	// EDITING

function get_show_location(){
	// $user_location = $this->get_user_location();
	// $user_location_v1 = $this->get_user_location_v1();
	$id_location=$_GET['location_id'];

	$level=$_GET['level'];
	if($level==3)
	{	
		$params = "exec [dbo].[get_level_dashboard_new_v1] 2,'" . $this->user_info['text'] . "'," . $id_location . ",0,0";
	}elseif($level==4)
	{	
		$select_propinsi=$_GET['select-propinsi'];
		$params = "exec [dbo].[get_level_dashboard_new_v1] 3,'" . $this->user_info['text'] . "',". $select_propinsi . "," . $id_location . ",0";
	}if($level==5)
	{	
		$select_propinsi=$_GET['select-propinsi'];
		$select_kabupaten=$_GET['select-kabupaten'];
		$params = "exec [dbo].[get_level_dashboard_new_v1] 4,'" . $this->user_info['text'] . "',". $select_propinsi . "," . $select_kabupaten . "," . $id_location ;
	}

	$query = $this->db->query($params);
	$data = [];
	foreach  ( $query->result() as $rows ) {
		if($level==3)
		{
			$location_id=$rows->kode_kabupaten;
			$name=$rows->kabupaten;
		}elseif($level==4)
		{	$location_id=$rows->kode_kecamatan;
			$name=$rows->kecamatan;
		}if($level==5)
		{	$location_id=$rows->kode_kelurahan;
			$name=$rows->kelurahan;
		}
		$data[$location_id] = $name;
	}
	echo json_encode( $data );
}

	function data_content()
	{
		
	}

	private function _get_daily_verval($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT d.dates, COUNT(md.proses_id) total
			FROM asset.vw_date_range d
			LEFT JOIN asset.master_data_proses md ON (convert(varchar, md.lastupdate_on, 23) = d.dates)
			AND (
				md.stereotype ='MUSDES-NOT-FOUND' OR
				md.stereotype ='VERIVALI-SUBMITTED' OR
				md.stereotype ='VERIVALI-SUPERVISOR-APPROVED' OR
				md.stereotype ='VERIVALI-KORKAB-APPROVED' OR
				md.stereotype ='VERIVALI-FINAL'
			)
			AND (md.status_rumahtangga = 1 OR md.status_rumahtangga = 4) AND ($filter_area 1=1)
			WHERE d.dates <= getdate()
			GROUP BY d.dates
		";

		$query = $this->db->query($sql);
		return $query;
	}

	private function _get_progres_approval($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT d.dates, COUNT(md.proses_id) total
			FROM asset.vw_date_range d
			LEFT JOIN asset.master_data_proses md ON (convert(varchar, md.lastupdate_on, 23) = d.dates)
			AND (
				md.stereotype ='VERIVALI-SUPERVISOR-APPROVED' OR
				md.stereotype ='VERIVALI-KORKAB-APPROVED' OR
				md.stereotype ='VERIVALI-FINAL'
			)
			AND (md.status_rumahtangga = 1 OR md.status_rumahtangga = 4) AND ($filter_area 1=1)
			WHERE d.dates <= getdate()
			GROUP BY d.dates
		";

		$query = $this->db->query($sql);
		return $query;
	}

	private function _get_preslist_usulan($area)
	{
		$filter_target = $this->_filter_target_desa($area);
		$filter_query = $this->_select_area_prelist_usulan($area);

		$sql = "
			SELECT
				".$filter_query['select'].",
				SUM(td.target_desa) res_target,
				SUM(md.prelist) res_prelist,
				SUM(md.usulan_baru) res_usulan,
				SUM(md.prelist) + SUM(md.usulan_baru) res_realisasi
			FROM dbo.target_desa td
			LEFT JOIN asset.vw_rekap_realisasi md ON
				td.kdprop = md.kode_propinsi AND
				td.kdkab = md.kode_kabupaten AND
				td.kdkec = md.kode_kecamatan AND
				td.kddesa = md.kode_desa
			WHERE $filter_target 1=1
			" . $filter_query['group_by'];

		$query = $this->db->query($sql);
		return $query;
	}

	private function _get_data_musdes($area)
	{
		$filter_area = $this->_filter_target_desa($area);
		$filter_query = $this->_select_area_musdes($area);

		$sql = "
			SELECT
				".$filter_query['select']."
				COUNT(td.nm_desa) tot_desa,
				COUNT(musdes.kd_kelurahan) tot_realisasi_desa,
				SUM(td.target_desa) prelist
			FROM dbo.target_desa td
			LEFT JOIN dbo.vw_rekap_musdes musdes ON
				td.kdprop = musdes.kd_propinsi AND
				td.kdkab = musdes.kd_kabupaten AND
				td.kdkec = musdes.kd_kecamatan AND
				td.kddesa = musdes.kd_kelurahan
			WHERE $filter_area 1=1
			" . $filter_query['group'] ." ". $filter_query['order'];

		$query = $this->db->query($sql);
		return $query;
	}

	private function _get_realisasi_prelist($area)
	{
		$filter_area = $this->_filter_target_desa($area);
		$filter_query = $this->_select_area_musdes($area);

		$sql = "
			SELECT
				".$filter_query['select']."
				COUNT(md.proses_id) realisasi
			FROM dbo.target_desa td
			LEFT JOIN asset.master_data_proses md ON
				td.kdprop = md.kode_propinsi AND
				td.kdkab = md.kode_kabupaten AND
				td.kdkec = md.kode_kecamatan AND
				td.kddesa = md.kode_desa AND
				md.stereotype IN (
				'MUSDES-NOT-FOUND', 'VERIVALI-SUBMITTED', 'VERIVALI-SUPERVISOR-APPROVED', 'VERIVALI-KORKAB-APPROVED', 'VERIVALI-FINAL'
				) AND
				md.hasil_verivali IN (1,2,3,4,5,6) AND
				md.row_status	IN('COPY', 'NEW')
			WHERE $filter_area 1=1
			" . $filter_query['group'] ." ". $filter_query['order'];

		$query = $this->db->query($sql);
		return $query;
	}

	private function _filter_area($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = (!empty($area[3]))?$area[3]:0;

		$area_str = '';

		if (!empty($province_id))
			$area_str .= "md.kode_propinsi = '".$province_id."' AND ";
		if (!empty($regency_id))
			$area_str .= "md.kode_kabupaten = '".$regency_id."' AND ";
		if (!empty($district_id))
			$area_str .= "md.kode_kecamatan = '".$district_id."' AND ";
		if (!empty($village_id))
			$area_str .= "md.kode_desa = '".$village_id."' AND ";

		return $area_str;
	}

	private function _filter_target_desa($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = (!empty($area[3]))?$area[3]:0;

		$area_str = '';

		if (!empty($province_id))
		$area_str .= "td.kdprop = '".$province_id."' AND ";
		if (!empty($regency_id))
		$area_str .= "td.kdkab = '".$regency_id."' AND ";
		if (!empty($district_id))
		$area_str .= "td.kdkec = '".$district_id."' AND ";
		if (!empty($village_id))
		$area_str .= "td.kddesa = '".$village_id."' AND ";

		return $area_str;
	}

	private function _select_area_prelist_usulan($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = (!empty($area[3]))?$area[3]:0;

		if ($province_id < 1) {
			$select_str = "
				td.nm_prop nama_area,
				COUNT(DISTINCT(td.nm_kab)) tot_kabupaten,
				COUNT(DISTINCT(td.nm_kec)) tot_kecamatan,
				COUNT(DISTINCT(td.nm_desa)) tot_desa
			";
			$group = "GROUP BY td.nm_prop";

		} else if (($province_id > 0) && ($regency_id < 1) && ($district_id < 1) && ($village_id < 1)) {
			$select_str = "
				td.nm_kab nama_area,
				COUNT(DISTINCT(td.nm_kec)) tot_kecamatan,
				COUNT(DISTINCT(td.nm_desa)) tot_desa
			";
			$group = "GROUP BY td.nm_kab";

		} else if (($province_id > 0) && ($regency_id > 0) && ($district_id < 1) && ($village_id < 1)) {
			$select_str = "
				td.nm_kec nama_area,
				COUNT(DISTINCT(td.nm_desa)) tot_desa
			";
			$group = "GROUP BY td.nm_kec";

		} else if (($province_id > 0) && ($regency_id > 0) && ($district_id > 0) && ($village_id < 1)) {
			$select_str = "
				td.nm_desa nama_area
			";
			$group = "GROUP BY td.nm_desa";

		// } else if (($province_id > 0) && ($regency_id > 0) && ($district_id > 0) && ($village_id > 0)) {
		// 	$select_str = "
		// 		td.nm_desa nama_desa,
		// 		SUM(CASE WHEN md.row_status = 'COPY' THEN 1 ELSE 0 END) res_prelist,
		// 		SUM(CASE WHEN md.row_status = 'NEW' THEN 1	ELSE 0 END) res_usulan,
		// 		COUNT(md.proses_id) res_realisasi
		// 	";
		// 	$group = "";
		}

		$result = [
			'select' => $select_str,
			'group_by' => $group
		];

		return $result;
	}

	private function _select_area_musdes($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = (!empty($area[3]))?$area[3]:0;

		if ($province_id < 1) {
			$select_str = "td.nm_prop nama_area,";
			$group = "GROUP BY td.nm_prop";
			$order = "ORDER BY td.nm_prop";

		} else if (($province_id > 0) && ($regency_id < 1) && ($district_id < 1) && ($village_id < 1)) {
			$select_str = "td.nm_kab nama_area,";
			$group = "GROUP BY td.nm_kab";
			$order = "ORDER BY td.nm_kab";

		} else if (($province_id > 0) && ($regency_id > 0) && ($district_id < 1) && ($village_id < 1)) {
			$select_str = "td.nm_kec nama_area,";
			$group = "GROUP BY td.nm_kec";
			$order = "ORDER BY td.nm_kec";

		} else if (($province_id > 0) && ($regency_id > 0) && ($district_id > 0) && ($village_id < 1)) {
			$select_str = "td.nm_desa nama_area,";
			$group = "GROUP BY td.nm_desa";
			$order = "ORDER BY td.nm_desa";
		}

		$result = [
			'select' => $select_str,
			'group' => $group,
			'order' => $order
		];

		return $result;
	}

	private function _get_title_chart($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = (!empty($area[3]))?$area[3]:0;

		$title = '';
		if ($province_id < 1) {
			$title = 'Seluruh Indonesia';
		} else if (($province_id > 0) && ($regency_id < 1) && ($district_id < 1) && ($village_id < 1)) {
			$title = "Provinsi ".$this->db->get_where('target_desa', ['kdprop' => $province_id])->row('nm_prop');
		} else if (($province_id > 0) && ($regency_id > 0) && ($district_id < 1) && ($village_id < 1)) {
			$title = $this->db->get_where('target_desa', ['kdprop' => $province_id, 'kdkab' => $regency_id])->row('nm_kab') . ', '.$this->db->get_where('target_desa', ['kdprop' => $province_id])->row('nm_prop');
		} else if (($province_id > 0) && ($regency_id > 0) && ($district_id > 0) && ($village_id < 1)) {
			$title = 'KEC '. $this->db->get_where('target_desa', ['kdkec' => $district_id, 'kdkab' => $regency_id, 'kdprop' => $province_id])->row('nm_kec').', '.$this->db->get_where('target_desa', ['kdkab' => $regency_id, 'kdprop' => $province_id])->row('nm_kab').', '.$this->db->get_where('target_desa', ['kdprop' => $province_id])->row('nm_prop');
		}
		// if (!empty($village_id))
		// 	$title = "md.kode_kabupaten = '".$village_id."' AND ";

		return $title;
	}

	function rekapitulasiLastDay(){
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');

		$tot_musdes_lastday = 0;
		$tot_musdes_now = 0;
		$tot_verval_lastday = 0;
		$tot_verval_now = 0;
		$tot_approval_lastday = 0;
		$tot_approval_now = 0;
		$tot_monev_lastday = 0;
		$tot_monev_now = 0;

		$where = "";
		if(!empty($kd_prop)){
			$where .= " AND kode_propinsi = '".$kd_prop."'";	
		}
		if(!empty($kd_kab)){
			$where .= " AND kode_kabupaten = '".$kd_kab."'";
		}
		if(!empty($kd_kec)){
			$where .= " AND kode_kecamatan = '".$kd_kec."'";
		}

		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {
			$q_approval_lastday = "exec [dbo].[get_dashboard_approval_new_v1] 1,'" . $this->user_info['text'] . "',1,1,0,0,0" ;	
			$q_approval_now = "exec [dbo].[get_dashboard_approval_new_v1] 1,'" . $this->user_info['text'] . "',2,1,0,0,0" ;	

			$q_verval_lastday = "exec [dbo].[get_dashboard_verval_new_v1] 1,'" . $this->user_info['text'] . "',1,1,0,0,0" ;	
			$q_verval_now = "exec [dbo].[get_dashboard_verval_new_v1] 1,'" . $this->user_info['text'] . "',2,1,0,0,0" ;				

			$q_musdes_lastday = "exec [dbo].[get_dashboard_musdes_new_v1] 1,'" . $this->user_info['text'] . "',1,1,0,0,0" ;	
			$q_musdes_now = "exec [dbo].[get_dashboard_musdes_new_v1] 1,'" . $this->user_info['text'] . "',2,1,0,0,0" ;				
		}elseif(!empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {
			$q_approval_lastday = "exec [dbo].[get_dashboard_approval_new_v1] 2,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',0,0' ;
			$q_approval_now = "exec [dbo].[get_dashboard_approval_new_v1] 2,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',0,0' ;	

			$q_verval_lastday = "exec [dbo].[get_dashboard_verval_new_v1] 2,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',0,0' ;
			$q_verval_now = "exec [dbo].[get_dashboard_verval_new_v1] 2,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',0,0' ;			

			$q_musdes_lastday = "exec [dbo].[get_dashboard_musdes_new_v1] 2,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',0,0' ;
			$q_musdes_now = "exec [dbo].[get_dashboard_musdes_new_v1] 2,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',0,0' ;			
		}elseif(!empty($kd_prop) && !empty($kd_kab) && empty($kd_kec)) {
			$q_approval_lastday = "exec [dbo].[get_dashboard_approval_new_v1] 3,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',' . $kd_kab . ',0' ;
			$q_approval_now = "exec [dbo].[get_dashboard_approval_new_v1] 3,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',' . $kd_kab . ',0' ;		

			$q_verval_lastday = "exec [dbo].[get_dashboard_verval_new_v1] 3,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',' . $kd_kab . ',0' ;
			$q_verval_now = "exec [dbo].[get_dashboard_verval_new_v1] 3,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',' . $kd_kab . ',0' ;		

			$q_musdes_lastday = "exec [dbo].[get_dashboard_musdes_new_v1] 3,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',' . $kd_kab . ',0' ;
			$q_musdes_now = "exec [dbo].[get_dashboard_musdes_new_v1] 3,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',' . $kd_kab . ',0' ;		
		}elseif(!empty($kd_prop) && !empty($kd_kab) && !empty($kd_kec)) {
			$q_approval_lastday = "exec [dbo].[get_dashboard_approval_new_v1] 4,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	
			$q_approval_now = "exec [dbo].[get_dashboard_approval_new_v1] 4,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	

			$q_verval_lastday = "exec [dbo].[get_dashboard_verval_new_v1] 4,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	
			$q_verval_now = "exec [dbo].[get_dashboard_verval_new_v1] 4,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	

			$q_musdes_lastday = "exec [dbo].[get_dashboard_musdes_new_v1] 4,'" . $this->user_info['text'] . "',1,1," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	
			$q_musdes_now = "exec [dbo].[get_dashboard_musdes_new_v1] 4,'" . $this->user_info['text'] . "',2,1," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	

		}


		// $q_musdes_lastday = "select count(*) as total from dashboard_musdes where tgl = convert(varchar, getdate(), 23) ".$where;
		// $q_musdes_now = "select count(*) as total from dashboard_musdes where tgl <= convert(varchar, getdate(), 23) ".$where;

		$result_musdes_lastday = $this->db->query($q_musdes_lastday);
		$result_musdes_now = $this->db->query($q_musdes_now);

		$tot_musdes_lastday = $result_musdes_lastday->row()->total;
		$tot_musdes_now = $result_musdes_now->row()->total;

		// $q_verval_lastday = "select count(*) as total from dashboard_verval where tgl = convert(varchar, getdate(), 23) ".$where;
		// $q_verval_now = "select count(*) as total from dashboard_verval where tgl <= convert(varchar, getdate(), 23) ".$where;

		$result_verval_lastday = $this->db->query($q_verval_lastday);
		$result_verval_now = $this->db->query($q_verval_now);

		$tot_verval_lastday = $result_verval_lastday->row()->total;
		$tot_verval_now = $result_verval_now->row()->total;

		// $q_approval_lastday = "select count(*) as total from dashboard_approval where tgl = convert(varchar, getdate(), 23) ".$where;
		// $q_approval_now = "select count(*) as total from dashboard_approval where tgl <= convert(varchar, getdate(), 23) ".$where;

		$result_approval_lastday = $this->db->query($q_approval_lastday);
		$result_approval_now = $this->db->query($q_approval_now);

		$tot_approval_lastday = $result_approval_lastday->row()->total;
		$tot_approval_now = $result_approval_now->row()->total;

		$return_data = array(
			'tot_musdes_lastday'=>number_format($tot_musdes_lastday,0),
			'tot_musdes_now'=>number_format($tot_musdes_now,0),
			'tot_verval_lastday'=>number_format($tot_verval_lastday,0),
			'tot_verval_now'=>number_format($tot_verval_now,0),
			'tot_approval_lastday'=>number_format($tot_approval_lastday,0),
			'tot_approval_now'=>number_format($tot_approval_now,0),
			'tot_monev_lastday'=>number_format($tot_monev_lastday,0),
			'tot_monev_now'=>number_format($tot_monev_now,0)
		);

		echo json_encode($return_data);
	}

	function rekapWilayah(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$return_data = array();


		$data = $this->targetVsRealisasiPerPROP();

		if(!empty($kd_prop)){
			$data = $this->targetVsRealisasiPerKAB($kd_prop);
		}
		if(!empty($kd_kab)){
			$data = $this->targetVsRealisasiPerKEC($kd_prop,$kd_kab);
		}
		if(!empty($kd_kec)){
			$data = $this->targetVsRealisasiPerDESA($kd_prop,$kd_kab,$kd_kec);
		}
		$return_data = array(
			"wilayah"=>array(),
			"realisasi"=>array(),
			"target"=>array()
		);


		$total_relisasi = 0;
		$total_target = 0;
		foreach($data as $key => $value) {
			$return_data['wilayah'][] = $value['name'];
			$return_data['realisasi'][] = $value['TOTAL_REALISASI'];
			$return_data['target'][] = $value['TOTAL_TARGET'] - $value['TOTAL_REALISASI'];
			$total_relisasi += $value['TOTAL_REALISASI'];
			$total_target += ($value['TOTAL_TARGET']);
		}

		$return_data['total'] = array($total_relisasi,$total_target); 
		$return_data['label'] = array("REALISASI","TARGET");

		echo json_encode($return_data);
	}

	function targetVsRealisasiPerPROP(){
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();
		$query = "exec [get_dashboard_targetVsRealisasi_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		$result = $this->db->query($query)->result_array();
		return $result;

		// echo json_encode($result);
		print_r($result);

	}
	function targetVsRealisasiPerKAB($kd_prop){
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();
		$query = "exec [get_dashboard_targetVsRealisasi_new_v1] 2,'" . $this->user_info['text'] . "',$kd_prop,0,0";				   
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	function targetVsRealisasiPerKEC($kd_prop,$kd_kab){
	   // $user_location = $this->get_user_location();
	   // $user_location_v1 = $this->get_user_location_v1();
	   $query = "exec [get_dashboard_targetVsRealisasi_new_v1] 3,'" . $this->user_info['text'] . "',$kd_prop,$kd_kab,0";
	   $result = $this->db->query($query)->result_array();
	   return $result;
	}
	function targetVsRealisasiPerDESA($kd_prop,$kd_kab,$kd_kec){
	   // $user_location = $this->get_user_location();
	   // $user_location_v1 = $this->get_user_location_v1();
       $query = "exec [get_dashboard_targetVsRealisasi_new_v1] 4,'" . $this->user_info['text'] . "',$kd_prop,$kd_kab,$kd_kec";			   
	   $result = $this->db->query($query)->result_array();
	   return $result;
	}

	function rekapHarianMusdes(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$return_data = array();

		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();

		$where = "";
		if(!empty($kd_prop)){
			$where .= " AND kode_propinsi = '".$kd_prop."'";
		}
		if(!empty($kd_kab)){
			$where .= " AND kode_kabupaten = '".$kd_kab."'";
		}
		if(!empty($kd_kec)){
			$where .= " AND kode_kecamatan = '".$kd_kec."'";
		}

		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {
			
			$qAkumulasi = "exec [dbo].[get_dashboard_musdes_new_v1] 1,'" . $this->user_info['text'] . "',4,3,0,0,0" ;	
			$qReal = "exec [dbo].[get_dashboard_musdes_new_v1] 1,'" . $this->user_info['text'] . "',3,2,0,0,0" ;	

		}if(!empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {

			$qAkumulasi = "exec [dbo].[get_dashboard_musdes_new_v1] 2,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',0,0' ;
			$qReal = "exec [dbo].[get_dashboard_musdes_new_v1] 2,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',0,0' ;

		}elseif(!empty($kd_prop) && !empty($kd_kab) && empty($kd_kec)) {

			$qAkumulasi = "exec [dbo].[get_dashboard_musdes_new_v1] 3,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',' . $kd_kab . ',0' ;
			$qReal = "exec [dbo].[get_dashboard_musdes_new_v1] 3,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',' . $kd_kab . ',0' ;

		}elseif(!empty($kd_prop) && !empty($kd_kab) && !empty($kd_kec)) {
			
			$qAkumulasi = "exec [dbo].[get_dashboard_musdes_new_v1] 4,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	
			$qReal = "exec [dbo].[get_dashboard_musdes_new_v1] 4,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	

		}else

		for ($i=6; $i >= 0; $i--) {
			$return_data['tgl'][] = date('d M', strtotime('-'.$i.' days'));
			$return_data['realisasi_harian'][] = 0;
			$return_data['realisasi_akumulasi'][] = 0;
			$return_data['target_akumulasi'][] = 0;
			$return_data['target_harian'][] = 0;
		}
		//GET TOTAL REALISASI AKUMULASI SEBELUM 7 HARI


		// $qAkumulasi = "select SUM(TOTAL_REALISASI) as TOTAL  from (
		// 			SELECT TGL,COUNT( * ) as TOTAL_REALISASI FROM dashboard_musdes
		// 			WHERE TGL <= ( GETDATE() - 7 ) ".$where."  GROUP BY TGL
		// 		   ) A";
	    $result_akumulasi = $this->db->query($qAkumulasi)->row();


		//GET REALISASI
		// $qReal = "SELECT TGL,COUNT( * ) as TOTAL_REALISASI FROM dashboard_musdes
		// 	  WHERE TGL >= ( GETDATE() - 7 )  AND TGL <= GETDATE()  ".$where." GROUP BY TGL";

	    $result_realisasi = $this->db->query($qReal)->result_array();
		foreach ($result_realisasi as $key => $value) {
				$return_data['realisasi_harian'][$key] = $value['TOTAL_REALISASI'];
				if($key == 0){
					$return_data['realisasi_akumulasi'][$key] = $result_akumulasi->TOTAL + $value['TOTAL_REALISASI'];
				}else{
					$return_data['realisasi_akumulasi'][$key] = $return_data['realisasi_akumulasi'][$key-1] + $value['TOTAL_REALISASI'];
				}
		}

		//GET TARGET

		// $where = "";
		// if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
		// 	$where = "";
		// }else{
		// 	if(!empty($kd_prop)){
		// 		$where .= " AND kdprop = '".$kd_prop."'";
		// 	}
		// 	if(!empty($kd_kab)){
		// 		$where .= " AND kdkab = '".$kd_kab."'";
		// 	}
		// 	if(!empty($kd_kec)){
		// 		$where .= " AND kdkec = '".$kd_kec."'";
		// 	}
		// 	$where = 'WHERE'.substr($where,4);
		// }

		// $qAllTarget = "select SUM(target_desa) as TOTAL_TARGET from target_desa ".$where;

		// $params = "exec [dbo].[get_level_dashboard_v1] 4," . $select_propinsi . ','. $select_kabupaten . ',' . $id_location ;
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		}else{
			if(!empty($kd_prop)){
				
				$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 2,'" . $this->user_info['text'] . "',".$kd_prop.",0,0" ;
			}
			if(!empty($kd_kab)){
				$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 3,'" . $this->user_info['text'] . "',".$kd_prop.",".$kd_kab.",0" ;
			}
			if(!empty($kd_kec)){
				$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 4,'" . $this->user_info['text'] . "',".$kd_prop.",".$kd_kab.",".$kd_kec ;
			}
		}
	    $result_all_target = $this->db->query($qAllTarget)->row();


		$qTarget = "exec [dbo].[stp_tgt_verval_musdes]";
	    $result_target = $this->db->query($qTarget)->row();
		if(!empty($result_target)){
			if(!empty($result_target->MULAI_MUSDES) && !empty($result_target->AKHIR_MUSDES)){
				if($result_target->HARI_MUSDES === 0){
					$targetperhari = 0;
				}else{
 					$targetperhari = ceil($result_all_target->TOTAL_TARGET/$result_target->HARI_MUSDES);
				}
			   //SET TARGET HARIAN
			   for ($i=6; $i >= 0; $i--) {
			   	 $return_data['target_harian'][$i] = $targetperhari;
			   }
			   if($result_target->HARI_MUSDES > 0){
				   //SET TARGET AKUMULASI
				   foreach ($result_realisasi as $key => $value) {
						$start = strtotime($value['TGL']);
						$end  =  strtotime($result_target->MULAI_MUSDES);
				 		$datediff = ceil(abs($end - $start) / 86400);

						//total target - realisasi dri tgl sekarang - mulai musdes
					    $akumulasi = ($datediff * $targetperhari) - $result_akumulasi->TOTAL;
						if($key == 0){
					    	$return_data['target_akumulasi'][$key] = $akumulasi;
						}else{
							$total_sebelumnya = $return_data['target_akumulasi'][$key-1] - $return_data['realisasi_akumulasi'][$key-1];
							$return_data['target_akumulasi'][$key] = $akumulasi + $total_sebelumnya;
						}
				   }
			   }
		   }else{
			   for ($i=6; $i >= 0; $i--) {
				   $return_data['target_harian'][$i] = 0;
				   $return_data['target_akumulasi'][$i] = 0;
		   		}
		   }
		}
		echo json_encode($return_data);
	}

	function rekapHarianVerval(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$return_data = array();
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();

		$where = "";

		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {
			
			$qAkumulasi = "exec [dbo].[get_dashboard_verval_new_v1] 1,'" . $this->user_info['text'] . "',4,3,0,0,0" ;	
			$qReal = "exec [dbo].[get_dashboard_verval_new_v1] 1,'" . $this->user_info['text'] . "',3,2,0,0,0" ;	

		}elseif(!empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {

			$qAkumulasi = "exec [dbo].[get_dashboard_verval_new_v1] 2,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',0,0' ;
			$qReal = "exec [dbo].[get_dashboard_verval_new_v1] 2,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',0,0' ;

		}elseif(!empty($kd_prop) && !empty($kd_kab) && empty($kd_kec)) {

			$qAkumulasi = "exec [dbo].[get_dashboard_verval_new_v1] 3,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',' . $kd_kab . ',0' ;
			$qReal = "exec [dbo].[get_dashboard_verval_new_v1] 3,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',' . $kd_kab . ',0' ;

		}elseif(!empty($kd_prop) && !empty($kd_kab) && !empty($kd_kec)) {
			
			$qAkumulasi = "exec [dbo].[get_dashboard_verval_new_v1] 4,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	
			$qReal = "exec [dbo].[get_dashboard_verval_new_v1] 4,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	

		}		


		for ($i=6; $i >= 0; $i--) {
			$return_data['tgl'][] = date('d M', strtotime('-'.$i.' days'));
			$return_data['realisasi_harian'][] = 0;
			$return_data['realisasi_akumulasi'][] = 0;
			$return_data['target_akumulasi'][] = 0;
			$return_data['target_harian'][] = 0;
		}
		//GET TOTAL REALISASI AKUMULASI SEBELUM 7 HARI
		// $qAkumulasi = "select SUM(TOTAL_REALISASI) as TOTAL  from (
		// 			SELECT TGL,COUNT( * ) as TOTAL_REALISASI FROM dashboard_verval
		// 			WHERE TGL <= ( GETDATE() - 7 ) ".$where."  GROUP BY TGL
		// 		   ) A";
	    $result_akumulasi = $this->db->query($qAkumulasi)->row();


		//GET REALISASI
		// $qReal = "SELECT TGL,COUNT( * ) as TOTAL_REALISASI FROM dashboard_verval
		// 	  WHERE TGL >= ( GETDATE() - 7 )  AND TGL <= GETDATE()  ".$where." GROUP BY TGL";
	    $result_realisasi = $this->db->query($qReal)->result_array();
		foreach ($result_realisasi as $key => $value) {
				$return_data['realisasi_harian'][$key] = $value['TOTAL_REALISASI'];
				if($key == 0){
					$return_data['realisasi_akumulasi'][$key] = $result_akumulasi->TOTAL + $value['TOTAL_REALISASI'];
				}else{
					$return_data['realisasi_akumulasi'][$key] = $return_data['realisasi_akumulasi'][$key-1] + $value['TOTAL_REALISASI'];
				}
		}

		//GET TARGET

		// $where = "";
		// if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
		// 	$where = "";
		// }else{
		// 	if(!empty($kd_prop)){
		// 		$where .= " AND kdprop = '".$kd_prop."'";
		// 	}
		// 	if(!empty($kd_kab)){
		// 		$where .= " AND kdkab = '".$kd_kab."'";
		// 	}
		// 	if(!empty($kd_kec)){
		// 		$where .= " AND kdkec = '".$kd_kec."'";
		// 	}
		// 	$where = 'WHERE'.substr($where,4);
		// }

		// $qAllTarget = "select SUM(target_desa) as TOTAL_TARGET from target_desa ".$where;

		// $result_all_target = $this->db->query($qAllTarget)->row();

		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		}else{
			if(!empty($kd_prop)){
				
				$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 2,'" . $this->user_info['text'] . "',".$kd_prop.",0,0" ;
			}
			if(!empty($kd_kab)){
				$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 3,'" . $this->user_info['text'] . "',".$kd_prop.",".$kd_kab.",0" ;
			}
			if(!empty($kd_kec)){
				$qAllTarget = "exec [dbo].[stp_sum_target_desa_new_v1] 4,'" . $this->user_info['text'] . "',".$kd_prop.",".$kd_kab.",".$kd_kec ;
			}
		}
	    $result_all_target = $this->db->query($qAllTarget)->row();

		$qTarget = "exec [dbo].[stp_tgt_verval_musdes]";
	    $result_target = $this->db->query($qTarget)->row();
		if(!empty($result_target)){
			if(!empty($result_target->MULAI_VERVAL) && !empty($result_target->AKHIR_VERVAL)){
				if($result_target->HARI_VERVAL === 0){
					$targetperhari = 0;
				}else{
					$targetperhari = ceil($result_all_target->TOTAL_TARGET/$result_target->HARI_VERVAL);
					//SET TARGET HARIAN
	 			   for ($i=6; $i >= 0; $i--) {
	 			   	 $return_data['target_harian'][$i] = $targetperhari;
	 			   }

	 			   //SET TARGET AKUMULASI
	 			   foreach ($result_realisasi as $key => $value) {
	 					$start = strtotime($value['TGL']);
	 					$end  =  strtotime($result_target->MULAI_MUSDES);
	 			 		$datediff = ceil(abs($end - $start) / 86400);

	 					//total target - realisasi dri tgl sekarang - mulai musdes
	 				    $akumulasi = ($datediff * $targetperhari) - $result_akumulasi->TOTAL;
	 					if($key == 0){
	 				    	$return_data['target_akumulasi'][$key] = $akumulasi;
	 					}else{
	 						$total_sebelumnya = $return_data['target_akumulasi'][$key-1] - $return_data['realisasi_akumulasi'][$key-1];
	 						$return_data['target_akumulasi'][$key] = $akumulasi + $total_sebelumnya;
	 					}
	 			   }
				}
		   }else{
			   for ($i=6; $i >= 0; $i--) {
				   $return_data['target_harian'][$i] = 0;
				   $return_data['target_akumulasi'][$i] = 0;
		   		}
		   }
		}
		echo json_encode($return_data);
	}

	function rekapHarianApproval(){
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$return_data = array();

		$where = "";

		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {
			
			$qAkumulasi = "exec [dbo].[get_dashboard_approval_new_v1] 1,'" . $this->user_info['text'] . "',4,3,0,0,0" ;	
			$qReal = "exec [dbo].[get_dashboard_approval_new_v1] 1,'" . $this->user_info['text'] . "',3,2,0,0,0" ;	

		}if(!empty($kd_prop) && empty($kd_kab) && empty($kd_kec)) {

			$qAkumulasi = "exec [dbo].[get_dashboard_approval_new_v1] 2,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',0,0' ;
			$qReal = "exec [dbo].[get_dashboard_approval_new_v1] 2,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',0,0' ;

		}elseif(!empty($kd_prop) && !empty($kd_kab) && empty($kd_kec)) {

			$qAkumulasi = "exec [dbo].[get_dashboard_approval_new_v1] 3,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',' . $kd_kab . ',0' ;
			$qReal = "exec [dbo].[get_dashboard_approval_new_v1] 3,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',' . $kd_kab . ',0' ;

		}elseif(!empty($kd_prop) && !empty($kd_kab) && !empty($kd_kec)) {
			
			$qAkumulasi = "exec [dbo].[get_dashboard_approval_new_v1] 4,'" . $this->user_info['text'] . "',4,3," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	
			$qReal = "exec [dbo].[get_dashboard_approval_new_v1] 4,'" . $this->user_info['text'] . "',3,2," . $kd_prop . ',' . $kd_kab . ',' . $kd_kec ;	

		}		

		for ($i=6; $i >= 0; $i--) {
			$return_data['tgl'][] = date('d M', strtotime('-'.$i.' days'));
			$return_data['realisasi_harian'][] = 0;
			$return_data['realisasi_akumulasi'][] = 0;
			$return_data['target_akumulasi'][] = 0;
			$return_data['target_harian'][] = 0;
		}
		//GET TOTAL REALISASI AKUMULASI SEBELUM 7 HARI
		// $qAkumulasi = "select SUM(TOTAL_REALISASI) as TOTAL  from (
		// 			SELECT TGL,COUNT( * ) as TOTAL_REALISASI FROM dashboard_approval
		// 			WHERE TGL <= ( GETDATE() - 7 ) ".$where."  GROUP BY TGL
		// 		   ) A";
	    $result_akumulasi = $this->db->query($qAkumulasi)->row();


		//GET REALISASI
		// $qReal = "SELECT TGL,COUNT( * ) as TOTAL_REALISASI FROM dashboard_approval
		// 	  WHERE TGL >= ( GETDATE() - 7 )  AND TGL <= GETDATE()  ".$where." GROUP BY TGL";
	    $result_realisasi = $this->db->query($qReal)->result_array();
		foreach ($result_realisasi as $key => $value) {
				$return_data['realisasi_harian'][$key] = $value['TOTAL_REALISASI'];
				if($key == 0){
					$return_data['realisasi_akumulasi'][$key] = $result_akumulasi->TOTAL + $value['TOTAL_REALISASI'];
				}else{
					$return_data['realisasi_akumulasi'][$key] = $return_data['realisasi_akumulasi'][$key-1] + $value['TOTAL_REALISASI'];
				}
		}

		//GET TARGET

		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kdprop = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kdkab = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kdkec = '".$kd_kec."'";
			}
			$where = 'WHERE'.substr($where,4);
		}

		$qAllTarget = "select SUM(target_desa) as TOTAL_TARGET from target_desa ".$where;
	    $result_all_target = $this->db->query($qAllTarget)->row();


		$qTarget = "exec [dbo].[stp_tgt_verval_musdes]";
	    $result_target = $this->db->query($qTarget)->row();
		if(!empty($result_target)){
			if(!empty($result_target->MULAI_VERVAL) && !empty($result_target->AKHIR_VERVAL)){
			   if($result_target->HARI_APPROVAL > 0){
				   $targetperhari = ceil($result_all_target->TOTAL_TARGET/$result_target->HARI_VERVAL);
				   //SET TARGET HARIAN
				   for ($i=6; $i >= 0; $i--) {
				   	 $return_data['target_harian'][$i] = $targetperhari;
				   }

				   //SET TARGET AKUMULASI
				   foreach ($result_realisasi as $key => $value) {
						$start = strtotime($value['TGL']);
						$end  =  strtotime($result_target->MULAI_MUSDES);
				 		$datediff = ceil(abs($end - $start) / 86400);

						//total target - realisasi dri tgl sekarang - mulai musdes
					    $akumulasi = ($datediff * $targetperhari) - $result_akumulasi->TOTAL;
						if($key == 0){
					    	$return_data['target_akumulasi'][$key] = $akumulasi;
						}else{
							$total_sebelumnya = $return_data['target_akumulasi'][$key-1] - $return_data['realisasi_akumulasi'][$key-1];
							$return_data['target_akumulasi'][$key] = $akumulasi + $total_sebelumnya;
						}
				   }
			   }
		   }else{
			   for ($i=6; $i >= 0; $i--) {
		   			$return_data['target_harian'][$i] = 0;
		   			$return_data['target_akumulasi'][$i] = 0;
		   		}
		   }
		}
		echo json_encode($return_data);
	}

	function rekapMusdesVerval(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$return_data = array();
		// $user_location = $this->get_user_location();
		// $user_location_v1 = $this->get_user_location_v1();

		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$rekap_musdes = "exec [dbo].[stp_realisasi_desa_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		}else{
			if (!empty($kd_prop)) {
				
				$rekap_musdes = "exec [dbo].[stp_realisasi_desa_new_v1] 2,'" . $this->user_info['text'] . "',".$kd_prop.",0,0";
			}
			if (!empty($kd_kab)) {
				$rekap_musdes = "exec [dbo].[stp_realisasi_desa_new_v1] 3,'" . $this->user_info['text'] . "',".$kd_prop.",".$kd_kab.",0";
			}
			if (!empty($kd_kec)) {
				$rekap_musdes = "exec [dbo].[stp_realisasi_desa_new_v1] 4,'" . $this->user_info['text'] . "',".$kd_prop.",".$kd_kab.",".$kd_kec;
			}
		}	

	   $result = $this->db->query($rekap_musdes)->result_array();
 
	   $return_data = array(
		   "result"=>$result 
	   );
	   
	   echo json_encode($return_data);
	   
	}

}


