<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_proses extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'dashboard/status_proses/' );
	}

	function index() {
		$this->show();
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

		$this->template->title( 'Dashboard Status Proses' );
		// $this->template->content( "admin/dashboard/status_proses", $data );
		$this->template->content( "admin/dashboard/new-status_proses", $data );
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

	function get_data()
	{
		$area = $this->input->post('area');
		$result = array();

		// START (PROGRES MUSDES DATA USULAN BARU)
		$progres_usulan_baru = array();
		$usulan_baru_5_proses = $this->_get_usulan_baru_5_proses($area);
		$usulan_baru_5_selesai = $this->_get_usulan_baru_5_selesai($area);
		$usulan_baru_6_proses = $this->_get_usulan_baru_6_proses($area);
		$usulan_baru_6_selesai = $this->_get_usulan_baru_6_selesai($area);

		$progres_usulan_baru = [
			'proses_5' => $usulan_baru_5_proses,
			'selesai_5' => $usulan_baru_5_selesai,
			'proses_6' => $usulan_baru_6_proses,
			'selesai_6' => $usulan_baru_6_selesai,
		];
		$result['progres_usulan_baru'] = $progres_usulan_baru;
		// END (PROGRES MUSDES DATA USULAN BARU)

		// START (PROGRES PUBLISH S/D MUSDES DATA PRELIST)
		$chart_progres_publish = array();
		$prelist_awal = $this->_get_prelist_awal($area);
		$status_prelist_awal = $this->_get_total_prelist_awal($area);

		$total_proses_prelist_awal = 0;
		for ($i=0; $i < count($status_prelist_awal); $i++) {
			$total_proses_prelist_awal += $status_prelist_awal[$i]['total'];
		}

		$total_selesai_prelist_awal = [];
		for ($a=0; $a < count($status_prelist_awal); $a++) {
			if (count($total_selesai_prelist_awal) < 1) {
				$total_selesai_prelist_awal[] = $total_proses_prelist_awal - $status_prelist_awal[$a]['total'];
			} else {
				$awal_sem = array();
				for ($b=0; $b <= $a; $b++) {
					$awal_sem[] = $status_prelist_awal[$b]['total'];
				}
				$total_selesai_prelist_awal[] = $total_proses_prelist_awal - array_sum($awal_sem);
				unset($awal_sem);
			}
		}

		$result_status_awal = [];
		$chart_proses_publish = [];
		$chart_selesai_publish = [];
		$label_chart_selesai_publish = [];
		for ($c=0; $c < count($status_prelist_awal); $c++) {
			$result_status_awal[] = array(
				'code' => $status_prelist_awal[$c]['code'],
				'short_label' => $status_prelist_awal[$c]['short_label'],
				'long_label' => $status_prelist_awal[$c]['long_label'],
				'proses' => $status_prelist_awal[$c]['total'],
				'selesai' => $total_selesai_prelist_awal[$c],
			);
			if ($c == 0) {
				$chart_proses_publish[] = 0;
				$chart_selesai_publish[] = $prelist_awal[0]['total'];
				$label_chart_selesai_publish[] = 'Prelist Awal';
			} elseif ($c < 7) {
				$chart_proses_publish[] = $status_prelist_awal[$c - 1]['total'];
				$chart_selesai_publish[] = $total_selesai_prelist_awal[$c - 1];
				$label_chart_selesai_publish[] = $status_prelist_awal[$c - 1]['code'];
			}
		}
		$chart_progres_publish['chart_proses_publish'] = $chart_proses_publish;
		$chart_progres_publish['chart_selesai_publish'] = $chart_selesai_publish;
		$chart_progres_publish['label_chart_selesai_publish'] = $label_chart_selesai_publish;
		$result['chart_progres_publish'] = $chart_progres_publish;
		// END (PROGRES PUBLISH S/D MUSDES DATA PRELIST)

		// START (HASIL VERIFIKASI DAN VALIDASI)
		$chart_verval = array();
		$chart_musdes = array();

		$selesai_dicacah = $this->_get_hasil_verval($area, 1);
		$tidak_ditemukan = $this->_get_hasil_verval($area, 2);
		$pindah = $this->_get_hasil_verval($area, 3);
		$bagian_dokumen = $this->_get_hasil_verval($area, 4);
		$menolak = $this->_get_hasil_verval($area, 5);
		$ganda = $this->_get_hasil_verval($area, 6);
		$selesai_verval = $selesai_dicacah + $tidak_ditemukan + $pindah + $bagian_dokumen + $menolak + $ganda;

		$tidak_mampu = $this->_get_musdes_a($area,  "'COPY'", "");
		$mampu = $this->_get_musdes_a($area,  "'COPY'", "AND md.apakah_mampu = '1'");
		$usulan_baru = $this->_get_musdes_a($area,  "'NEW'", "");
		$tidak_ditemukan = $this->_get_musdes_b($area, 2);
		$ganda = $this->_get_musdes_b($area,  3);

		$prelist_akhir_musdes_i = $tidak_mampu + $mampu + $usulan_baru;
		$prelist_akhir_verval_ii = $this->_get_musdes_a($area, "'COPY', 'NEW'", "");
		$selesai_verval_iii = $selesai_verval;
		$selesai_verval_iv = $selesai_verval;

		$chart_musdes = [
			'label_chart_musdes' => ['Ditemukan - Tidak Mampu', 'Ditemukan - Mampu', 'Tidak Ditemukan'],
			'value_chart_musdes' => [$tidak_mampu, $mampu, $tidak_ditemukan]
		];
		$chart_verval = [
			'label_chart_verval' => ['Selesai Dicacah', 'Ruta Tidak Ditemukan', 'Ruta Pindah', 'Bagian Dari Dokumen', 'Menolak', 'Data Ganda'],
			'value_chart_verval' => [$selesai_dicacah, $tidak_ditemukan, $pindah, $bagian_dokumen, $menolak, $ganda]
		];
		$result['chart_musdes'] = $chart_musdes;
		$result['chart_verval'] = $chart_verval;

		// END (HASIL VERIFIKASI DAN VALIDASI)

		// START (PROGRES SURVEY VERIVALI DATA PRELIST AKHIR)
		$chart_progres_verval = array();
		$status_prelist_akhir = $this->_get_total_prelist_akhir($area);

		$total_proses_prelist_akhir = 0;
		for ($i=0; $i < count($status_prelist_akhir); $i++) {
			$total_proses_prelist_akhir += $status_prelist_akhir[$i]['total'];
		}

		$total_selesai_prelist_akhir = [];
		for ($a=0; $a < count($status_prelist_akhir); $a++) {
			if (count($total_selesai_prelist_akhir) < 1) {
				$total_selesai_prelist_akhir[] = $total_proses_prelist_akhir - $status_prelist_akhir[$a]['total'];
			} else {
				$akhir_sem = array();
				for ($b=0; $b <= $a; $b++) {
					$akhir_sem[] = $status_prelist_akhir[$b]['total'];
				}
				$total_selesai_prelist_akhir[] = $total_proses_prelist_akhir - array_sum($akhir_sem);
				unset($akhir_sem);
			}
		}

		$chart_proses_verval = [];
		$chart_selesai_verval = [];
		$label_chart_selesai_verval = [];
		$result_prelist_akhir = [];
		for ($c=0; $c < count($status_prelist_akhir); $c++) {
			$result_prelist_akhir[] = array(
				'code' => $status_prelist_akhir[$c]['code'],
				'short_label' => $status_prelist_akhir[$c]['short_label'],
				'long_label' => $status_prelist_akhir[$c]['long_label'],
				'proses' => $status_prelist_akhir[$c]['total'],
				'selesai' => $total_selesai_prelist_akhir[$c],
			);
			if ($c == 0) {
				$chart_proses_verval[] = 0;
				$chart_selesai_verval[] = $prelist_akhir_musdes_i;
				$label_chart_selesai_verval[] = 'Prelist Akhir';
			} elseif ($c < 7) {
				$chart_proses_verval[] = $status_prelist_akhir[$c - 1]['total'];
				$chart_selesai_verval[] = $total_selesai_prelist_akhir[$c - 1];
				$label_chart_selesai_verval[] = $status_prelist_akhir[$c - 1]['code'];
			}
		}
		$chart_progres_verval = [
			'chart_proses_verval' => $chart_proses_verval,
			'chart_selesai_verval' => $chart_selesai_verval,
			'label_chart_selesai_verval' => $label_chart_selesai_verval
		];
		$result['chart_progres_verval'] = $chart_progres_verval;
		// END (PROGRES SURVEY VERIVALI DATA PRELIST AKHIR)

		// START (PRELIST AWAL INVALID MUSDES)
		$chart_invalid_musdes = array();
		$invalid_musdes = $this->_get_invalid_musdes($area);

		$total_invalid_musdes = 0;
		for ($i=0; $i < count($invalid_musdes); $i++) {
			$total_invalid_musdes += $invalid_musdes[$i]['total'];
		}

		$total_selesai_invalid_musdes = [];
		for ($a=0; $a < count($invalid_musdes); $a++) {
			if (count($total_selesai_invalid_musdes) < 1) {
				$total_selesai_invalid_musdes[] = $total_invalid_musdes - $invalid_musdes[$a]['total'];
			} else {
				$invalid_musdes_sem = array();
				for ($b=0; $b <= $a; $b++) {
					$invalid_musdes_sem[] = $invalid_musdes[$b]['total'];
				}
				$total_selesai_invalid_musdes[] = $total_invalid_musdes - array_sum($invalid_musdes_sem);
				unset($invalid_musdes_sem);
			}
		}

		$chart_proses_invalid_musdes = [];
		$chart_selesai_invalid_musdes = [];
		$label_chart_selesai_invalid_musdes = [];
		$result_invalid_musdes = [];
		for ($c=0; $c < count($invalid_musdes) + 1; $c++) {
			if ($c == 0) {
				$result_invalid_musdes[] = array(
					'code' => '',
					'short_label' => '',
					'long_label' => 'Prelist Akhir Invalid Musdes',
					'proses' => 0,
					'selesai' => $invalid_musdes[$c]['total'] + $total_selesai_invalid_musdes[$c],
				);
				$chart_proses_invalid_musdes[] = 0;
				$chart_selesai_invalid_musdes[] = $invalid_musdes[$c]['total'] + $total_selesai_invalid_musdes[$c];
				$label_chart_selesai_invalid_musdes[] = 'Prelist Akhir';
			} else {
				$result_invalid_musdes[] = array(
					'code' => $invalid_musdes[$c -1]['code'],
					'short_label' => $invalid_musdes[$c -1]['short_label'],
					'long_label' => $invalid_musdes[$c -1]['long_label'],
					'proses' => $invalid_musdes[$c -1]['total'],
					'selesai' => $total_selesai_invalid_musdes[$c -1],
				);
				$chart_proses_invalid_musdes[] = $invalid_musdes[$c - 1]['total'];
				$chart_selesai_invalid_musdes[] = $total_selesai_invalid_musdes[$c - 1];
				$label_chart_selesai_invalid_musdes[] = $invalid_musdes[$c - 1]['code'];
			}
		}
		$chart_invalid_musdes = [
			'chart_proses_invalid_musdes' => $chart_proses_invalid_musdes,
			'chart_selesai_invalid_musdes' => $chart_selesai_invalid_musdes,
			'label_chart_selesai_invalid_musdes' => $label_chart_selesai_invalid_musdes,
		];
		$result['chart_invalid_musdes'] = $chart_invalid_musdes;
		// END (PRELIST AWAL INVALID MUSDES)

		// START (DATA DALAM PENANGANAN KEMBALI PROSES KE SEBELUMNYA)
		$chart_penanganan_kembali = array();
		$penanganan_kembali = $this->_get_penanganan_kembali($area);

		$value_chart_penanganan_kembali = [];
		$label_chart_penanganan_kembali = [];
		foreach ($penanganan_kembali as $key => $value) {
			$value_chart_penanganan_kembali[] = $value['total'];
			$label_chart_penanganan_kembali[] = $value['code'];
		}
		$chart_penanganan_kembali = [
			'value_chart_penanganan_kembali' => $value_chart_penanganan_kembali,
			'label_chart_penanganan_kembali' => $label_chart_penanganan_kembali,
		];
		$result['chart_penanganan_kembali'] = $chart_penanganan_kembali;
		// END (DATA DALAM PENANGANAN KEMBALI PROSES KE SEBELUMNYA)

		echo json_encode($result);
	}

	private function _get_total_prelist_awal($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT
				r.reference_id,
				r.code,
				r.short_label,
				r.long_label,
				COUNT(md.proses_id) total
			FROM dbo.ref_references r
			LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label)
			WHERE r.short_label IN ('UNPUBLISHED', 'PROVINCE-PUBLISHED', 'MUSDES-PUBLISHED', 'MUSDES-GRABBED', 'MUSDES-DOWNLOADED', 'MUSDES-SURVEY', 'MUSDES-SUBMITTED', 'MUSDES-NOT-FOUND')
			GROUP BY r.code, r.short_label, r.long_label, r.reference_id
			ORDER BY r.reference_id
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_prelist_awal($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
			r.reference_id,
			r.code,
			r.short_label,
			r.long_label,
			COUNT(md.proses_id) total
		FROM asset.master_data_proses md
		LEFT JOIN dbo.ref_references r ON $filter_area r.short_label = md.stereotype
		WHERE r.short_label = 'UNPUBLISHED'
		GROUP BY r.code, r.short_label, r.long_label, r.reference_id
		ORDER BY r.reference_id
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_total_prelist_akhir($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT
				r.reference_id,
				r.code,
				r.short_label,
				r.long_label,
				COUNT(md.proses_id) total
			FROM dbo.ref_references r
			LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label) AND (md.row_status IN ('NEW', 'COPY'))
			WHERE r.short_label IN ('MUSDES-SUBMITTED', 'VERIVALI-PUBLISHED', 'VERIVALI-GRABBED', 'VERIVALI-DOWNLOADED', 'VERIVALI-SURVEY', 'VERIVALI-SUBMITTED', 'VERIVALI-SUPERVISOR-APPROVED', 'VERIVALI-KORKAB-APPROVED', 'VERIVALI-FINAL')
			GROUP BY r.code, r.short_label, r.long_label, r.reference_id
			ORDER BY r.reference_id
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_usulan_baru_5_proses($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
		COUNT(md.proses_id) total
		FROM dbo.ref_references r
		LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label) AND md.row_status = 'NEW'
		WHERE r.short_label = 'MUSDES-SURVEY'
		";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_usulan_baru_5_selesai($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
		COUNT(md.proses_id) total
		FROM dbo.ref_references r
		LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label) AND md.row_status = 'NEW'
		WHERE r.short_label NOT IN ('UNPUBLISHED', 'PROVINCE-PUBLISHED', 'MUSDES-PUBLISHED', 'MUSDES-REVOKED', 'MUSDES-GRABBED', 'MUSDES-GRAB-REVOKED', 'MUSDES-DOWNLOADED', 'MUSDES-DOWNLOAD-REVOKED', 'MUSDES-SURVEY', 'MUSDES-SURVEY-REVOKED')
		";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_usulan_baru_6_proses($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
		COUNT(md.proses_id) total
		FROM dbo.ref_references r
		LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label) AND md.row_status = 'NEW'
		WHERE r.short_label = 'MUSDES-SUBMITTED'
		";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_usulan_baru_6_selesai($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
		COUNT(md.proses_id) total
		FROM dbo.ref_references r
		LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label) AND md.row_status = 'NEW'
		WHERE r.short_label NOT IN ('UNPUBLISHED', 'PROVINCE-PUBLISHED', 'MUSDES-PUBLISHED', 'MUSDES-REVOKED', 'MUSDES-GRABBED', 'MUSDES-GRAB-REVOKED', 'MUSDES-DOWNLOADED', 'MUSDES-DOWNLOAD-REVOKED', 'MUSDES-SURVEY', 'MUSDES-SURVEY-REVOKED', 'MUSDES-SUBMITTED')
		";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_invalid_musdes($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
			r.reference_id,
			r.code,
			r.short_label,
			r.long_label,
			COUNT(md.proses_id) total
		FROM
			dbo.ref_references r
			LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label)
		WHERE
			md.stereotype IN ( 'MUSDES-NOT-FOUND', 'VERIVALI-SUPERVISOR-APPROVED', 'VERIVALI-KORKAB-APPROVED', 'VERIVALI-FINAL' ) AND md.status_rumahtangga IN (1,2,3)
		GROUP BY r.code, r.short_label, r.long_label, r.reference_id
		ORDER BY r.reference_id
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_penanganan_kembali($area)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
			SELECT
				r.reference_id,
				r.code,
				r.short_label,
				r.long_label,
				COUNT(md.proses_id) total
			FROM
				dbo.ref_references r
				LEFT JOIN asset.master_data_proses md ON $filter_area (md.stereotype = r.short_label)
			WHERE
				r.short_label IN (
					'MUSDES-REVOKED',
					'MUSDES-GRAB-REVOKED',
					'MUSDES-DOWNLOAD-REVOKED',
					'MUSDES-SURVEY-REVOKED',
					'MUSDES-NOT-FOUND',
					'VERIVALI-REVOKED',
					'VERIVALI-GRAB-REVOKED',
					'VERIVALI-DOWNLOAD-REVOKED',
					'VERIVALI-SURVEY-REVOKED',
					'VERIVALI-SUBMITTED-REJECT',
					'VERIVALI-KORKAB-REJECTED',
					'VERIVALI-KORWIL-REJECTED',
					'VERIVALI-PENDING-QC-PUSAT'
				)
			GROUP BY r.code, r.short_label, r.long_label, r.reference_id
			ORDER BY r.reference_id
		";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function _get_hasil_verval($area, $status)
	{
		$filter_area = $this->_filter_area($area);

		$sql = "
		SELECT
			COUNT(md.proses_id) total
		FROM
			asset.master_data_proses md
		WHERE
			md.stereotype IN (
			'VERIVALI-SUBMITTED',
			'VERIVALI-SUPERVISOR-APPROVED',
			'VERIVALI-KORKAB-REJECTED',
			'VERIVALI-KORKAB-APPROVED',
			'VERIVALI-KORWIL-REJECTED',
			'VERIVALI-PENDING-QC-PUSAT',
			'VERIVALI-FINAL'
			) AND $filter_area md.row_status IN ('COPY', 'NEW') AND md.hasil_verivali = $status
		";

		$query = $this->db->query($sql);
		return $query->row('total');
	}

	private function _get_musdes_a($area, $row_status, $status_ruta)
	{
		$filter_area = $this->_filter_area($area);

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
		$filter_area = $this->_filter_area($area);

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

	private function _filter_area($area)
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

	function getPrelistByStereotype(){
		$kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
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
			$where = 'WHERE'.substr($where,4);
		}
		$q = "SELECT
				B.reference_id,
				B.code,
				B.long_label,
				B.icon,
					A.status_rumahtangga,
			    A.apakah_mampu,
				COUNT ( * ) as TOTAL
			FROM
				asset.master_data_proses A
				RIGHT JOIN ref_references B ON(B.short_label = A.stereotype)  
			".$where." 
			GROUP BY
				B.reference_id,
				B.code,
				B.long_label,
				B.icon,
			    A.status_rumahtangga,
			    A.apakah_mampu
			ORDER BY B.reference_id ASC" ;
		$result = $this->db->query($q)->result_array();
		
		$progressMusdes = $this->progressMusdes($result,$result_all_target); 
		$progressUB = $this->progressUB($result,$result_all_target); 
		$statusRTMusdes = $this->statusRTMusdes($result,$result_all_target); 
		$rekapMusdes = $this->rekapMusdes($result,$result_all_target); 
		$vervalValid = $this->vervalValid($result,$result_all_target); 
		$vervalInValid = $this->vervalInValid($result,$result_all_target); 

		// echo "<pre>";
		// print_r($progressMusdes);
		// print_r($progressUB);
		// print_r($statusRTMusdes);
		// print_r($rekapMusdes);
		// var_dump($rekapMusdes);
		// die();
		// rsort($progressMusdes, SORT_STRING | SORT_FLAG_CASE);
		$return_data = array(
			"total_data"=>$result_all_target->TOTAL_TARGET,
			"data"=>$result,
			"progressMusdes"=>$progressMusdes,
			"progressUB"=>$progressUB,
			"statusRTMusdes"=>$statusRTMusdes,
			"rekapMusdes"=>$rekapMusdes,
			"vervalValid"=>$vervalValid,
			"vervalInValid"=>$vervalInValid
		);

		echo json_encode($return_data); 
	}

	function progressMusdes($result,$result_all_target){
		$data = array();
		$progress_publish_musdes = array("0","1","2","3","4","5","6","7","8"); 

		for($i=0;$i<count($progress_publish_musdes);$i++){
			$data[$progress_publish_musdes[$i]]['status']= "";
			$data[$progress_publish_musdes[$i]]['ket']= "";
			$data[$progress_publish_musdes[$i]]['icon']= "";
			$data[$progress_publish_musdes[$i]]['tot_dlm_proses']= 0;
			$data[$progress_publish_musdes[$i]]['p_tot_dlm_proses']= 0;
			$data[$progress_publish_musdes[$i]]['tot_selesai_proses']= 0;
			$data[$progress_publish_musdes[$i]]['p_tot_selesai_proses']= 0;
			 
		}
		
		$data["0"]['tot_selesai_proses'] =$result_all_target->TOTAL_TARGET;
		$data["0"]['p_tot_selesai_proses'] = 100; 
		$data["0"]['ket'] = "PRELIST AWAL"; 
		$data["0"]['icon'] = "";

		foreach ($result as $value) {   
			if($value['reference_id'] > 0){
				$data["1"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["1"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["1"]['tot_selesai_proses']/
					$result_all_target->TOTAL_TARGET 
				) *100);
				$data["1"]['tot_dlm_proses'] = 
				$result_all_target->TOTAL_TARGET - 
				$data["1"]['tot_selesai_proses'];

				$data["1"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["1"]['tot_dlm_proses']/
					$result_all_target->TOTAL_TARGET
				) * 100);

				$data["1"]['ket'] = "Prelist Dipublish KORPROV"; 
				$data["1"]['status'] = "0";
				$data["1"]['icon'] = base_url()."assets/style/icon-status/hex-00-black.png";
			}

			if($value['reference_id'] > 1){
				$data["2"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["2"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["2"]['tot_selesai_proses']/
					$data["1"]['tot_selesai_proses'] 
				) * 100);
				$data["2"]['tot_dlm_proses'] = 
				$data["1"]['tot_selesai_proses'] - 
				$data["2"]['tot_selesai_proses'];

				$data["2"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["2"]['tot_dlm_proses']/
					$data["1"]['tot_selesai_proses']
				) * 100);
				$data["2"]['ket'] = "Prelist Dipublish KORKAB"; 
				$data["2"]['status'] = "1";
				$data["2"]['icon'] = base_url()."assets/style/icon-status/hex-01-gray.png";
			}

			if($value['reference_id'] > 2){
				$data["3"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["3"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["3"]['tot_selesai_proses']/
					$data["2"]['tot_selesai_proses'] 
				) * 100);

				$data["3"]['tot_dlm_proses'] = 
				$data["2"]['tot_selesai_proses'] - 
				$data["3"]['tot_selesai_proses'];

				$data["3"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["3"]['tot_dlm_proses']/
					$data["2"]['tot_selesai_proses']
				) * 100);
				$data["3"]['ket'] = "Prelist Dipilih ENUMERATOR"; 
				$data["3"]['status'] = "2";
				$data["3"]['icon'] = base_url()."assets/style/icon-status/hex-02-brown.png";
			}
			if($value['reference_id'] > 4){
				$data["4"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["4"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["4"]['tot_selesai_proses']/
					$data["3"]['tot_selesai_proses'] 
				) * 100);

				$data["4"]['tot_dlm_proses'] = 
				$data["3"]['tot_selesai_proses'] - 
				$data["4"]['tot_selesai_proses'];

				$data["4"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["4"]['tot_dlm_proses']/
					$data["3"]['tot_selesai_proses']
				) * 100);
				$data["4"]['ket'] = "Prelist Diterima ENUMERATOR"; 
				$data["4"]['status'] = "3";
				$data["4"]['icon'] = base_url()."assets/style/icon-status/hex-03-maroon.png";
			}
			if($value['reference_id'] > 6){
				$data["5"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["5"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["5"]['tot_selesai_proses']/
					$data["4"]['tot_selesai_proses'] 
				) * 100);

				$data["5"]['tot_dlm_proses'] = 
				$data["4"]['tot_selesai_proses'] - 
				$data["5"]['tot_selesai_proses'];

				$data["5"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["5"]['tot_dlm_proses']/
					$data["4"]['tot_selesai_proses']
				) * 100);
				$data["5"]['ket'] = "Prelist Dimulai MUSDES/MUSKEL"; 
				$data["5"]['status'] = "4";
				$data["5"]['icon'] = base_url()."assets/style/icon-status/hex-04-orange.png";
			}
			if($value['reference_id'] > 9){
				$data["6"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["6"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["6"]['tot_selesai_proses']/
					$data["5"]['tot_selesai_proses'] 
				) * 100);

				$data["6"]['tot_dlm_proses'] = 
				$data["5"]['tot_selesai_proses'] - 
				$data["6"]['tot_selesai_proses'];

				$data["6"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["6"]['tot_dlm_proses']/
					$data["5"]['tot_selesai_proses']
				) * 100);
				$data["6"]['ket'] = "Prelist Selesai MUSDES/MUSKEL"; 
				$data["6"]['status'] = "5";
				$data["6"]['icon'] = base_url()."assets/style/icon-status/hex-05-yellow.png";
			}
			if($value['reference_id'] > 9 && $value['status_rumahtangga'] == 1){
				$data["7"]['tot_selesai_proses'] += $value['TOTAL']; 	
				$data["7"]['ket'] = "Data VALID Hasil Musdes"; 
				$data["7"]['status'] = "6";
				$data["7"]['icon'] = base_url()."assets/style/icon-status/hex-06-green.png";
			}

			if(	$value['reference_id'] > 9 && 
				($value['status_rumahtangga'] == 2 OR $value['status_rumahtangga'] == 3)
			){
				$data["8"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["8"]['ket'] = "Data INVALID Hasil Musdes";
				$data["8"]['status'] = "6a";
				$data["8"]['icon'] = base_url()."assets/style/icon-status/hex-06a-green-white.png";
				 
			}
			 
		} 

		return $data;
	}
	function progressUB($result,$result_all_target){
		$data = array(); 

		for($i=0;$i<2;$i++){ 
			$data[$i]['ket']= "";
			$data[$i]['icon']= "";
			$data[$i]['tot_dlm_proses']= 0;
			$data[$i]['p_tot_dlm_proses']= 0;
			$data[$i]['tot_selesai_proses']= 0;
			$data[$i]['p_tot_selesai_proses']= 0; 
		}
		
		 
		foreach ($result as $value) {    
			if($value['reference_id'] >= 1 && $value['reference_id'] <= 8 && $value['status_rumahtangga'] == 4){
				$data[0]['tot_selesai_proses'] += $value['TOTAL']; 	
				$data[0]['ket']= "Prelist Selesai MUSDES/MUSKEL";
				$data[0]['icon']= base_url()."assets/style/icon-status/hex-05-yellow.png";
			}

			if(	$value['reference_id'] >= 9 &&  $value['status_rumahtangga'] == 4 ){
				$data[1]['tot_selesai_proses'] += $value['TOTAL']; 
				$data[1]['ket']= "USULAN BARU Hasil Musdes";
				$data[1]['icon']= base_url()."assets/style/icon-status/hex-06-green.png";
			}
			 
		}

		return $data;
	}
	function statusRTMusdes($result,$result_all_target){
		$data = array();
		$progress_data = array("0","1","2","3","4","5"); 

		for($i=0;$i<count($progress_data);$i++){
			$data[$progress_data[$i]]['status']= 0;
			$data[$progress_data[$i]]['ket']= "";
			$data[$progress_data[$i]]['tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['p_tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['tot_selesai_proses']= 0;
			$data[$progress_data[$i]]['p_tot_selesai_proses']= 0; 
		}
		
		 
		foreach ($result as $value) {    
			if($value['status_rumahtangga'] == 1 && $value['apakah_mampu'] == 2){
				$data["0"]['tot_selesai_proses'] += $value['TOTAL']; 	
				$data["0"]['ket'] = "Ditemukan 'Tidak Mampu'"; 	
			}

			if($value['status_rumahtangga'] == 1 && $value['apakah_mampu'] == 1){
				$data["1"]['tot_selesai_proses'] += $value['TOTAL']; 
				$data["1"]['ket'] = "Ditemukan 'Mampu'"; 	
			}

			if($value['status_rumahtangga'] == 2 && $value['reference_id'] > 1){
				$data["2"]['tot_selesai_proses'] += $value['TOTAL']; 
				$data["2"]['ket'] = "Tidak Ditemukan"; 
			}

			if($value['status_rumahtangga'] == 3){
				$data["3"]['tot_selesai_proses'] += $value['TOTAL']; 
				$data["3"]['ket']  = "Data Ganda"; 
			}

			if($value['status_rumahtangga'] == 4){
				$data["4"]['tot_selesai_proses'] = $result_all_target->TOTAL_TARGET; 
				$data["4"]['ket'] = "Prelist Awal Selesai Musdes/Muskel"; 
			}

			if($value['status_rumahtangga'] == 4){
				$data["5"]['tot_selesai_proses'] += $value['TOTAL']; ; 
				$data["5"]['ket'] = "Usulan Baru"; 
			} 
			 
		}

		return $data;
	}
	function rekapMusdes($result,$result_all_target){
		$data = array();
		$progress_data = array("0","1","2","3","4","5","6"); 

		for($i=0;$i<count($progress_data);$i++){
			$data[$progress_data[$i]]['status']= 0;
			$data[$progress_data[$i]]['ket']= "";
			$data[$progress_data[$i]]['tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['p_tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['tot_selesai_proses']= 0;
			$data[$progress_data[$i]]['p_tot_selesai_proses']= 0; 
		}
		
		$data["0"]['tot_selesai_proses'] = $result_all_target->TOTAL_TARGET;
		$data["0"]['ket'] = "I. Prelist Awal Selesai Musdes/Muskel";


		$statusRTMusdes = $this->statusRTMusdes($result,$result_all_target);
		$data["1"]['tot_selesai_proses'] = 
		$statusRTMusdes[0]['tot_selesai_proses']+
		$statusRTMusdes[1]['tot_selesai_proses']+
		$statusRTMusdes[5]['tot_selesai_proses'];
		$data["1"]['ket'] = "A. Valid Musdes";

		$data["2"]['tot_selesai_proses'] = 
		$statusRTMusdes[2]['tot_selesai_proses']+
		$statusRTMusdes[3]['tot_selesai_proses'];
		$data["2"]['ket'] = "B. Invalid Musdes";

		$data["3"]['tot_selesai_proses'] =  $statusRTMusdes[5]['tot_selesai_proses'];
		$data["3"]['ket'] = "C. Usulan Baru";

		$data["4"]['tot_selesai_proses'] =  
		$data[1]['tot_selesai_proses']+
		$data[2]['tot_selesai_proses']+
		$data[3]['tot_selesai_proses'];
		$data["4"]['ket'] = "II. Prelist Akhir (% Prelist Selesai Musdes)";

		$data["5"]['tot_selesai_proses'] = $result_all_target->TOTAL_TARGET;
		$data["5"]['ket'] = "III. Target Prelist Akhir (% Prelist Awal)";

		$data["6"]['tot_selesai_proses'] = $data["4"]['tot_selesai_proses']; 
		$data["6"]['ket'] = "IV. Prelist Akhir (% Prelist Akhir)";

		return $data;
	} 
	function vervalValid($result,$result_all_target){
		$data = array();
		$progress_data = array("0","1","2","3","4","5","6","7","8","9"); 

		for($i=0;$i<count($progress_data);$i++){
			$data[$progress_data[$i]]['status']= 0;
			$data[$progress_data[$i]]['ket']= "";
			$data[$progress_data[$i]]['tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['p_tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['tot_selesai_proses']= 0;
			$data[$progress_data[$i]]['p_tot_selesai_proses']= 0; 
		}
		$rekapMusdes = $this->rekapMusdes($result,$result_all_target);
		$data["0"]['tot_selesai_proses'] = $rekapMusdes[6]['tot_selesai_proses'];
		$data["0"]['p_tot_selesai_proses'] = 100;
		$data["0"]['ket'] = "Prelist Akhir";

 		foreach ($result as $value) {   
			if($value['reference_id'] > 9 && $value['status_rumahtangga'] == 1){
				$data["1"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["1"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["1"]['tot_selesai_proses']/
					$rekapMusdes[6]['tot_selesai_proses'] 
				) *100);
				$data["1"]['tot_dlm_proses'] = 
				$rekapMusdes[6]['tot_selesai_proses'] - 
				$data["1"]['tot_selesai_proses'];

				$data["1"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["1"]['tot_dlm_proses']/
					$rekapMusdes[6]['tot_selesai_proses']
				) * 100);

				$data["1"]['ket'] = "DATA VALID Hasil Musdes"; 
				$data["1"]['status'] = "6";
				$data["1"]['icon'] = base_url()."assets/style/icon-status/hex-06-green.png";
			}

			if($value['reference_id'] > 12 && $value['status_rumahtangga'] == 1){
				$data["2"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["2"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["2"]['tot_selesai_proses']/
					$data["1"]['tot_selesai_proses']
				) *100);
				$data["2"]['tot_dlm_proses'] = 
				$data["1"]['tot_selesai_proses'] - 
				$data["2"]['tot_selesai_proses'];

				$data["2"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["2"]['tot_dlm_proses']/
					$data["1"]['tot_selesai_proses']
				) * 100);

				$data["2"]['ket'] = "Prelist Akhir DIPUBLISH KORKAB"; 
				$data["2"]['status'] = "7";
				$data["2"]['icon'] = base_url()."assets/style/icon-status/hex-07-brown.png";
			}
			if($value['reference_id'] > 14 && $value['status_rumahtangga'] == 1){
				$data["3"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["3"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["3"]['tot_selesai_proses']/
					$data["2"]['tot_selesai_proses']
				) *100);
				$data["3"]['tot_dlm_proses'] = 
				$data["2"]['tot_selesai_proses'] - 
				$data["3"]['tot_selesai_proses'];

				$data["3"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["3"]['tot_dlm_proses']/
					$data["2"]['tot_selesai_proses']
				) * 100);

				$data["3"]['ket'] = "Prelist Akhir DITERIMA ENUMERATOR"; 
				$data["3"]['status'] = "8";
				$data["3"]['icon'] = base_url()."assets/style/icon-status/hex-08-maroon.png";
			}
			if($value['reference_id'] > 16 && $value['status_rumahtangga'] == 1){
				$data["4"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["4"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["4"]['tot_selesai_proses']/
					$data["3"]['tot_selesai_proses']
				) *100);
				$data["4"]['tot_dlm_proses'] = 
				$data["3"]['tot_selesai_proses'] - 
				$data["4"]['tot_selesai_proses'];

				$data["4"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["4"]['tot_dlm_proses']/
					$data["3"]['tot_selesai_proses']
				) * 100);

				$data["4"]['ket'] = "Prelist Akhir DIUNDUH ENUMERATOR"; 
				$data["4"]['status'] = "9";
				$data["4"]['icon'] = base_url()."assets/style/icon-status/hex-09-orange.png";
			}
			if($value['reference_id'] > 18 && $value['status_rumahtangga'] == 1){
				$data["5"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["5"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["5"]['tot_selesai_proses']/
					$data["4"]['tot_selesai_proses']
				) *100);
				$data["5"]['tot_dlm_proses'] = 
				$data["4"]['tot_selesai_proses'] - 
				$data["5"]['tot_selesai_proses'];

				$data["5"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["5"]['tot_dlm_proses']/
					$data["4"]['tot_selesai_proses']
				) * 100);

				$data["5"]['ket'] = "PROSES VERIVALI Rumah Tangga"; 
				$data["5"]['status'] = "10";
				$data["5"]['icon'] = base_url()."assets/style/icon-status/hex-10-yellow.png";
			}
			if($value['reference_id'] > 20 && $value['status_rumahtangga'] == 1){
				$data["6"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["6"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["6"]['tot_selesai_proses']/
					$data["5"]['tot_selesai_proses']
				) *100);
				$data["6"]['tot_dlm_proses'] = 
				$data["5"]['tot_selesai_proses'] - 
				$data["6"]['tot_selesai_proses'];

				$data["6"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["6"]['tot_dlm_proses']/
					$data["5"]['tot_selesai_proses']
				) * 100);

				$data["6"]['ket'] = "SELESAI VERIVALI Rumah Tangga"; 
				$data["6"]['status'] = "11";
				$data["6"]['icon'] = base_url()."assets/style/icon-status/hex-11-green.png";
			}
			if($value['reference_id'] > 22 && $value['status_rumahtangga'] == 1){
				$data["7"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["7"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["7"]['tot_selesai_proses']/
					$data["6"]['tot_selesai_proses']
				) *100);
				$data["7"]['tot_dlm_proses'] = 
				$data["6"]['tot_selesai_proses'] - 
				$data["7"]['tot_selesai_proses'];

				$data["7"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["7"]['tot_dlm_proses']/
					$data["6"]['tot_selesai_proses']
				) * 100);

				$data["7"]['ket'] = "Data APPROVED PENGAWAS"; 
				$data["7"]['status'] = "12";
				$data["7"]['icon'] = base_url()."assets/style/icon-status/hex-12-blue.png";
			}
			if($value['reference_id'] > 24 && $value['status_rumahtangga'] == 1){
				$data["8"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["8"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["8"]['tot_selesai_proses']/
					$data["7"]['tot_selesai_proses']
				) *100);
				$data["8"]['tot_dlm_proses'] = 
				$data["7"]['tot_selesai_proses'] - 
				$data["8"]['tot_selesai_proses'];

				$data["8"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["8"]['tot_dlm_proses']/
					$data["7"]['tot_selesai_proses']
				) * 100);

				$data["8"]['ket'] = "Data APPROVED KORKAB"; 
				$data["8"]['status'] = "13";
				$data["8"]['icon'] = base_url()."assets/style/icon-status/hex-13-purple.png";
			}
			if($value['reference_id'] > 24 && $value['status_rumahtangga'] == 1){
				$data["9"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["9"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["9"]['tot_selesai_proses']/
					$data["8"]['tot_selesai_proses']
				) *100);
				$data["9"]['tot_dlm_proses'] = 
				$data["8"]['tot_selesai_proses'] - 
				$data["9"]['tot_selesai_proses'];

				$data["9"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["9"]['tot_dlm_proses']/
					$data["8"]['tot_selesai_proses']
				) * 100);

				$data["9"]['ket'] = "Data APPROVED KORWIL"; 
				$data["9"]['status'] = "14";
				$data["9"]['icon'] = base_url()."assets/style/icon-status/hex-14-pink.png";
			}
		} 
		return $data;
	} 
	function vervalInValid($result,$result_all_target){
		$data = array();
		$progress_data = array("0","1","2","3","4"); 

		for($i=0;$i<count($progress_data);$i++){
			$data[$progress_data[$i]]['status']= 0;
			$data[$progress_data[$i]]['ket']= "";
			$data[$progress_data[$i]]['tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['p_tot_dlm_proses']= 0;
			$data[$progress_data[$i]]['tot_selesai_proses']= 0;
			$data[$progress_data[$i]]['p_tot_selesai_proses']= 0; 
		}
		$rekapMusdes = $this->rekapMusdes($result,$result_all_target);
		$data["0"]['tot_selesai_proses'] = $rekapMusdes[6]['tot_selesai_proses'];
		$data["0"]['p_tot_selesai_proses'] = 100;
		$data["0"]['ket'] = "Prelist Akhir";

 		foreach ($result as $value) {   
			if($value['reference_id'] > 9 && ($value['status_rumahtangga'] == 1 || $value['status_rumahtangga'] == 3)){
				$data["1"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["1"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["1"]['tot_selesai_proses']/
					$rekapMusdes[6]['tot_selesai_proses'] 
				) *100);
				$data["1"]['tot_dlm_proses'] = 
				$rekapMusdes[6]['tot_selesai_proses'] - 
				$data["1"]['tot_selesai_proses'];

				$data["1"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["1"]['tot_dlm_proses']/
					$rekapMusdes[6]['tot_selesai_proses']
				) * 100);

				$data["1"]['ket'] = "DATA INVALID Hasil Musdes"; 
				$data["1"]['status'] = "6a";
				$data["1"]['icon'] = base_url()."assets/style/icon-status/hex-06a-green-white.png";
			} 
			if($value['reference_id'] > 22 && $value['status_rumahtangga'] > 1){
				$data["2"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["2"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["2"]['tot_selesai_proses']/
					$data["1"]['tot_selesai_proses']
				) *100);
				$data["2"]['tot_dlm_proses'] = 
				$data["1"]['tot_selesai_proses'] - 
				$data["2"]['tot_selesai_proses'];

				$data["2"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["2"]['tot_dlm_proses']/
					$data["1"]['tot_selesai_proses']
				) * 100);

				$data["2"]['ket'] = "Data APPROVED PENGAWAS"; 
				$data["2"]['status'] = "12";
				$data["2"]['icon'] = base_url()."assets/style/icon-status/hex-12-blue.png";
			}
			if($value['reference_id'] > 24 && $value['status_rumahtangga'] > 1){
				$data["3"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["3"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["3"]['tot_selesai_proses']/
					$data["2"]['tot_selesai_proses']
				) *100);
				$data["3"]['tot_dlm_proses'] = 
				$data["2"]['tot_selesai_proses'] - 
				$data["3"]['tot_selesai_proses'];

				$data["2"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["3"]['tot_dlm_proses']/
					$data["2"]['tot_selesai_proses']
				) * 100);

				$data["3"]['ket'] = "Data APPROVED KORKAB"; 
				$data["3"]['status'] = "13";
				$data["3"]['icon'] = base_url()."assets/style/icon-status/hex-13-purple.png";
			}
			if($value['reference_id'] > 24 && $value['status_rumahtangga'] > 1){
				$data["4"]['tot_selesai_proses'] += $value['TOTAL'];
				$data["4"]['p_tot_selesai_proses'] = 
				number_format(
				(	$data["4"]['tot_selesai_proses']/
					$data["3"]['tot_selesai_proses']
				) *100);
				$data["4"]['tot_dlm_proses'] = 
				$data["3"]['tot_selesai_proses'] - 
				$data["4"]['tot_selesai_proses'];

				$data["4"]['p_tot_dlm_proses'] = 
				number_format(
				(
					$data["4"]['tot_dlm_proses']/
					$data["3"]['tot_selesai_proses']
				) * 100);

				$data["4"]['ket'] = "Data APPROVED KORWIL"; 
				$data["4"]['status'] = "14";
				$data["4"]['icon'] = base_url()."assets/style/icon-status/hex-14-pink.png";
			}
		} 
		return $data;
	} 
}
