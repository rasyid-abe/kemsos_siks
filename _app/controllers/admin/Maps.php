<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'admin/maps/' );
	}

	function index() {
		$this->show();

	}

	function show() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['title'] = 'MAPS';
		$data['cari'] = $this->form_cari();
		$data['base_url'] = base_url();
		$data['base_photo_url'] = "http://66.96.235.136:8080/apiverval/";
		$data['extra_script'] = '
		<script>
		$(document).ready( function(){
			$("#select-propinsi").on( "change", function(){
				let params = {
					"bps_province_code": $(this).val(),
					"stereotype": "REGENCY",
					"title": "Kabupaten",
				}
				if ( $(this).val() == "0" ) {
					$( "#select-kabupaten ").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
				} else {
					get_location(params);
				}
				$( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
				$( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
			});

			$("#select-kabupaten").on( "change", function(){
				let params = {
					"bps_province_code": $("#select-propinsi").val(),
					"bps_regency_code": $(this).val(),
					"stereotype": "DISTRICT",
					"title": "Kecamatan",
				}
				if ( $(this).val() == "0" ) {
					$( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
				} else {
					get_location(params);
				}
				$( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
			});

			$("#select-kecamatan").on( "change", function(){
				let params = {
					"bps_province_code": $("#select-propinsi").val(),
					"bps_regency_code": $("#select-kabupaten").val(),
					"bps_district_code": $(this).val(),
					"stereotype": "VILLAGE",
					"title": "Kelurahan",
				}
				if ( $(this).val() == "0" ) {
					$( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
				} else {
					get_location(params);
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
						let option = `<option value="0"> -- Pilih ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
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

		$this->template->title( 'Peta Sebaran Data' );
		// $this->template->content( "admin/maps", $data );
		$this->template->content( "admin/new-maps", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function form_cari() {
		$user_location = $this->get_user_location();
		$jml_negara = count( explode( ',', $user_location['country_id'] ) );
		$jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
		$jml_kota = count( explode( ',', $user_location['regency_id'] ) );
		$jml_kecamatan = count( explode( ',', $user_location['district_id'] ) );
		$jml_kelurahan = count( explode( ',', $user_location['village_id'] ) );

		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_status = '<option value="0">Semua Status</option>';
		$option_hasil_musdes = '<option value="0">Semua Hasil Musdes</option>';
		$option_hasil_verivali = '<option value="0">Semua Hasil Verivali</option>';

		$where_propinsi = [];

		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'asset.vw_administration_regions',
			'select' => 'DISTINCT kode_propinsi, propinsi',
			'where' => $where_propinsi,
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
			if ( $jml_propinsi == '1' && ! empty( $user_location['province_id'] ) ) {
				$option_propinsi = '<option value="' . $value->kode_propinsi . '" selected>' . $value->propinsi . '</option>';
			} else {
				$option_propinsi .= '<option value="' . $value->kode_propinsi . '">' . $value->propinsi . '</option>';
			}
		}


		if ( $jml_propinsi == '1' ) {
			$where_kota = [];
			if ( ! empty( $user_location['regency_id'] ) ) {
				if ( $jml_kota > '0' ) $where_kota['regency_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;
			} else {
				$where_kota['province_id'] = $user_location['province_id'];
			}
			$params_kota = [
				'table' => 'asset.vw_administration_regions',
				'select' => 'DISTINCT kode_kabupaten, kabupaten',
				'where' => $where_kota,
			];
			$query_kota = get_data( $params_kota );
			foreach ( $query_kota->result() as $key => $value ) {
				if ( $jml_kota == '1' && ! empty( $user_location['regency_id'] ) ) {
					$option_kota = '<option value="' . $value->kode_kabupaten . '" selected>' . $value->kabupaten . '</option>';
				} else {
					$option_kota .= '<option value="' . $value->kode_kabupaten . '">' . $value->kabupaten . '</option>';
				}
			}
		}

		if ( $jml_kota == '1' ) {
			$where_kecamatan = [];
			if ( ! empty( $user_location['district_id'] ) ) {
				if ( $jml_kecamatan > '0' ) $where_kecamatan['district_id ' . ( ( $jml_kecamatan >= '2' ) ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}" )] = null;
			} else {
				$where_kecamatan['regency_id'] = $user_location['regency_id'];
			}
			$params_kecamatan = [
				'table' => 'asset.vw_administration_regions',
				'select' => 'DISTINCT kode_kecamatan, kecamatan',
				'where' => $where_kecamatan,
			];
			$query_kecamatan = get_data( $params_kecamatan );
			foreach ( $query_kecamatan->result() as $key => $value ) {
				if ( $jml_kecamatan == '1' && ! empty( $user_location['district_id'] ) ) {
					$option_kecamatan = '<option value="' . $value->kode_kecamatan . '" selected>' . $value->kecamatan . '</option>';
				} else {
					$option_kecamatan .= '<option value="' . $value->kode_kecamatan . '">' . $value->kecamatan . '</option>';
				}
			}
		}

		if (  $jml_kecamatan == '1' ) {
			$where_kelurahan = [];
			if ( ! empty( $user_location['village_id'] ) ) {
				if ( $jml_kelurahan > '0' ) $where_kelurahan['village_id ' . ( ( $jml_kelurahan >= '2' ) ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}" )] = null;
			} else {
				$where_kelurahan['district_id'] = $user_location['district_id'];
			}
			$params_kelurahan = [
				'table' => 'asset.vw_administration_regions',
				'select' => 'DISTINCT village_id, kelurahan',
				'where' => $where_kelurahan,
			];
			$query_kelurahan = get_data( $params_kelurahan );
			foreach ( $query_kelurahan->result() as $key => $value ) {
				if ( $jml_kelurahan == '1' && ! empty( $user_location['village_id'] ) ) {
					$option_kelurahan = '<option value="' . $value->village_id . '" selected>' . $value->kelurahan . '</option>';
				} else {
					$option_kelurahan .= '<option value="' . $value->village_id . '">' . $value->kelurahan . '</option>';
				}
			}
		} 

		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
					<div class="form-group col-md-3">
						<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_propinsi . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" ' . ( ( ( $jml_kota == '1' ) && ( ! empty( $user_location['regency_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kota . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kecamatan == '1' ) && ( ! empty( $user_location['district_id'] ) ) ) ? 'disabled ' : '' ) . '>
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

	function get_user_location() {
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '0';
		$regency_id = '0';
		$district_id = '0';
		$village_id = '0';
		if ( ! empty( $user_location ) ) {
			$count = count( $user_location );
			$no = 1;
			foreach ( $user_location as $loc ) {
				$params_location = [
					'table' => 'dbo.ref_locations',
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
				$no++;
			}
		}
		$res_loc = [
			'country_id' => $country_id,
			'province_id' => $province_id,
			'regency_id' => $regency_id,
			'district_id' => $district_id,
			'village_id' => $village_id,
		];
		return $res_loc;
	}

	function get_show_location(){
		if ($_GET['title'] == "Kabupaten") {
			$select = 'bps_regency_code';
			$params = [
				'table' => 'ref_locations',
				'where' => [
					'bps_province_code' => $_GET['bps_province_code'],
					'stereotype' => $_GET['stereotype']
				],
				'select' => $select . ', full_name',
			];
		} elseif ($_GET['title'] == "Kecamatan") {
			$select = 'bps_district_code';
			$params = [
				'table' => 'ref_locations',
				'where' => [
					'bps_province_code' => $_GET['bps_province_code'],
					'bps_regency_code' => $_GET['bps_regency_code'],
					'stereotype' => $_GET['stereotype']
				],
				'select' => $select . ', full_name',
			];
		} elseif ($_GET['title'] == "Kelurahan") {
			$select = 'bps_village_code';
			$params = [
				'table' => 'ref_locations',
				'where' => [
					'bps_province_code' => $_GET['bps_province_code'],
					'bps_regency_code' => $_GET['bps_regency_code'],
					'bps_district_code' => $_GET['bps_district_code'],
					'stereotype' => $_GET['stereotype']
				],
				'select' => $select . ', full_name',
			];
		}

		$query = get_data( $params );
		$data = [];
		foreach ( $query->result_array() as $key => $value ) {
			$data[$value[$select]] = $value['full_name'];
		}
		echo json_encode( $data );
	}

	function data_content()
	{
		$area = $this->input->post('area');

		$data_musdes = $this->_get_geotag_musdes($area);
		$data_ruta = $this->_get_geotag_ruta($area);

		$chart_hasil_verval = $this->_get_hasil_verval($area);
		$data_prelist_akhir = $this->_get_musdes_a($area, "'NEW', 'COPY'", "");

		$data_tidak_mampu = $this->_get_musdes_a($area,  "'COPY'", "");
		$data_mampu = $this->_get_musdes_a($area,  "'COPY'", "AND md.apakah_mampu = '1'");
		$data_tidak_ditemukan = $this->_get_musdes_b($area, 2);
		$data_ganda = $this->_get_musdes_b($area,  3);
		$data_prelist_awal = $data_tidak_mampu + $data_mampu + $data_tidak_ditemukan + $data_ganda;
		$data_valid_musdes = $data_tidak_mampu;
		$data_invalid_musdes = $data_mampu + $data_tidak_ditemukan + $data_ganda;
		$data_usulan_baru = $this->_get_musdes_a($area,  "'NEW'", "");
		$total_prelist = $this->_get_total_prelist($area);

		$chart_musdes = [
			'ditemukan_tidak_mampu' => $data_tidak_mampu,
			'ditemukan_mampu' => $data_mampu,
			'tidak_ditemukan' => $data_tidak_ditemukan,
			'data_ganda' => $data_ganda,
			'prelist_awal' => $data_prelist_awal,
			'valid_musdes' => $data_valid_musdes,
			'invalid_musdes' => $data_invalid_musdes,
			'usulan_baru' => $data_usulan_baru,
			'prelist_akhir' => $data_prelist_akhir,
			'total_prelist' => $total_prelist
		];

		if (!empty($data_musdes)) {
			$get_koor = $data_musdes[0];
			$lat = $get_koor['latitude'];
			$lang = $get_koor['longitude'];
		} else if (!empty($data_ruta)) {
			$get_koor = $data_ruta[0];
			$lat = $get_koor['lat'];
			$lang = $get_koor['long'];
		}


		if ($area[2] > 0) {

			$result = [
				'lat' => $lat,
				'lang' => $lang,
				'musdes' => $data_musdes,
				'ruta' => $data_ruta,
				'chart_hasil_verval' => $chart_hasil_verval,
				'data_prelist_akhir' => $data_prelist_akhir,
				'chart_musdes' => $chart_musdes,
				'message' => 'ok',
				'status' => 200
			];

		} else {

			$result = [
				'chart_hasil_verval' => $chart_hasil_verval,
				'data_prelist_akhir' => $data_prelist_akhir,
				'chart_musdes' => $chart_musdes,
				'message' => 'ok',
				'status' => 200
			];
		}

		echo json_encode($result);
	}

	private function _get_geotag_ruta($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT * FROM asset.vw_geotag_ruta geotag WHERE lat <> ''
			AND $filter_area 1=1
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_geotag_musdes($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT * FROM asset.vw_geotag_musdes geotag WHERE latitude <> ''
			AND $filter_area 1=1
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_hasil_verval($area)
	{
		$filter_area = $this->_filter_chart_area($area);

		$sql = "
		SELECT
			COUNT(md.proses_id) total,
			SUM( CASE WHEN md.hasil_verivali = 1 THEN 1 ELSE 0 END ) selesai_dicacah,
			SUM( CASE WHEN md.hasil_verivali = 2 THEN 1 ELSE 0 END ) tidak_ditemukan,
			SUM( CASE WHEN md.hasil_verivali = 3 THEN 1 ELSE 0 END ) rt_pindah,
			SUM( CASE WHEN md.hasil_verivali = 4 THEN 1 ELSE 0 END ) bagian_dokumen,
			SUM( CASE WHEN md.hasil_verivali = 5 THEN 1 ELSE 0 END ) menolak,
			SUM( CASE WHEN md.hasil_verivali = 6 THEN 1 ELSE 0 END ) ganda
		FROM
			asset.master_data_proses md
		WHERE
			stereotype IN (
				'VERIVALI-SUBMITTED',
				'VERIVALI-SUPERVISOR-APPROVED',
				'VERIVALI-KORKAB-APPROVED',
				'VERIVALI-FINAL'
			) AND $filter_area
			hasil_verivali <> 0 AND row_status IN ('NEW', 'COPY')
		";

		$query = $this->db->query($sql);
		return $query->row_array();
	}

	private function _get_musdes_a($area, $row_status, $status_ruta)
	{
		$filter_area = $this->_filter_chart_area($area);

		$sql = "
		SELECT
			COUNT(md.proses_id) AS total
			FROM asset.master_data_proses md
		WHERE
			stereotype IN (
				'MUSDES-SUBMITTED',
				'VERIVALI-PUBLISHED',
				'VERIVALI-REVOKED',
				'VERIVALI-GRABBED',
				'VERIVALI-GRAB-REVOKED',
				'VERIVALI-DOWNLOADED',
				'VERIVALI-DOWNLOAD-REVOKED',
				'VERIVALI-SURVEY',
				'VERIVALI-SURVEY-REVOKED',
				'VERIVALI-SUBMITTED',
				'VERIVALI-SUPERVISOR-APPROVED',
				'VERIVALI-KORKAB-REJECTED',
				'VERIVALI-KORKAB-APPROVED',
				'VERIVALI-KORWIL-REJECTED',
				'VERIVALI-PENDING-QC-PUSAT',
				'VERIVALI-FINAL'
				)
			AND $filter_area md.row_status IN ($row_status) $status_ruta
			";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_musdes_b($area, $status)
	{
		$filter_area = $this->_filter_chart_area($area);

		$sql = "
		SELECT
			COUNT(md.proses_id) AS total
		FROM asset.master_data_proses md
		WHERE $filter_area
			md.stereotype = 'MUSDES-NOT-FOUND' AND  md.status_rumahtangga = $status
		";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_total_prelist($area)
	{
		$filter_area = $this->_filter_chart_area($area);

		$sql = "
			SELECT COUNT
				( md.proses_id ) prelist_akhir
			FROM
				asset.master_data_proses md
			WHERE $filter_area 1=1
		";

		$query = $this->db->query($sql);
		return $query->row('prelist_akhir');
	}

	private function _filter_area($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = $area[3];

		$area_str = '';

		if (!empty($province_id))
			$area_str .= "geotag.kd_propinsi = '".$province_id."' AND ";
		if (!empty($regency_id))
			$area_str .= "geotag.kd_kabupaten = '".$regency_id."' AND ";
		if (!empty($district_id))
			$area_str .= "geotag.kd_kecamatan = '".$district_id."' AND ";
		if (!empty($village_id))
			$area_str .= "geotag.kd_kelurahan = '".$village_id."' AND ";

		return $area_str;
	}

	private function _filter_chart_area($area)
	{
		$province_id = $area[0];
		$regency_id = $area[1];
		$district_id = $area[2];
		$village_id = $area[3];

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

	public function getLatLongPrelist(){
		ini_set('memory_limit', '-1');
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND master_data_proses.kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND master_data_proses.kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND master_data_proses.kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND master_data_proses.kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q = "select   proses_id,lat,long from asset.master_data_proses
				WHERE lat IS NOT NULL  AND  long IS NOT NULL AND (lat !=' '  AND  long !=' ') AND lat != 'NULL'  AND long != 'NULL' AND
				( master_data_proses.hasil_verivali = 1
				OR master_data_proses.hasil_verivali = 4 ) 
			   AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
					   OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
					   OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
					   OR master_data_proses.stereotype = 'VERIVALI-FINAL'
			   ) ".$where;
		$result_verval = $this->db->query($q)->result_array();

		echo json_encode($result_verval);
	}
	public function getLatLongPropinsi(){
		ini_set('memory_limit', '-1'); 
		$qCountCoord = "SELECT kode_propinsi,COUNT(*) as TOTAL
				FROM asset.master_data_proses 
				WHERE lat IS NOT NULL  AND long IS NOT NULL  AND ( lat != ' ' AND long != ' ' ) 
					AND lat != 'NULL'  AND long != 'NULL' 
					AND ( master_data_proses.hasil_verivali = 1 OR master_data_proses.hasil_verivali = 4 
						) 
					AND (
						master_data_proses.stereotype = 'VERIVALI-SUBMITTED' 
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED' 
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED' 
						OR master_data_proses.stereotype = 'VERIVALI-FINAL' 
					) 
					GROUP BY kode_propinsi";
		$result_coord = $this->db->query($qCountCoord)->result_array();

		$qWilayah = "SELECT kode_propinsi, province_name 
					FROM [asset].[master_data_proses]  join dbo.ref_locations 
					ON([asset].[master_data_proses].location_id = dbo.ref_locations.location_id)
				GROUP BY kode_propinsi, province_name ORDER BY kode_propinsi";
		$result_wilayah = $this->db->query($qWilayah)->result_array();

		$center_coord_province = array(
			array("id"=>11,"name"=>"ACEH","lat"=>"4.1524793","long"=>"96.9678232"),
			array("id"=>12,"name"=>"SUMATERA UTARA","lat"=>"1.829230","long"=>"98.776604"),
			array("id"=>13,"name"=>"SUMATERA BARAT","lat"=>"-0.739940","long"=>"100.800003"),
			array("id"=>14,"name"=>"RIAU","lat"=>"0.750240","long"=>"101.953392"),
			array("id"=>15,"name"=>"JAMBI","lat"=>"-1.485183","long"=>"102.438057"),
			array("id"=>16,"name"=>"SUMATERA SELATAN","lat"=>"-3.320950","long"=>"104.082382"),
			array("id"=>17,"name"=>"BENGKULU","lat"=>"-3.8251718","long"=>"102.2345377"),
			array("id"=>18,"name"=>"LAMPUNG","lat"=>"-4.9792641","long"=>"103.9482681"),
			array("id"=>19,"name"=>"KEPULAUAN BANGKA BELITUNG","lat"=>"-2.3745342,","long"=>"106.2442323"), 
			array("id"=>21,"name"=>"KEPULAUAN RIAU","lat"=>"0.1320591","long"=>"104.4530586"),
			array("id"=>31,"name"=>"DKI JAKARTA","lat"=>"-6.2319581","long"=>"106.7792457"),
			array("id"=>32,"name"=>"JAWA BARAT","lat"=>"-6.9034443","long"=>"107.5731162"),
			array("id"=>33,"name"=>"JAWA TENGAH","lat"=>"-6.9646169","long"=>"109.0020009"),
			array("id"=>34,"name"=>"DI YOGYAKARTA","lat"=>"-7.8030422","long"=>"110.3449872"),
			array("id"=>35,"name"=>"JAWA TIMUR","lat"=>"-7.9786395","long"=>"112.5617416"),
			array("id"=>36,"name"=>"BANTEN","lat"=>"-6.5681569","long"=>"105.7489483"),
			array("id"=>51,"name"=>"BALI","lat"=>"-8.3570394","long"=>"115.003529"),
			array("id"=>52,"name"=>"NUSA TENGGARA BARAT","lat"=>"-8.5906453","long"=>"116.4569463"),
			array("id"=>53,"name"=>"NUSA TENGGARA TIMUR","lat"=>"-9.522932","long"=>"119.814818"),
			array("id"=>61,"name"=>"KALIMANTAN BARAT","lat"=>"-0.0352232","long"=>"109.2615094"),
			array("id"=>62,"name"=>"KALIMANTAN TENGAH","lat"=>"-2.2096162","long"=>"113.8666454"),
			array("id"=>63,"name"=>"KALIMANTAN SELATAN","lat"=>"-3.0221098","long"=>"113.2058061"),
			array("id"=>64,"name"=>"KALIMANTAN TIMUR","lat"=>"-0.5096799","long"=>"116.8953196"),
			array("id"=>65,"name"=>"KALIMANTAN UTARA","lat"=>"3.5588247","long"=>"116.2281839,12"),
			array("id"=>71,"name"=>"SULAWESI UTARA","lat"=>"1.3719508","long"=>"124.9966457"),
			array("id"=>72,"name"=>"SULAWESI TENGAH","lat"=>"-1.1264259","long"=>"119.5696108"),
			array("id"=>73,"name"=>"SULAWESI SELATAN","lat"=>"-4.0127934","long"=>"119.6031278"),
			array("id"=>74,"name"=>"SULAWESI TENGGARA","lat"=>"-5.3552126","long"=>"121.9615335"),
			array("id"=>75,"name"=>"GORONTALO","lat"=>"0.6763629","long"=>"121.2352586"),
			array("id"=>76,"name"=>"SULAWESI BARAT","lat"=>"-2.9956889","long"=>"119.0434662"),
			array("id"=>81,"name"=>"MALUKU","lat"=>"-3.7045931","long"=>"128.1147531"),
			array("id"=>82,"name"=>"MALUKU UTARA","lat"=>"0.8941939","long"=>"126.222919"),
			array("id"=>91,"name"=>"PAPUA","lat"=>"-4.5579933","long"=>"136.8702018"),
			array("id"=>92,"name"=>"PAPUA BARAT","lat"=>"-0.8927348","long"=>"131.1943546")
		);

		$data_coord = array();
		foreach ($result_wilayah as $key => $value) {
			$item = new stdClass();
			$item->kode_propinsi = $value['kode_propinsi'];
			$item->nm_propinsi = $value['province_name'];
			$center = $this->findCenterPropinsi($value['kode_propinsi'],$center_coord_province);
			$item->lat = $center["lat"];
			$item->long = $center["long"];
			 
			$item->total = $this->findTotal($value['kode_propinsi'],$result_coord);
			array_push($data_coord,$item);
		}
		// echo "<pre>";
		// print_r($data_coord);
		// die;
		echo json_encode($data_coord);
	}
	public function getDetailPrelist(){
		$proses_id = $this->input->post('proses_id');
		$q = 'select TOP 1  "asset"."vw_all_data".*
				from "asset"."vw_all_data" JOIN ref_locations
				 ON("asset"."vw_all_data".location_id = ref_locations.location_id)
				WHERE  proses_id='.$proses_id;
		$result = $this->db->query($q)->row();

		$proses_id = $this->input->post('proses_id');
		$q2= "select  nama,nik,no_kk from asset.master_data_detail_proses
				WHERE  proses_id='".$proses_id."'";
		$result2 = $this->db->query($q2)->result_array();
		$q3= "select internal_filename,stereotype from dbo.files
				WHERE  owner_id='".$proses_id."'";
		$result3 = $this->db->query($q3)->result_array();
		$q4= "select nokk from asset.master_data_detail_proses_kk where proses_id='".$proses_id."'";
		$result4 = $this->db->query($q4)->result_array();


		$return_data = array(
			"rt"=>$result,
			"art"=>$result2,
			"kk"=>$result4,
			"foto"=>$result3
		);
		echo json_encode($return_data);
	}

	private function findTotal($kode_propinsi,$data){
		foreach ($data as $value) {
			if($value['kode_propinsi'] == $kode_propinsi){
				return $value['TOTAL'];
			}
		}

		return 0;

	}
	private function findCenterPropinsi($kode_propinsi,$data){
		foreach ($data as $value) {
			if($value['id'] == $kode_propinsi){
				return $value;
			}
		}

		return 0;

	}
}
