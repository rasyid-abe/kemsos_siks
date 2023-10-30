<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyajian_data extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'dashboard/penyajian_data/' );
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$this->template->title( 'Dashboard Penyajian Data' );
		$data['cari'] = $this->form_cari();
		$data['base_url'] = $this->dir;
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

		$this->template->content( "admin/dashboard/penyajian_data", $data );
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

	function getStatusPenguasaanBangungan(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT status_bangunan, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				status_bangunan IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY status_bangunan";
		$result = $this->db->query($q)->result_array();
		$label = array("Milik Sendiri"," Kontrak/Sewa","Bebas Sewa","Dinas","Lainnnya");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}

	function getStatuslahan(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT status_lahan, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				status_lahan != 0
				AND status_lahan IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY status_lahan";
		$result = $this->db->query($q)->result_array();
		$label = array("Milik Sendiri"," Milik Orang Lain","Tanah Negara","Lainnnya");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusJenisLantai(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT lantai, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				lantai IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY lantai";
		$result = $this->db->query($q)->result_array();
		$label = array(
			"Marmer/Granit","Keramik","Parket/Vinil/Permadani","Ubin/Tegal/Teraso",
			"Kayu/Papan Berkualitas Tinggi","Sementara/Bata Merah",
			"Bambu","Kayu/Papan Berkualitas Rendah","Tanah","Lainnya");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusDinding(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT dinding, kondisi_dinding, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				dinding IS NOT NULL
				AND kondisi_dinding  IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY dinding, kondisi_dinding
			ORDER BY dinding, kondisi_dinding
			";
		$result = $this->db->query($q)->result_array();
		$label = array("",
			"Tembok","Plesteran Anyaman Bambu/Kawat","Kayu","Anyaman Bambu",
			"Batang Kayu","Bambu", "Lainnya");
		$data_total = array();
		$data_kondisi = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			if(isset($data_label[$key])){
				if($value['dinding'] <= 3){
					$data_kondisi[$value['dinding']][$value['kondisi_dinding']] = array();
					$data_kondisi[$value['dinding']][$value['kondisi_dinding']][] = $value['total'];
				}
				$data_total[$value['dinding']] += $value['total'];
				$data_label[$key] = $label[$key];
			}else{
				if($value['dinding'] == 5){
					$data_total[5] += $value['total'];
				}
				if($value['dinding'] == 6){
					$data_total[6] += $value['total'];
				}
				if($value['dinding'] == 7){
					$data_total[7] += $value['total'];
				}

			}
		}
		array_shift($data_total);
		array_shift($data_label);
		$return_data = array(
			"label"=>$data_label,
			"kondisi"=>$data_kondisi,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusAtap(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT  atap, kondisi_atap, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				atap IS NOT NULL
				AND kondisi_atap  IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY atap, kondisi_atap
			ORDER BY  atap, kondisi_atap
			";
		$result = $this->db->query($q)->result_array();
		$label = array("",
			"Beton/Genteng Beton","Genteng Keramik","Genteng Metal","Genteng Tanah Liat",
			"Asbes","Seng", "Sirap", "Bambu", "Jerami/Ijuk/Daun-Daunan/Rumbia", "Lainnya");
		$data_total = array();
		$data_kondisi = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}
		// print_r($data_label);

		foreach ($result as $key => $value) {
			// echo $value['atap']." - ". $key."<br>";

				// echo $value['atap']." - ". $key."<br>";
				if($value['atap'] <= 7){

					$data_kondisi[$value['atap']][$value['kondisi_atap']] = array();
					$data_kondisi[$value['atap']][$value['kondisi_atap']][] = $value['total'];
					$data_total[$value['atap']] += $value['total'];
					if(isset($data_label[$key])){
						$data_label[$key] = $label[$key];
					}
				}

				if($value['atap'] == 8){
					$data_total[8] += $value['total'];
				}
				if($value['atap'] == 9){
					$data_total[9] += $value['total'];
				}
				if($value['atap'] == 10){
					$data_total[10] += $value['total'];
				}


		}
		array_shift($data_total);
		array_shift($data_label);
		$return_data = array(
			"label"=>$data_label,
			"kondisi"=>$data_kondisi,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}

	function getStatusSumberAir(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT sumber_airminum, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				 sumber_airminum IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY sumber_airminum";
		$result = $this->db->query($q)->result_array();
		$label = array("Air Kemasan Bermerk","Air Isi Ulang","Leding Meteran","Leding Eceran",
						"Sumur Berpompa","Sumur Terlindung","Sumur Tak Terlindung","Mata Air Terlindung"
						,"Mata Air Tak Terlindung","Air Sungai/Waduk/Danau","Air Hujan","Lainnnya");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusCaraPeroleh(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT cara_peroleh_airminum, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				 cara_peroleh_airminum IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY cara_peroleh_airminum";
		$result = $this->db->query($q)->result_array();
		$label = array("Membeli Eceran","Langganan","Tidak Membeli");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusSumberPenerangan(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT sumber_penerangan, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				 sumber_penerangan IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY sumber_penerangan";
		$result = $this->db->query($q)->result_array();
		$label = array("Listrik PLN","Listrik Non PLN","Bukan Listrik");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusDayaTerpasang(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT daya, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
				daya !=0 AND
   				daya IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY daya";
		$result = $this->db->query($q)->result_array();
		$label = array("450 Watt","900 Watt","1.300 Watt","2.200 Watt","Lebih Dari 2.200 Watt","Tanpa Meteran");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusBahanBakar(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT bb_masak, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
   				bb_masak IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY bb_masak";
		$result = $this->db->query($q)->result_array();
		$label = array("Listrik","Gas > 3 Kg","Gas 3 Kg","Gas Kota/Biogas","Minyak Tanah","Briket",
						"Arang","Kayu Bakar","Tidak Memasak Di Rumah");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusFasilitasBAB(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT fasbab, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
   				fasbab IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY fasbab";
		$result = $this->db->query($q)->result_array();
		$label = array("Sendiri","Bersama","Umum","Tidak Ada ( R.12)");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusTempatTinja(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
		$where = "";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "";
		}else{
			if(!empty($kd_prop)){
				$where .= " AND kode_propinsi = '".$kd_prop."'";
			}
			if(!empty($kd_kab)){
				$where .= " AND kode_kabupaten = '".$kd_kab."'";
			}
			if(!empty($kd_kec)){
				$where .= " AND kode_kecamatan = '".$kd_kec."'";
			}
			if(!empty($kd_desa)){
				$where .= " AND kode_desa = '".$kd_kec."'";
			}
			$where = substr($where,1);
		}
		$q= "SELECT buang_tinja, COUNT ( * ) as total
			FROM
				asset.master_data_proses
			WHERE
   				buang_tinja IS NOT NULL
				AND ( status_rumahtangga = 1 OR status_rumahtangga = 4 )
				AND hasil_verivali = 1
				AND (
				stereotype = 'VERIVALI-SUBMITTED'
				OR stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR stereotype = 'VERIVALI-FINAL'
			) ".$where."
			GROUP BY buang_tinja";
		$result = $this->db->query($q)->result_array();
		$label = array("Tangki","SPAL","Lubang Tanah","Kolam/Sawah/Sungai/Danau/Laut",
						"Pantai/Tanah Lapang/Kebun","Lainnya");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusRasioKamarTidur(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "select jumlah_kamar, AVG(total) as total from (SELECT
				master_data_proses.jumlah_kamar,
				COUNT ( * ) AS total
			FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses
				ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
			WHERE
				master_data_proses.jumlah_kamar IS NOT NULL
				AND ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-FINAL'
				)
				".$where."
			GROUP BY
				master_data_proses.jumlah_kamar ,
				master_data_detail_proses.proses_id

			) A GROUP BY jumlah_kamar";
		$result = $this->db->query($q)->result_array();


        echo json_encode($result);
	}
	function getStatusKRTPerempuan(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT
				COUNT ( * ) AS total
			FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses
				ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
			WHERE
				 ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-FINAL'
				) AND master_data_proses.jenis_kelamin_krt = 2
				AND master_data_detail_proses.hubungan_krt =1 ".$where;
		$result = $this->db->query($q)->row();


        echo json_encode($result);
	}
	function getStatusJenisCacat(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT
					jenis_cacat,
					COUNT ( * ) AS total
				FROM
					asset.master_data_proses
					JOIN asset.master_data_detail_proses
					ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
				WHERE
				jenis_cacat IS NOT NULL
					 AND ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
					AND master_data_proses.hasil_verivali = 1
					AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
							OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
							OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
							OR master_data_proses.stereotype = 'VERIVALI-FINAL'
					) AND jenis_cacat < 12 ".$where."
					GROUP BY jenis_cacat
					ORDER BY jenis_cacat";

		$result = $this->db->query($q)->result_array();
		$label = array(" Tidak Cacat "," Tuna Daksa/Cacat Tubuh ","Tuna Netra/Buta"," Tuna Wicara ",
						" Tuna Rungu & Wicara "," Tuna Netra & Cacat Tubuh "," Tuna Netra, Rungu & Wicara ",
						" Tuna Rungu, Wicara Dan Cacat Tubuh "," Tuna Rungu,Wicara,Netra Dan Cacat Tubuh "," Cacat Mental Retardasi ",
						" Mantan Penderita Gangguan Jiwa "," Cacat Fisik Dan Mental ");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusKronis(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT
					penyakit_kronis,
					COUNT ( * ) AS total
				FROM
					asset.master_data_proses
					JOIN asset.master_data_detail_proses
					ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
				WHERE
				penyakit_kronis IS NOT NULL
					 AND ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
					AND master_data_proses.hasil_verivali = 1
					AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
							OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
							OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
							OR master_data_proses.stereotype = 'VERIVALI-FINAL'
					) AND jenis_cacat < 12 ".$where."
					GROUP BY penyakit_kronis
					ORDER BY penyakit_kronis";
		$result = $this->db->query($q)->result_array();
		$label = array(" Tidak Ada ","  Hipertensi (Tekanan Darah Tinggi) "," Rematik ","Asma",
						"Masalah Jantung","Diabetes(Kencing Manis)","  Tuberkolosis(TBC)","Stroke",
						" Kanker Atau Tumor Ganas "," Lainnya(gagal ginjal,paru-paru flek, dan sejenisnya) ");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusJenisTernak(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= " SELECT
				SUM(jumlah_sapi) as 'jumlah_sapi',
				SUM(jumlah_kerbau) as 'jumlah_kerbau',
				SUM(jumlah_kuda) as 'jumlah_kuda',
				SUM(jumlah_babi) as 'jumlah_babi',
				SUM(jumlah_kambing) as 'jumlah_kambing',

				(SUM(jumlah_babi) + SUM(jumlah_kerbau) + SUM(jumlah_kuda)) as 'Total'
				FROM asset.master_data_proses
				WHERE ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
				OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR master_data_proses.stereotype = 'VERIVALI-FINAL')".$where;
		$result = $this->db->query($q)->row();
		$data_label = array("Sapi","Kerbau","Kuda","Babi","Kambing");

		$data_total = array($result->jumlah_sapi,$result->jumlah_kerbau,$result->jumlah_kuda,$result->jumlah_babi,$result->jumlah_kambing);

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusAssetTakBergerak(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= " SELECT aset_tak_bergerak,count(*) total
			FROM
				asset.master_data_proses
			WHERE
				aset_tak_bergerak !=0 AND
				( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND (
				master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
				OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR master_data_proses.stereotype = 'VERIVALI-FINAL')
				".$where." GROUP BY aset_tak_bergerak ";
				$result = $this->db->query($q)->result_array();

		$q2= " SELECT rumah_lain,count(*) total
			FROM
				asset.master_data_proses
			WHERE
				( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND (
				master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
				OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
				OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
				OR master_data_proses.stereotype = 'VERIVALI-FINAL')
				".$where."  GROUP BY rumah_lain ";
		$result2 = $this->db->query($q2)->result_array();
		$data_label = array("Lahan","Rumah di Tempat Lain");
		$data_lahan = array(0,0);
		$data_rumah_lainnya = array(0,0);

		foreach ($result as $key => $value) {
			$data_lahan[$key] = $value['total'];
		}
		foreach ($result2 as $key2 => $value2) {
			$data_rumah_lainnya[$key2] = $value2['total'];
		}

		$return_data = array(
			"label"=>$data_label,
			"data_lahan"=>$data_lahan,
			"data_rumah_lainnya"=>$data_rumah_lainnya
		);
        echo json_encode($return_data);
	}
	function getStatusKehamilan(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= " SELECT
				status_kawin ,COUNT
				( * ) AS total
				FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses ON ( master_data_proses.proses_id = master_data_detail_proses.proses_id )
				WHERE
				status_kawin is NOT NUll AND
				( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
					OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
					OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
					OR master_data_proses.stereotype = 'VERIVALI-FINAL' )
					AND status_hamil = 1
				".$where."
				GROUP BY status_kawin
				ORDER BY status_kawin";
		$result = $this->db->query($q)->result_array();
		$q2= " SELECT
				status_kawin ,COUNT
				( * ) AS total
				FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses ON ( master_data_proses.proses_id = master_data_detail_proses.proses_id )
				WHERE
				status_kawin is NOT NUll AND
				( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
					OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
					OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
					OR master_data_proses.stereotype = 'VERIVALI-FINAL' )
					AND status_hamil = 2
				".$where."
				GROUP BY status_kawin
				ORDER BY status_kawin";
		$result2 = $this->db->query($q2)->result_array();

		$label = array("Belum Kawin","Belum Kawin","Kawin/Nikah","Cerai Mati","Cerai Hidup");
		$data_hamil = array();
		$data_tidak_hamil = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_hamil,0);
			array_push($data_tidak_hamil,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_hamil[$value['status_kawin']] = $value['total'];
			$data_label[$key] = $label[$key];
		}
		foreach ($result2 as $key2 => $value2) {
			$data_tidak_hamil[$value2['status_kawin']] = $value2['total'];
		}
		$return_data = array(
			"label"=>$data_label,
			"data_hamil"=>$data_hamil,
			"data_tidak_hamil"=>$data_tidak_hamil
		);
        echo json_encode($return_data);
	}
	function getStatusPartisipasiSekolah(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT partisipasi_sekolah, COUNT ( * ) AS total
			 FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses
				ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
			WHERE
			partisipasi_sekolah IS NOT NULL AND
				 ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-FINAL'
				)
			 ".$where."
			GROUP BY partisipasi_sekolah
			ORDER BY partisipasi_sekolah";
		$result = $this->db->query($q)->result_array();
		$label = array("Tidak/belum pernah sekolah"," Masih sekolah","Tidak bersekolah lagi	");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusLapanganKerja(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT lapangan_usaha, COUNT ( * ) AS total
			 FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses
				ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
			WHERE
			lapangan_usaha IS NOT NULL AND lapangan_usaha !=0 AND
				 ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-FINAL'
				)
			 ".$where."
			GROUP BY lapangan_usaha
			ORDER BY lapangan_usaha";
		$result = $this->db->query($q)->result_array();
		$label = array("Pertanian tanaman padai & palawija","Hortikultura",
						"Perkebunan","Perikanan tangkap	","Perikanan budidaya",
						"Peternakan","Kehutanan & pertanian lainnnya","Pertambangan/penggalian",
						"Industri pengolahan","Listrik dan gas","Bangunan /kontruksi",
						"Perdagangan","Hotel & rumah makan","Transportasi & pergudangan",
						"Informasi & komunikasi","Keuangan & asuransi","Jasa pendidikan",
						"Jasa kesehatan","Jasa kemasyarakatan pemerintah & perorangan","Pemulung",
						"Lainnya"

					);
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			$data_total[$key] = $value['total'];
			$data_label[$key] = $label[$key];
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusTidakTercantumKK(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT
				ada_di_kk,
				umur,
				COUNT ( * ) AS total
			FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses
				ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
			WHERE
			ada_di_kk IS NOT NULL AND lapangan_usaha !=0 AND
				 ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-FINAL'
				)".$where."
				GROUP BY ada_di_kk,umur
				ORDER BY ada_di_kk,umur";
		$result = $this->db->query($q)->result_array();
		$label = array("10-20","20-40", "40-60","60+");
		$data_total = array();
		$data_label = array();
		for ($i=0; $i < count($label) ; $i++) {
			array_push($data_total,0);
			array_push($data_label,$label[$i]);
		}

		foreach ($result as $key => $value) {
			if($value['umur'] > 10 && $value['umur'] < 20){
				$data_total[0] += $value['total'];
			}else if($value['umur'] >= 20 && $value['umur'] < 40){
				$data_total[1] += $value['total'];
			} else if($value['umur'] >= 40 && $value['umur'] < 60){
				$data_total[2] += $value['total'];
			} else if($value['umur'] >= 60){
				$data_total[3] += $value['total'];
			}
		}

		$return_data = array(
			"label"=>$data_label,
			"total"=>$data_total
		);
        echo json_encode($return_data);
	}
	function getStatusPerkawinan(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$kd_desa = $this->input->post('kd_desa');
		$return_data = array();
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
		$q= "SELECT status_kawin, ada_akta_nikah, COUNT ( * ) AS total
			FROM
				asset.master_data_proses
				JOIN asset.master_data_detail_proses
				ON (master_data_proses.proses_id = master_data_detail_proses.proses_id)
			WHERE
			status_kawin IS NOT NULL AND
			status_kawin !=0 AND
			ada_akta_nikah IS NOT NULL AND
				 ( master_data_proses.status_rumahtangga = 1 OR master_data_proses.status_rumahtangga = 4 )
				AND master_data_proses.hasil_verivali = 1
				AND ( master_data_proses.stereotype = 'VERIVALI-SUBMITTED'
						OR master_data_proses.stereotype = 'VERIVALI-SUPERVISOR-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-KORKAB-APPROVED'
						OR master_data_proses.stereotype = 'VERIVALI-FINAL'
				)
				".$where."
				GROUP BY status_kawin, ada_akta_nikah
			    ORDER BY status_kawin, ada_akta_nikah";
		$result = $this->db->query($q)->result_array();
		$data_label = array("Belum Kawin","Kawin/Nikah", "Cerai Mati	","Cerai Hidup");
		$data_belum_kawin = array();
		$data_kawin = array();
		$data_cerai_mati = array();
		$data_cerai_hidup = array();
		for ($i=0; $i < 3 ; $i++) {
			array_push($data_belum_kawin,0);
			array_push($data_kawin,0);
			array_push($data_cerai_mati,0);
			array_push($data_cerai_hidup,0);

		}

		foreach ($result as $key => $value) {
			if($value['status_kawin'] == 1){
				 $data_belum_kawin[$value['ada_akta_nikah']] = $value['total'];
			}
			if($value['status_kawin'] == 2){
				 $data_kawin[$value['ada_akta_nikah']] = $value['total'];
			}
			if($value['status_kawin'] == 3){
				 $data_cerai_mati[$value['ada_akta_nikah']] = $value['total'];
			}
			if($value['status_kawin'] == 4){
				 $data_cerai_hidup[$value['ada_akta_nikah']] = $value['total'];
			}
		}

		$return_data = array(
			"label"=>$data_label,
			"data_belum_kawin"=>$data_belum_kawin,
			"data_kawin"=>$data_kawin,
			"data_cerai_mati"=>$data_cerai_mati,
			"data_cerai_hidup"=>$data_cerai_hidup
		);
        echo json_encode($return_data);
	}

}
