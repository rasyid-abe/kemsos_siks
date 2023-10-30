<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_hasil_musdes extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'rekap/laporan_hasil_musdes/' );
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['title'] = 'Laporan Hasil Musdes/Muskel Per Desa';
		$data['cari'] = $this->form_cari();
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
		$this->template->title( 'Laporan Hasil Musdes/Muskel Per Desa' );
		$this->template->content( "admin/rekap/laporan_hasil_musdes", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function form_cari() {
		$option_propinsi = '<option value="0">Pilih Provinsi</option>';
		$option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';

		$this->db->select('bps_province_code, full_name');
		$query_propinsi = $this->db->get_where('dbo.ref_locations', ['name_prefix' => 'Propinsi']);
		foreach ( $query_propinsi->result() as $key => $value ) {
			$option_propinsi .= '<option value="' . $value->bps_province_code . '">' . $value->full_name . '</option>';
		}

		$form_cari = '
		<div class="row" style="margin-bottom:-15px">
		<div class="form-group col-md-2">
		<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" ' .  ( ( ! empty( $user_location['province_id'] )  ) ? 'disabled ' : '' ) . '>
		' . $option_propinsi . '
		</select>
		</div>
		<div class="form-group col-md-3">
		<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" ' . ( ( ! empty( $user_location['regency_id'] )  ) ? 'disabled ' : '' ) . '>
		' . $option_kota . '
		</select>
		</div>
		<div class="form-group col-md-2">
		<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control" ' . ( ( ! empty( $user_location['district_id'] )  ) ? 'disabled ' : '' ) . '>
		' . $option_kecamatan . '
		</select>
		</div>
		<div class="form-group col-md-3">
		<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" ' . ( ( ! empty( $user_location['village_id'] )  ) ? 'disabled ' : 'disabled' ) . '>
		' . $option_kelurahan . '
		</select>
		</div>
		<div class="form-group col-md-2">
		<button type="button" id="cari" class="btn btn-info btn-sm"><i class="fa fa-search"></i>&nbsp;Cari</button>
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
}
