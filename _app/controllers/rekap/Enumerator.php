<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enumerator extends Backend_Controller {

	public function __construct() {
		parent::__construct();

		$this->dir = base_url( 'rekap/enumerator/' );
	}

	function index() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['title'] = 'Rekapitulasi Enumerator';
		$data['cari'] = $this->form_cari();
		$data['base_url'] = $this->dir;
		$data['paste_url'] = $this->dir;
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

		// $data['dashboard'] = $this->get_data_dashboard();

		$this->template->title( 'Rekapitulasi Enumerator' );
		$this->template->content( "admin/rekap/enumerator", $data );
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

	function get_show_data_musdes(){
		$kd_prop = 0;
		$kd_kab = 0;
		$kd_kec = 0;

		$input = $this->input->post();

		if(!empty($input)){
			$par = $input['params'];
			$params = json_decode( $par, true );
			$kd_prop = $params[0]['province_id'];
			$kd_kab = $params[0]['regency_id'];
			$kd_kec = $params[0]['district_id'];
		}



		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			$where = "";
			if(!empty($kd_prop)){
				$where .= " AND md.kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND md.kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND md.kode_kecamatan = '".$kd_kec."'";
			}
			$where = 'AND '.substr($where,4);
		}
		$rp = $input['rp'];
		$query = "SELECT  a.user_id,
					concat ( u.user_profile_first_name, u.user_profile_last_name )
					AS surveyor_verivali,
					u.user_profile_no_hp AS surveyor_verivali_phone,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'MUSDES-GRABBED' )) THEN 1 ELSE 0 END ) AS status_3,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'MUSDES-DOWNLOADED' )) THEN 1 ELSE 0 END ) AS status_4,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'MUSDES-SURVEY' )) THEN 1 ELSE 0 END ) AS status_5,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'MUSDES-SUBMITTED' )) THEN 1 ELSE 0 END ) AS status_6
				FROM
					[asset].[master_data_proses] md
					LEFT JOIN [dbo].[ref_assignment] a ON a.proses_id= md.proses_id
					AND a.row_status= 'ACTIVE'
					LEFT JOIN [dbo].[core_user_profile] u ON u.user_profile_id= a.user_id
					LEFT JOIN [dbo].[ref_locations] l ON md.location_id= l.location_id
					WHERE a.user_id IS NOT NULL
				".$where."
				GROUP BY
					a.user_id,
					u.user_profile_first_name,
					u.user_profile_last_name,
					u.user_profile_no_hp

				ORDER BY u.user_profile_first_name,
					u.user_profile_last_name  ";
 		$paging_query = "OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY";
 		$query_paging = $query.$paging_query;

		$result = $this->db->query($query_paging)->result_array();
		$data = array();
		foreach ( $result as $par => $row ) {
			if(!empty($row['user_id'])){
				$row_data = [
					'id' => $row['user_id'],
					'cell' => [
						'user_id' => $row['user_id'],
						'surveyor_verivali' => $row['surveyor_verivali'],
						'surveyor_verivali_phone' => $row['surveyor_verivali_phone'],
						'status_3' => $row['status_3'],
						'status_4' => $row['status_4'],
						'status_5' => $row['status_5'],
						'status_6' => $row['status_6'],
						'total_data' => $row['status_3']+$row['status_4']+$row['status_5']+$row['status_6']
					]
				];
				$data[] = $row_data;
			}

		}
		$result = [
			'status' => 200,
			'total' => $this->db->query($query_paging)->num_rows(),
			'rows' => $data,
			'page' => (!empty($input['page']))?$input['page']:1,
			'total' => $this->db->query($query)->num_rows(),
		];
		echo json_encode( $result );
	}

	function get_show_data_verval(){
		$kd_prop = 0;
		$kd_kab = 0;
		$kd_kec = 0;

		$input = $this->input->post();

		if(!empty($input)){
			$par = $input['params'];
			$params = json_decode( $par, true );
			$kd_prop = $params[0]['province_id'];
			$kd_kab = $params[0]['regency_id'];
			$kd_kec = $params[0]['district_id'];
		}



		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			$where = "";
			if(!empty($kd_prop)){
				$where .= " AND md.kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND md.kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND md.kode_kecamatan = '".$kd_kec."'";
			}
			$where = 'AND '.substr($where,4);
		}
		$rp = $input['rp'];
		$query = "SELECT  a.user_id,
					concat ( u.user_profile_first_name, u.user_profile_last_name )
					AS surveyor_verivali,
					u.user_profile_no_hp AS surveyor_verivali_phone,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'VERIVALI-GRABBED' )) THEN 1 ELSE 0 END ) AS status_8,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'VERIVALI-DOWNLOADED' )) THEN 1 ELSE 0 END ) AS status_9,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'VERIVALI-SURVEY' )) THEN 1 ELSE 0 END ) AS status_10,
					SUM ( CASE WHEN (( md.stereotype ) IN ( 'VERIVALI-SUBMITTED' )) THEN 1 ELSE 0 END ) AS status_11
				FROM
					[asset].[master_data_proses] md
					LEFT JOIN [dbo].[ref_assignment] a ON a.proses_id= md.proses_id
					AND a.row_status= 'ACTIVE'
					LEFT JOIN [dbo].[core_user_profile] u ON u.user_profile_id= a.user_id
					LEFT JOIN [dbo].[ref_locations] l ON md.location_id= l.location_id
					WHERE a.user_id IS NOT NULL
				".$where."
				GROUP BY
					a.user_id,
					u.user_profile_first_name,
					u.user_profile_last_name,
					u.user_profile_no_hp

				ORDER BY u.user_profile_first_name,
					u.user_profile_last_name ";

	 	$paging_query = "OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY";
 		$query_paging = $query.$paging_query;


		$result = $this->db->query($query_paging)->result_array();
		$data = array();
		foreach ( $result as $par => $row ) {
			if(!empty($row['user_id'])){
				$row_data = [
					'id' => $row['user_id'],
					'cell' => [
						'user_id' => $row['user_id'],
						'surveyor_verivali' => $row['surveyor_verivali'],
						'surveyor_verivali_phone' => $row['surveyor_verivali_phone'],
						'status_8' => $row['status_8'],
						'status_9' => $row['status_9'],
						'status_10' => $row['status_10'],
						'status_11' => $row['status_11'],
						'total_data' => $row['status_8']+$row['status_9']+$row['status_10']+$row['status_11']
					]
				];
				$data[] = $row_data;
			}

		}
		$result = [
			'status' => 200,
			'total' => $this->db->query($query_paging)->num_rows(),
			'rows' => $data,
			'page' => (!empty($input['page']))?$input['page']:1 ,
			'total' => $this->db->query($query)->num_rows(),
		];
		echo json_encode( $result );
	}
}
