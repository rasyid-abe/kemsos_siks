<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_verval extends Backend_Controller {

	public function __construct() {
		parent::__construct();

		$this->dir = base_url( 'rekap/status_verval/' );
	}

	function index() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['title'] = 'Rekapitulasi Status Verval';
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

		$this->template->title( 'Rekapitulasi Status Verval' );
		$this->template->content( "admin/rekap/status_verval", $data );
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

	function get_status_verval(){
        $kd_prop = $this->input->post('kd_prop');
		$kd_kab = $this->input->post('kd_kab');
		$kd_kec = $this->input->post('kd_kec');
		$return_data = array();


		$select = "l.nm_prop AS NAME,";
		$group_by = "GROUP BY l.nm_prop, l.kdprop";
		$order_by = "ORDER BY l.nm_prop";
		$where = " WHERE l.kdprop = '".$kd_prop."'";
		$where_status0 = "A.kode_propinsi = l.kdprop";
		if(empty($kd_prop) && empty($kd_kab) && empty($kd_kec)){
			$where = "WHERE ";
		}else{
			$where = "";
			if(!empty($kd_prop)){
				$select = "l.nm_kab AS NAME";
				$group_by = "l.nm_prop, l.kdprop,l.nm_kab, l.kdkab ";
				$order_by = "l.nm_kab";
				$where .= " AND l.kdprop = '".$kd_prop."'";
				$where_status0 = "A.kode_propinsi = l.kdprop AND A.kode_kabupaten = l.kdkab";
			}
			if(!empty($kd_kab)){
				$select = "l.nm_kec AS NAME";
				$group_by = "l.nm_prop, l.kdprop,l.nm_kab, l.kdkab,l.nm_kec, l.kdkec ";
				$order_by = " l.nm_kec";
				$where .= " AND l.kdkab = '".$kd_kab."'";
				$where_status0 = "A.kode_propinsi = l.kdprop AND A.kode_kabupaten = l.kdkab AND A.kode_kecamatan = l.kdkec";
			}
			if(!empty($kd_kec)){
				$select = " l.nm_desa AS NAME";
				$group_by = "l.nm_prop, l.kdprop,l.nm_kab, l.kdkab,l.nm_kec, l.kdkec , l.nm_desa, l.kddesa";
				$order_by = " l.nm_desa";
				$where .= " AND l.kdkec = '".$kd_kec."'";
				$where_status0 = "A.kode_propinsi = l.kdprop AND A.kode_kabupaten = l.kdkab AND A.kode_kecamatan = l.kdkec AND A.kode_desa = l.kddesa";
			}
			$where = 'WHERE'.substr($where,4)." AND ";
			$select = $select.",";
			$group_by = 'GROUP BY '.$group_by;
			$order_by = 'ORDER BY '.$order_by;
		}

		$query = "SELECT ".$select."
				COUNT ( md.proses_id ) AS jumlah_data,
				SUM ( CASE WHEN (( md.HASIL_VERIVALI ) IN ( '1' )) THEN 1 ELSE 0 END ) AS selesai_cacah,
				SUM ( CASE WHEN (( md.HASIL_VERIVALI ) IN ( '2' )) THEN 1 ELSE 0 END ) AS tidak_ditemukan,
				SUM ( CASE WHEN (( md.HASIL_VERIVALI ) IN ( '3' )) THEN 1 ELSE 0 END ) AS ruta_pindah,
				SUM ( CASE WHEN ( md.HASIL_VERIVALI IN ( '4' )) THEN 1 ELSE 0 END ) AS bagian_dr_dokumen,
				SUM ( CASE WHEN ( md.HASIL_VERIVALI IN ( '5' )) THEN 1 ELSE 0 END ) AS menolak,
				SUM ( CASE WHEN ( md.HASIL_VERIVALI IN ( '6' )) THEN 1 ELSE 0 END ) AS ganda
			 	FROM
				[asset].[master_data_proses] md
				RIGHT JOIN [dbo].[target_desa] l
				ON (
					md.kode_propinsi= l.kdprop
					AND md.kode_kabupaten= l.kdkab
					AND md.kode_kecamatan= l.kdkec
					AND md.kode_desa= l.kddesa
					)
			 	".$where." hasil_verivali IS NOT NULL
			 	AND hasil_verivali !=0
				AND ( md.stereotype = 'VERIVALI-SUBMITTED' OR
						md.stereotype = 'VERIVALI-SUPERVISOR-APPROVED' OR
						md.stereotype = 'VERIVALI-KORKAB-REJECTED' OR
						md.stereotype = 'VERIVALI-KORKAB-APPROVED' OR
						md.stereotype = 'VERIVALI-KORWIL-REJECTED' OR
						md.stereotype = 'VERIVALI-PENDING-QC-PUSAT' OR
						md.stereotype = 'VERIVALI-FINAL' )
			 	".$group_by." ".$order_by;

		$result = $this->db->query($query)->result_array();

		// echo "<pre>";
		// print_r($data);
		// die();
		// echo $query;

		echo json_encode($result);
	}
}
