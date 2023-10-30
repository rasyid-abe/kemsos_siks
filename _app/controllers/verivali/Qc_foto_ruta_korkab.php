<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// show status 14
class Qc_foto_ruta_korkab extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/qc_foto_ruta_korkab/' );
		$this->load->model('auth_model');
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
				{ name:'foto_ktp', display:'Foto KTP', width:120, sortable:false, align:'center', datasuorce: false},
				{ name:'foto_kk', display:'Foto KK', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_responden', display:'Foto Responden', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_rumah', display:'Foto Rumah',  width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_atap', display:'Foto Atap', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_lantai', display:'Foto Lantai', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_dinding', display:'Foto Dinding', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_dapur', display:'Foto Dapur', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'foto_kloset', display:'Foto Kloset', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:80, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Approve', name:'approve', bclass:'publish', onpress:act_selected12, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Reject ke Status 12a', name:'reject12a', bclass:'unpublish', onpress:act_selected12, hidden: true, urlaction: '" . $this->dir . "act_show' },
				{ separator: true },
				{ display:'Copy Id Prelist', name:'copy', bclass:'copy', onpress:copy_id, urlaction: '" . $this->dir . "copy_id'},
				{ separator: true },
				{ display:'Is In Prelist', name:'paste', bclass:'paste', onpress:paste_id, urlaction: '" . $this->dir . "paste_id'},
				{ separator: true },
				{ display:'Not In Prelist', name:'not_in', bclass:'not_in', onpress:not_in_id, urlaction: '" . $this->dir . "not_in_id'},
				{ separator: true },
			",
			'filters' => "
				{ display:'ID Prelist', name:'id_prelist', type:'text', isdefault: true },
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
		$this->template->content( "general/Table_grid_view_qc_foto_korkab_verval", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data(){
		$user_id = $this->user_info['user_id'];
		$location_user = $this->auth_model->ambil_location_get($user_id);
		$input = $this->input->post();
		$where = [];
		$where_in = [];
		$is_in = '';
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ($field == 'id_prelist') {
                    if ( $value > '0' )
                    $pre_arr = explode("\n", $value);
                    $val_prelist = [];
                    for ($i=0; $i < count($pre_arr); $i++) {
                        $val_prelist[] = $pre_arr[$i];
                    }
                    $where_in['md.' . $field] = $val_prelist;
                } else if ( $field == 'stereotype' || $field == 'row_status' ) {
					if ( $value > '0' ) $where['md.' . $field] = $value;
					else $where["md.stereotype IN ('VERIVALI-SUBMITTED',
								'VERIVALI-SUPERVISOR-APPROVED',
								'VERIVALI-KORKAB-REJECTED',
								'VERIVALI-KORKAB-APPROVED',
								'VERIVALI-KORWIL-REJECTED',
								'VERIVALI-PENDING-QC-PUSAT',
								'VERIVALI-FINAL') "] = null;
				} else if ( $field == 'is_in'){
					if ( $value > '-1' ) $is_in = $value;
				} else {
					if ( $value > '0' ) $where['l.' . $field] = $value;
				}
			}
			if ( ( in_array( 'root', $this->user_info['user_group'] ) ? FALSE :  TRUE) ) {
				$where['l.location_id' ." IN ({$location_user['village_codes']})"]  = null;
			}
		} else {
			if ( ( ! empty( $this->user_info['user_location'] ) ) && ( in_array( 'root', $this->user_info['user_group'] ) ? FALSE :  TRUE ) ){
				$where['l.location_id' ." IN ({$location_user['village_codes']})"]  = null;
			}elseif ( ( ! empty( $this->user_info['user_location'] ) ) && ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE :  FALSE ) ){
				$user_location = $this->get_user_location();
				$jml_negara = ( ( ! empty( $user_location['country_id'] ) ) ? count( explode( ',', $user_location['country_id'] ) ) : '0' );
				if ( ! empty( $jml_negara) ) $where['l.country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null;

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

		$par = $input['querys'];
		$where_querys = [];
		if ( !empty($par) ) {
			$params = json_decode( $par, true );
			foreach ($params as $key => $value) {
				$where_querys[$value['filter_field']] = $value['filter_value'];
			}
		}
		$sql_where = '';

		foreach ($where_querys as $key => $value) {
			$sql_where .= $key." LIKE '%" .$value. "%' AND ";
		}

		foreach ($where as $key => $value) {
			if ($value == '') {
				$sql_where .= $key.' AND ';
			} else if ($key == 'md.stereotype' || $key == 'md.row_status') {
				$sql_where .= $key." = '" .$value. "' AND ";
			} else {
				$sql_where .= $key.' = ' .$value .' AND ';
			}
		}

		$in_opt = $is_in > 0 ? 'IN' : 'NOT IN';
		$sql_where_in = '';
		if ( isset($where_in['md.id_prelist'])) {
			$data_in = "'" . implode("','", $where_in['md.id_prelist']) . "'";
			$in_where = preg_replace('/\s+/', '', $data_in);
			$sql_where_in = 'AND md.id_prelist '.$in_opt.' (' .$in_where. ')';
		}

		$sql_query = "
			SELECT
				md.*,
				l.province_name,
				l.regency_name,
				l.district_name,
				l.village_name,
				r.icon,
				r.code
			FROM asset.view_all_proses_data_new md
			LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
			LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
			WHERE $sql_where 1=1 $sql_where_in
			ORDER BY md.lastupdate_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
			SELECT COUNT
				( id_prelist ) jumlah
			FROM asset.view_all_proses_data_new md
			LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
			LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
			WHERE $sql_where 1=1 $sql_where_in
		";
		$query = data_query( $sql_query );
		$query_count = data_query( $sql_count );

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
			$foto_rumah = '<a href="'.$url.substr($row->f_rumah, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_rumah, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_atap = '<a href="'.$url.substr($row->f_atap, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_atap, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_lantai = '<a href="'.$url.substr($row->f_lantai, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_lantai, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_dinding = '<a href="'.$url.substr($row->f_dinding, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_dinding, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_dapur = '<a href="'.$url.substr($row->f_dapur, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_dapur, 2).'" class="img-fluid m-b-10" alt="">
						</a>';
			$foto_kloset = '<a href="'.$url.substr($row->f_jamban, 2).'" data-toggle="lightbox" target="_blank" data-gallery="example-gallery">
						<img src="'.$url.substr($row->f_jamban, 2).'" class="img-fluid m-b-10" alt="">
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
					<br>
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
					<br>
					Durasi Interview: ' . $row->interview_duration . ' <br>
				</span>';
			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'status' => '<img src="' . base_url('assets/style/icon-status/') . $row->icon . '">',
					'status_code' => $row->code,
					'jenis' => '<img src="' . base_url() . ( ( $row->row_status == 'COPY' ) ? 'assets/style/package-blue.png' : 'assets/style/package-green.png' ) . '" ' .  ( ( $row->row_status == 'COPY' ) ? 'title="Prelist Awal" alt="Prelist Awal"' : 'title="Usulan Baru" alt="Usulan Baru"') . '>',
					'id_prelist' => $row->id_prelist,
					'informasi_data' => $informasi_data,
					'foto_ktp' => $foto_ktp,
					'foto_kk' => $foto_kk,
					'foto_responden' => $foto_responden,
					'foto_rumah' => $foto_rumah,
					'foto_atap' => $foto_atap,
					'foto_lantai' => $foto_lantai,
					'foto_dinding' => $foto_dinding,
					'foto_dapur' => $foto_dapur,
					'foto_kloset' => $foto_kloset,
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
						"act" => "COPY",
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

				$arr_output['message'] = $success .' data berhasil dipublish.';
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
						"act" => "COPY",
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

				$arr_output['message'] = $success .' data berhasil reject ke status 13a.';
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

		$where_propinsi = [];
		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'asset.vw_administration_regions',
			'select' => 'DISTINCT province_id, propinsi',
			'where' => $where_propinsi,
			'order_by' => 'propinsi',
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
				$option_propinsi .= '<option value="' . $value->province_id . '">' . $value->propinsi . '</option>';
		}


		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
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
					<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" >
						' . $option_kelurahan . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-status" name="status" class="js-example-basic-single form-control">
						<option value="">Semua Status</option>
						<option value="VERIVALI-SUPERVISOR-APPROVED">12.Data APPROVED PENGAWAS</option>
						<option value="VERIVALI-KORWIL-REJECTED">13a.Data REJECTED QC Pusat</option>
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
					<button type="button" id="cari" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Refresh</button>
				</div>
			</div>
		';
		return $form_cari;
	}

	function get_user_location() {
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '';
		$province_id = '';
		$regency_id = '';
		$district_id = '';
		$village_id = '';
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
				$province_id = $province_id.''.$query->row( 'province_id' ) . ( ( !empty($query->row( 'province_id' )) && $no < $count ) ? ',' : '' );
				$regency_id = $regency_id.''.$query->row( 'regency_id' ) . ( ( !empty($query->row( 'regency_id' )) && $no < $count ) ? ',' : '' );
				$district_id = $district_id.''.$query->row( 'district_id' ) . ( ( !empty($query->row( 'district_id' )) && $no < $count ) ? ',' : '' );
				$village_id = $village_id.''.$query->row( 'village_id' ) . ( ( !empty($query->row( 'village_id' )) && $no < $count ) ? ',' : '' );
				$no++;
			}
		}
		$res_loc = [
			'country_id' => $country_id,
			'province_id' => $this->merge_location($province_id),
			'regency_id' => $this->merge_location($regency_id),
			'district_id' =>  $this->merge_location($district_id),
			'village_id' =>  $this->merge_location($village_id),
		];
		return($res_loc);

	}

	function merge_location($location_id)
	{
		$tes =explode(',', $location_id);
		sort($tes);
		$str = implode(',',array_unique($tes));
		$str=ltrim($str,',');
		return $str;
	}

	function get_show_location(){
		$user_location = $this->get_user_location();
		$regency_id= $user_location['regency_id'];
		$district_id= $user_location['district_id'];
		$village_id= $user_location['village_id'];
		$id_location=$_GET['location_id'];
		//die;
		$level=$_GET['level'];
		if($level==3)
		{	$parent_id='province_id';
			$parent = "province_id=$id_location";
			if( in_array( 'root', $this->user_info['user_group'] ) ? FALSE : TRUE )
			{
				if(empty($regency_id))
				{
					$child_id ="1=1";
				}
				else
				{
					$child = "regency_id in ($regency_id)";
					if($this->cek_location($parent,$child)>0)
						$child_id ="regency_id in ($regency_id)";
					else
						$child_id ="regency_id not in ($regency_id)";
				}
			}
			else
			{
				$child_id ="1=1";
			}
		}elseif($level==4)
		{	$parent_id='regency_id';
			$parent = "regency_id=$id_location";
			if( in_array( 'root', $this->user_info['user_group'] ) ? FALSE : TRUE )
			{
				if(empty($district_id))
				{
					$child_id ="1=1";
				}
				else
				{
					$child = "district_id in ($district_id)";
					if($this->cek_location($parent,$child)>0)
						$child_id ="district_id in ($district_id)";
					else
						$child_id ="district_id not in ($district_id)";
				}
			}
			else
			{
				$child_id ="1=1";
			}
		}if($level==5)
		{	$parent_id='district_id';
			$parent = "district_id=$id_location";
			if( in_array( 'root', $this->user_info['user_group'] ) ? FALSE : TRUE )
			{
				if(empty($village_id))
				{
					$child_id ="1=1";
				}
				else
				{
					$child = "village_id in ($village_id)";
					if($this->cek_location($parent,$child)>0)
						$child_id ="village_id in ($village_id)";
					else
						$child_id ="village_id not in ($village_id)";
				}
			}
			else
			{
				$child_id ="1=1";
			}
		}

		$params = [
			'table' => 'asset.vw_administration_regions',
			'where' => [
				$parent_id => $_GET['location_id'],
				$child_id => null
			],
			'select' => 'DISTINCT regency_id, district_id, village_id, kabupaten, kecamatan, kelurahan'
		];
		$query = get_data( $params );
		$data = [];
		foreach  ( $query->result() as $rows ) {
			if($level==3)
			{
				$location_id=$rows->regency_id;
				$name=$rows->kabupaten;
			}elseif($level==4)
			{	$location_id=$rows->district_id;
				$name=$rows->kecamatan;
			}if($level==5)
			{	$location_id=$rows->village_id;
				$name=$rows->kelurahan;
			}
			$data[$location_id] = $name;
		}
		echo json_encode( $data );
	}

	function cek_location($parent, $child){
		$params = [
			'table' => 'asset.vw_administration_regions',
			'where' => [
				$parent => null,
				$child => null
			],
			'select' => 'DISTINCT regency_id, district_id, village_id, kabupaten, kecamatan, kelurahan'
		];
		$query = get_data( $params );
		return $query->num_rows();
	}

}
