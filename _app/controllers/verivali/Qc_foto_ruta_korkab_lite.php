<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// show status 14
class Qc_foto_ruta_korkab_lite extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/qc_foto_ruta_korkab_lite/' );
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
		$data['cari'] = $this->form_cari();
		$data['paste_url'] = $this->dir;
		$data['grid'] = [
			'col_id' => 'proses_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'status_code', display:'Kode Status', width:50, sortable:true, align:'center', datasuorce: false, hide: true},
				{ name:'jenis', display:'Jenis', width:50, sortable:false, align:'center', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:170, sortable:true, align:'left', datasuorce: false},
				{ name:'informasi_data', display:'Informasi Data', width:220, sortable:true, align:'left', datasuorce: false},
				{ name:'informasi_jumlah_art', display:'Informasi Jumlah ART', width:220, sortable:true, align:'left', datasuorce: false},
				{ name:'kepersetaan_program', display:'Kepersetaan Program', width:220, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_ktp', display:'Foto KTP', width:120, sortable:false, align:'center', datasuorce: false},
				{ name:'foto_kk', display:'Foto KK', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_responden', display:'Foto Responden', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:80, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Approve ke 13', name:'approve', bclass:'publish', onpress:act_selected12, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Reject ke Status 12a', name:'reject12a', bclass:'unpublish', onpress:act_selected12, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
			",
			'filters' => "
				{ display:'Nama Menu', name:'menu_name', type:'text', isdefault: true },
				{ display:'Status', name:'menu_is_active', type:'select', option: '1:Aktif|0:Tidak Aktif' },
			",
		];
		$data['grid']['title'] = 'Quality Control Foto Rumah Tangga';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['grid']['table_title'] = 'Quality Control Foto Rumah Tangga';
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
							$( "#select-kabupaten ").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
						} else {
							get_location(params);
						}
						$( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
						$( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "4",
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
							"location_id": $(this).val(),
							"level": "5",
							"title": "Kelurahan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
						} else {
							get_location(params);
						}
					});

					$( "button#cari" ).on( "click", function(){
						$("#load_page").removeClass("hidden");
						$("#loader").modal("show");
						$( "#gridview" ).flexOptions({
							url: "' . $this->dir . 'get_show_data",
							params: [
								{
									"province_id": $( "#select-propinsi ").val(),
									"regency_id": $( "#select-kabupaten ").val(),
									"district_id": $( "#select-kecamatan ").val(),
									"village_id": $( "#select-kelurahan ").val(),
									"stereotype": $( "#select-status ").val(),
									"row_status": $( "#select-jenis ").val(),
									"hasil_verivali": $( "#select-hasil-verivali ").val(),
									"jml_foto": $( "#select-foto ").val(),
									"status_nik": $( "#select-nik ").val(),
								},
							],
						}).flexReload();
						$("#loader").modal("hide");
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

					$(".bDiv").on( "click", "table#gridview tbody tr", function(){
						let code = [];
						let tr_selected = $("table#gridview tbody tr.trSelected");
						if ( tr_selected.length > 0 ){
							tr_selected.each(function(x,y){
								code.push( $(this).find("[abbr=status_code]").text() );
							});
						}
						if( $.inArray( "12", code) !== -1){
							$(".publish").show();
							$(".publish").parent().parent().nextAll(".btnseparator").show();
							$(".unpublish").show();
						} else {
							$(".publish").hide();
							$(".publish").parent().parent().nextAll(".btnseparator").hide();
							$(".unpublish").hide();
						}
					});
				});

				$(".bDiv").ready( function(){
					$(".publish").hide();
					$(".publish").parent().parent().nextAll(".btnseparator").hide();
					$(".unpublish").hide();
				});
			</script>
		';
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_view_qc_foto", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data(){
		$input = $this->input->post();
		$where = [];
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $field == 'stereotype' || $field == 'row_status' || $field == 'hasil_verivali') {
					if ( $value > '0' ) $where['md.' . $field] = $value;
					else $where["md.stereotype IN ('VERIVALI-SUBMITTED',
								'VERIVALI-SUPERVISOR-APPROVED',
								'VERIVALI-KORKAB-REJECTED',
								'VERIVALI-KORKAB-APPROVED',
								'VERIVALI-KORWIL-REJECTED',
								'VERIVALI-PENDING-QC-PUSAT',
								'VERIVALI-FINAL') "] = null;
				}
				elseif($field == 'jml_foto')
				{
					if ($value == 'ZERO')
						$where['md.' . $field] = '0';
					else if ($value == 'KURANG')
						$where['md.' . $field .'<9'] = null;
					else if ($value == 'LEBIH')
						$where['md.' . $field .'>=9'] = null;
				}
				elseif($field == 'status_nik')
				{
					if ($value == 'VALID')
						$where["md.nomor_nik IS NOT NULL AND md.nomor_kk_krt IS NOT NULL AND md.nomor_nik <> '' AND md.nomor_kk_krt <> ''"] = null;
					else if ($value == 'INVALID')
						$where["(md.nomor_nik IS NULL OR md.nomor_kk_krt IS NULL OR md.nomor_nik = '' OR md.nomor_kk_krt = '')"] = null;

				} else {
					if ( $value > '0' ) $where['l.' . $field] = $value;
				}
			}
		} else {
			if ( ( ! empty( $this->user_info['user_location'] ) ) || ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE ) ) {
				$user_location = $this->get_user_location();
				$jml_negara = ( ( ! empty( $user_location['country_id'] ) ) ? count( explode( ',', $user_location['country_id'] ) ) : '0' );
				$jml_propinsi = ( ( ! empty( $user_location['province_id'] ) ) ? count( explode( ',', $user_location['province_id'] ) ) : '0' );
				$jml_kota = ( ( ! empty( $user_location['regency_id'] ) ) ? count( explode( ',', $user_location['regency_id'] ) ) : '0' );
				$jml_kecamatan = ( ( ! empty( $user_location['district_id'] ) ) ? count( explode( ',', $user_location['district_id'] ) ) : '0' );
				$jml_kelurahan = ( ( ! empty( $user_location['village_id'] ) ) ? count( explode( ',', $user_location['village_id'] ) ) : '0' );


				if ( ! empty( $jml_negara) ) $where['l.country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null;
				if ( ! empty( $jml_propinsi) ) $where['l.province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : "= {$user_location['province_id']}" )] = null;
				if ( ! empty( $jml_kota) ) $where['l.regency_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;
				if ( ! empty( $jml_kecamatan) ) $where['l.district_id ' . ( ( $jml_kecamatan >= '2' ) ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}" )] = null;
				if ( ! empty( $jml_kelurahan) ) $where['l.village_id ' . ( ( $jml_kelurahan >= '2' ) ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}" )] = null;

				if ( isset( $input['params'] ) ) {
					$par = $input['params'];
					$params = json_decode( $par, true );
					foreach ( $params[0] as $field => $value ) {
						if ( $value > '0' ) $where['l.' . $field] = $value;
					}
				}
			} else {
				$where['l.country_id'] = '0';
				$where['l.province_id'] = '0';
				$where['l.regency_id'] = '0';
				$where['l.district_id'] = '0';
				$where['l.village_id'] = '0';
			}
			$where["md.stereotype IN ('VERIVALI-SUBMITTED',
								'VERIVALI-SUPERVISOR-APPROVED',
								'VERIVALI-KORKAB-REJECTED',
								'VERIVALI-KORKAB-APPROVED',
								'VERIVALI-KORWIL-REJECTED',
								'VERIVALI-PENDING-QC-PUSAT',
								'VERIVALI-FINAL') "] = null;
		}
		$params = [
			'table' => [
				'asset.view_all_proses_data_new md' => '',
				'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left'],
				'dbo.ref_references r' => ['r.short_label = md.stereotype', 'left']
			],
			'select' => '
				md.*,
				l.province_name,
				l.regency_name,
				l.district_name,
				l.village_name,
				r.icon,
				r.code',
			'order_by' => 'md.lastupdate_on ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
			'where' => $where,
		];
		if ( ! empty( $input['filterRules'] ) ) {
			$filterRules = filter_json( $input['filterRules'] );
			$params = array_merge( $params, $filterRules );
		}
		$query = get_data( $params );
		$params_count = [
			'table' => [
				'asset.view_all_proses_data_new md' => '',
				'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left']
			],
			'select' => 'count(id_prelist) jumlah',
			'where' => $where,
		];
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$status_rumahtangga = ['1' => 'Ditemukan', 'Tidak Ditemukan', 'Data Ganda', 'Usulan Baru'];
			$is_mampu = ['1' => 'Ya', 'Tidak'];
			$hasil_verivali =['1' => 'Selesai Dicacah', 'Rumah tangga tidak ditemukan', 'Rumah tangga pindah/bangunan sudah tidak ada', 'Bagian dari rumah tangga di dokumen', 'Responden Menolak', 'Data Ganda'];

			$path_foto = base_url('assets/style/icon-status');
			$url = 'http://66.96.235.136:8080/apiverval/';
			$foto_ktp = '<a href="'.$url.substr($row->f_ktp, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_ktp, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_kk = '<a href="'.$url.substr($row->f_kk, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_kk, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_responden = '<a href="'.$url.substr($row->f_krt, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_krt, 2).'" class="img-fluid m-b-10" alt="">
						</a>';

			$detail = '<button class="btn-edit" act="' . base_url( "verivali/detail_data/get_form_detail/" . enc( ['proses_id' => $row->parent_id, 'stereotype' => $row->stereotype] ) ) . '"><i class="fa fa-search"></i></button>';
			$informasi_data = '
				<span>
					Kecamatan: ' . $row->district_name . '<br>
					Kelurahan: ' . $row->village_name . '<br>
					Nama KRT: ' . $row->nama_krt . '<br>
					Kelamin KRT: ' . ( ( $row->jenis_kelamin_krt == "1" ) ? "1 = Laki-Laki" : "2 = Perempuan" ) . '<br>
					NIK KRT: ' . $row->nomor_nik . '<br>
					No. KK KRT: ' . $row->nomor_kk_krt . ' <br>
					<br>
					Hasil Musdes: ' . ( ( $row->status_rumahtangga != '' ) ? $status_rumahtangga[$row->status_rumahtangga] : '' ) . ' <br>
					Keluraga Mampu: ' . ( ( $row->apakah_mampu != '' ) ? $is_mampu[$row->apakah_mampu] : '' ) . '<br>
					Hasil Verivali: ' . ( ( $row->hasil_verivali != '' ) ? $hasil_verivali[$row->hasil_verivali] : '' ) . '<br>
					<br>
					Durasi Interview: ' . $row->interview_duration . ' <br>
				</span>';
				$informasi_jumlah_art = '
				<span>
					Jumlah No KK: ' . $row->jml_no_kk . ' <br>
					Jumlah ART: ' . $row->jml_art . ' <br>
					Jumlah NIK: ' . $row->jml_nik . ' <br>
					Jumlah Keberadaan ART: ' . $row->jml_keberadaan_art . ' <br>
					Total Foto: ' . $row->jml_foto . ' <br>
					Jumlah Anak Dalam Tanggungan: ' . $row->jml_anak_dlm_tanggungan . ' <br>
					Jumlah Usaha ART: ' . $row->jml_usaha_art . ' <br>
					<br>
					Jumlah ART Status KRT: ' . $row->jml_kepala_rumah_tangga . ' <br>
					Jumlah ART Status KK: ' . $row->jml_kepala_keluarga . ' <br>
					Jumlah ART Status Istri: ' . $row->jml_art_istri . ' <br>
					Jumlah ART Status Anak: ' . $row->jml_art_anak . ' <br>
					Jumlah Nama Ibu Kandung: ' . $row->jml_nama_ibu_kandung . ' <br>
				</span>';
				$kepersetaan_program = '
				<span>
					Peserta KKS/KPS: ' . $row->jml_kks . ' <br>
					Peserta KIS/PBI JKN: ' . $row->jml_pbi . ' <br>
					Peserta KIP/BSM: ' . $row->jml_kip . ' <br>
					Peserta PKH: ' . $row->jml_pkh . ' <br>
					Peserta Raskin/Rastra: ' . $row->jml_rastra . ' <br>
					<br>
					Ruta Peserta KKS/KPS: ' . $row->status_kks . ' <br>
					Ruta Peserta KIP/BSM: ' . $row->status_kip . ' <br>
					Ruta Peserta KIS/PBI JKN: ' . $row->status_kis . ' <br>
					Ruta Peserta BPJS Mandiri: ' . $row->status_bpjs_mandiri . ' <br>
					Ruta Peserta Jamsostek: ' . $row->status_jamsostek . ' <br>
					Ruta Peserta Asuransi: ' . $row->status_asuransi . ' <br>
					Ruta Peserta PKH: ' . $row->status_pkh . ' <br>
					Ruta Peserta Raskin/Rastra: ' . $row->status_rastra . ' <br>
					Ruta Peserta KUR: ' . $row->status_kur . ' <br>
				</span>';
			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'status' => '<img src="' . base_url('assets/style/icon-status/') . $row->icon . '">',
					'status_code' => $row->code,
					'jenis' => '<img src="' . base_url() . ( ( $row->row_status == 'COPY' ) ? 'assets/style/package-blue.png' : 'assets/style/package-green.png' ) . '" ' .  ( ( $row->row_status == 'COPY' ) ? 'title="Prelist Awal" alt="Prelist Awal"' : 'title="Usulan Baru" alt="Usulan Baru"') . '>',
					'id_prelist' => $row->id_prelist,
					'informasi_data' => $informasi_data,
					'informasi_jumlah_art' => $informasi_jumlah_art,
					'kepersetaan_program' => $kepersetaan_program,
					'foto_ktp' => $foto_ktp,
					'foto_kk' => $foto_kk,
					'foto_responden' => $foto_responden,
					'detail' => $detail,
				]
			];
			$data[] = $row_data;
		}
		$result = [
			'status' => 200,
			'total' => $query->num_rows(),
			'rows' => $data,
			'page' => $input['page'],
			'total' => $query_count->row('jumlah')
		];
		echo json_encode( $result );
	}

	function act_show(){
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// approve
		if ( isset( $in['approve'] ) && $in['approve'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get_audit_trail = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'audit_trails'
					];
					$user_ip = client_ip();
					$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );
					$audit_trails[] = [
						"ip" => $user_ip['ip_address'],
						"on" => $datetime,
						"act" => "UPDATED",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-KORKAB-APPROVED'
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-KORKAB-APPROVED',
							'audit_trails' => json_encode( $audit_trails ),
							'lastupdate_on' => $datetime,
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data( $params_update_master_data );
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data( $params_get )->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-KORKAB-APPROVED',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date( "Y-m-d H:i:s"),
					];
					save_data( 'asset.master_data_log', $params_insert_master_data_log );

					$success++;
				}

				$arr_output['message'] = $success .' data berhasil diapprove.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		// reject12a
		if ( isset( $in['reject12a'] ) && $in['reject12a'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ($arr_id as $id) {
					$params_get_audit_trail = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'audit_trails'
					];
					$user_ip = client_ip();
					$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );
					$audit_trails[] = [
						"ip" => $user_ip['ip_address'],
						"on" => $datetime,
						"act" => "UPDATED",
						"user_id" => $this->user_info['user_id'],
						"username" => $this->user_info['user_username'],
						"column_data" => [
							"asset_id" => $id,
							"stereotype" => 'VERIVALI-KORKAB-REJECTED'
						],
						"is_proxy_access" => $user_ip['is_proxy']
					];
					$params_update_master_data = [
						'table' => 'asset.master_data_proses',
						'data' => [
							'stereotype' => 'VERIVALI-KORKAB-REJECTED',
							'audit_trails' => json_encode( $audit_trails ),
							'lastupdate_on' => $datetime,
						],
						'where' => [
							'proses_id' => $id
						],
					];
					save_data( $params_update_master_data);
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, stereotype, row_status'
					];
					$get_data = get_data( $params_get )->row();
					$params_insert_master_data_log = [
						'data_log_master_data_id' => $get_data->proses_id,
						'data_log_status' => 'sukses',
						'data_log_description' => 'Data proses id ' . $get_data->proses_id . ' diubah status menjadi VERIVALI-KORKAB-REJECTED',
						'data_log_stereotype' => $get_data->stereotype,
						'data_log_row_status' => $get_data->row_status,
						'data_log_lastupdate_by' => $this->user_info['user_id'],
						'data_log_lastupdate_on' => date( "Y-m-d H:i:s"),
					];
					save_data( 'asset.master_data_log', $params_insert_master_data_log );

					$success++;
				}

				$arr_output['message'] = $success .' data berhasil reject ke status 12a.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode( $arr_output );
	}

	function form_cari() {
		$user_location = $this->get_user_location();
		$jml_negara = count( explode( ',', $user_location['country_id'] ) );
		$jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
		$jml_kota = count( explode( ',', $user_location['regency_id'] ) );
		$jml_kecamatan = count( explode( ',', $user_location['district_id'] ) );
		$jml_kelurahan = count( explode( ',', $user_location['village_id'] ) );

		$option_propinsi = '<option value="0">Pilih Provinsi</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
		$option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
		$option_hasil_verivali = '<option value="0">Semua Hasil Verivali</option>';

		$where_propinsi = [];
		$where_propinsi['parent_id'] = '100000';
		$where_propinsi['level'] = '2';

		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['location_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'dbo.ref_locations',
			'select' => 'location_id, full_name',
			'where' => $where_propinsi,
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
			if ( $jml_propinsi == '1' && ! empty( $user_location['province_id'] ) ) {
				$option_propinsi = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
			} else {
				$option_propinsi .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
			}
		}


		if ( $jml_propinsi == '1' ) {
			$where_kota = [];
			if ( ! empty( $user_location['regency_id'] ) ) {
				if ( $jml_kota > '0' ) $where_kota['location_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;
			} else {
				$where_kota['parent_id'] = $user_location['province_id'];
			}
			$params_kota = [
				'table' => 'dbo.ref_locations',
				'select' => 'location_id, full_name',
				'where' => $where_kota,
			];
			$query_kota = get_data( $params_kota );
			foreach ( $query_kota->result() as $key => $value ) {
				if ( $jml_kota == '1' && ! empty( $user_location['regency_id'] ) ) {
					$option_kota = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
				} else {
					$option_kota .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
				}
			}
		}

		if ( $jml_kota == '1' ) {
			$where_kecamatan = [];
			if ( ! empty( $user_location['district_id'] ) ) {
				if ( $jml_kecamatan > '0' ) $where_kecamatan['location_id ' . ( ( $jml_kecamatan >= '2' ) ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}" )] = null;
			} else {
				$where_kecamatan['parent_id'] = $user_location['regency_id'];
			}
			$params_kecamatan = [
				'table' => 'dbo.ref_locations',
				'select' => 'location_id, full_name',
				'where' => $where_kecamatan,
			];
			$query_kecamatan = get_data( $params_kecamatan );
			foreach ( $query_kecamatan->result() as $key => $value ) {
				if ( $jml_kecamatan == '1' && ! empty( $user_location['district_id'] ) ) {
					$option_kecamatan = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
				} else {
					$option_kecamatan .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
				}
			}
		}

		if (  $jml_kecamatan == '1' ) {
			$where_kelurahan = [];
			if ( ! empty( $user_location['village_id'] ) ) {
				if ( $jml_kelurahan > '0' ) $where_kelurahan['location_id ' . ( ( $jml_kelurahan >= '2' ) ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}" )] = null;
			} else {
				$where_kelurahan['parent_id'] = $user_location['district_id'];
			}
			$params_kelurahan = [
				'table' => 'dbo.ref_locations',
				'select' => 'location_id, full_name',
				'where' => $where_kelurahan,
			];
			$query_kelurahan = get_data( $params_kelurahan );
			foreach ( $query_kelurahan->result() as $key => $value ) {
				if ( $jml_kelurahan == '1' && ! empty( $user_location['village_id'] ) ) {
					$option_kelurahan = '<option value="' . $value->location_id . '" selected>' . $value->full_name . '</option>';
				} else {
					$option_kelurahan .= '<option value="' . $value->location_id . '">' . $value->full_name . '</option>';
				}
			}
		}
		$arr_hasil_verivali = [
			'1' => 'Selesai Dicacah',
			'2' => 'Ruta Tidak Ditemukan',
			'3' => 'Ruta Pindah / Bangunan Tidak Ada',
			'4' => 'Bagian Dari Ruta Di Dokumen',
			'5' => 'Responden Menolak',
			'6' => 'Data Ganda',
		];
		foreach ( $arr_hasil_verivali as $kode => $verivali) {
			$option_hasil_verivali .= '<option value="' . $kode . '" >' . $verivali . '</option>';
		}

		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
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
					<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kelurahan == '1' ) && ( ! empty( $user_location['village_id'] ) ) ) ? 'disabled ' : '' ) . '>
						' . $option_kelurahan . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-status" name="status" class="js-example-basic-single form-control">
						<option value="">Semua Status</option>
						<option value="VERIVALI-SUBMITTED">11. SELESAI VERIVALI Rumah Tangga</option>
						<option value="VERIVALI-SUPERVISOR-APPROVED">12. Data APPROVED PENGAWAS</option>
						<option value="VERIVALI-KORKAB-REJECTED">12a. Data REJECTED KORKAB</option>
						<option value="VERIVALI-KORKAB-APPROVED">13. Data APPROVED KORKAB</option>
						<option value="VERIVALI-KORWIL-REJECTED">13a. Data REJECTED QC Pusat</option>
						<option value="VERIVALI-PENDING-QC-PUSAT">13b. Proses QC Pusat</option>
						<option value="VERIVALI-FINAL">14. Data APPROVED KORWIL</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-jenis" name="jenis" class="js-example-basic-single form-control">
						<option value="">Semua Jenis</option>
						<option value="COPY">Prelist Awal</option>
						<option value="NEW">Usulan Baru</option>
					</select>
				</div>
				<div class="form-group col-md-3">
						<select id="select-hasil-verivali" name="hasil_verivali" class="js-example-basic-single form-control">
							' . $option_hasil_verivali . '
						</select>
					</div>
				<div class="form-group col-md-3">
					<select id="select-foto" name="jml_foto" class="js-example-basic-single form-control">
						<option value="">Semua Jumlah Foto</option>
						<option value="ZERO">Foto Belum Ada = 0</option>
						<option value="KURANG">Kurang Dari &lt; 9</option>
						<option value="LEBIH">Sembilan dan Lebih &gt; 9</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-nik" name="status_nik" class="js-example-basic-single form-control">
						<option value="">Semua Status NIK &amp; KK KRT</option>
						<option value="VALID">NIK &amp; KK KRT Lengkap</option>
						<option value="INVALID">NIK &amp; KK KRT Tidak Lengkap</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
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
		$params = [
			'table' => 'ref_locations',
			'where' => [
				'parent_id' => $_GET['location_id'],
				'level' => $_GET['level']
			],
			'select' => 'location_id, full_name'
		];
		$query = get_data( $params );
		$data = [];
		foreach  ( $query->result() as $rows ) {
			$data[$rows->location_id] = $rows->full_name;
		}
		echo json_encode( $data );
	}

}
