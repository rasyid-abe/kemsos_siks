<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#show status 0
class Unpublished extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/unpublished/' );
		$this->load->model('auth_model');
		$this->data_nokk = [];
		$this->data_tanggungan = [];
		$this->data_usaha = [];
		$this->data_default = [];
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
		$data['cari'] = $this->form_cari();
        $data['paste_url'] = $this->dir;
		$data['grid'] = [
			'col_id' => 'asset_id',
			'sort' => 'asc',
			'columns' => "
				{ name:'status', display:'Status', width:40, sortable:false, align:'center', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_krt', display:'Nama KRT', width:110, sortable:true, align:'left', datasuorce: false},
				{ name:'nomor_nik', display:'NIK', width:120, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten',  width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:130, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:50, sortable:true, align:'center', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Publish', name:'publish', bclass:'publish', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				{ separator: true },
                { display:'Copy Id Prelist', name:'copy', bclass:'copy', onpress:copy_id, urlaction: '" . $this->dir . "copy_id'},
				{ separator: true },
                { display:'Is In Prelist', name:'paste', bclass:'paste', onpress:paste_id, urlaction: '" . $this->dir . "paste_id'},
				{ separator: true },
                { display:'Not In Prelist', name:'not_in', bclass:'not_in', onpress:not_in_id, urlaction: '" . $this->dir . "not_in_id'},
				{ separator: true },
			",
			'filters' => "
				{ display:'ID Prelist', name:'md.id_prelist', type:'text', isdefault: true },
				{ display:'Nama KRT', name:'md.nama_krt', type:'text' },
				{ display:'NIK', name:'md.nomor_nik', type:'text' },
				{ display:'Alamat', name:'md.alamat', type:'text' },
				{ display:'Last Update', name:'md.last_update_data', type:'date' },
			",
		];
		$data['grid']['title'] = 'Publish Data Prelist SIKS-NG';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['extra_script'] = '
			<script>
				$(document).ready( function(){
					$("#select-propinsi").on( "change", function(){
						$("#modalLoader").modal();
						let params = {
							"location_id": $(this).val(),
							"level": "3",
							"title": "Kabupaten",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kabupaten").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
							$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );							 
							$( "#select-kabupaten").select2();
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();

						} else {
							
							$( "#select-kabupaten").html( "<option value=\'0\'>Loading... </option>" );  
							$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );							 
							$( "#select-kabupaten").select2();
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();
							get_location(params);
							
						}
						$( "#select-kabupaten").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
						$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
						$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						$("#modalLoader").modal();
						let params = {
							"location_id": $(this).val(),
							"select-propinsi": $("#select-propinsi").val(),
							"level": "4",
							"title": "Kecamatan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );							 
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();

						} else {
							$( "#select-kecamatan").html( "<option value=\'0\'>Loading... </option>" );   
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
							$( "#select-kecamatan").select2();
							$( "#select-kelurahan").select2();
							get_location(params);
						}
						$( "#select-kecamatan").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
						$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
					});

					$("#select-kecamatan").on( "change", function(){
						$("#modalLoader").modal();
						let params = {
							"location_id": $(this).val(),
							"select-propinsi": $("#select-propinsi").val(),
							"select-kabupaten": $("#select-kabupaten").val(),
							"level": "5",
							"title": "Kelurahan"
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
							$( "#select-kelurahan").select2();
						} else {
							$( "#select-kelurahan").html( "<option value=\'0\'>Loading... </option>" );     
							$( "#select-kelurahan").select2();
							get_location(params);
						}
						$( "#select-kelurahan").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );

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
								},
							],
						}).flexReload();
						$("#loader").modal("hide");
					});

					var get_location = ( params ) => {
						$("#modalLoader").modal("show");
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
								$( "#select-" + params.title.toLowerCase() ).select2();
								
								$("#select-" + params.title.toLowerCase() ).html( option );
								$("#modalLoader").modal("hide");
							},
						});
					};
				});
			</script>
		';
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_data", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
		$user_id = $this->user_info['user_id'];
		$location_user = $this->user_info['user_location'];
        $input = $this->input->post();

		$where = [];
        $where_in = [];
        $is_in = '';
		$where['md.stereotype'] = 'UNPUBLISHED';
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
                if ( $field == 'id_prelist' ) {
                    if ( $value > '0' )
                    $pre_arr = explode("\n", $value);
                    $val_prelist = [];
                    for ( $i = 0; $i < count( $pre_arr ); $i++ ) {
                        $val_prelist[] = $pre_arr[$i];
                    }
                    $where_in['md.' . $field] = $val_prelist;
                } else if ( $field == 'is_in' ){
                    if ( $value > '-1' ) $is_in = $value;
                } else if ( $value > '0' ) {
                    $where['l.' . $field] = $value;
                }
			}
		} else {
			if ( in_array( 'root', $this->user_info['user_group'] ) ) {
				$where['l.country_id = 100000']  = null;
			} else {
				if ( ( ! empty( $this->user_info['user_location'] ) ) ) {
					$country = $province = $regency = $district = $village = '';
					foreach ( $location_user as $key => $loc ) {
						$row_loc = get_data([
							'table' => 'dbo.ref_locations',
							'select' => 'level, country_id, bps_province_code, bps_regency_code, bps_district_code, bps_village_code',
							'where' => [
								'location_id' => $loc
							]
						])->row();
						if ( $row_loc->level == '1' ) $country .= ( ( $country == '' ) ? "{$row_loc->country_id}" : ", $row_loc->country_id" );
						if ( $row_loc->level == '2' ) $province .= ( ( $province == '' ) ? "$row_loc->bps_province_code" : ", $row_loc->bps_province_code" );
						if ( $row_loc->level == '3' ) $regency .= ( ( $regency == '' ) ? "$row_loc->bps_regency_code" : ", $row_loc->bps_regency_code" );
						if ( $row_loc->level == '4' ) $district .= ( ( $district == '' ) ? "$row_loc->bps_distric_code" : ", $row_loc->bps_distric_code" );
						if ( $row_loc->level == '5' ) $village .= ( ( $village == '' ) ? "$row_loc->bps_village_code" : ", $row_loc->bps_village_code" );
					}
					if ( ! empty( $country ) ) $where['l.country_id ' . ( ( count( explode( ',', $country ) ) >= '2' ) ? "IN ({$country}) " : "= {$country}" )] = null;
					if ( ! empty( $province ) ) $where['md.kode_propinsi ' . ( ( count( explode( ',', $province ) ) >= '2' ) ? "IN ({$province}) " : "= {$province}" )] = null;
					if ( ! empty( $regency ) ) $where['md.kode_kabupaten ' . ( ( count( explode( ',', $regency ) ) >= '2' ) ? "IN ({$regency}) " : "= {$regency}" )] = null;
					if ( ! empty( $district ) ) $where['md.kode_kecamatan ' . ( ( count( explode( ',', $district ) ) >= '2' ) ? "IN ({$regency}) " : "= {$regency}" )] = null;
					if ( ! empty( $village ) ) $where['md.kode_desa ' . ( ( count( explode( ',', $village ) ) >= '2' ) ? "IN ({$village}) " : "= {$village}" )] = null;
				}	
			}
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
			} else if ($key == 'md.stereotype') {
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

		$sort = $input['sortorder'];
		$offset = ( ( $input['page'] - 1 ) * $input['rp'] );		
		$rp = $input['rp'];
		$list = 'proses_id';
		$stereotype = $where["md.stereotype"];

		if ( !isset( $where["l.province_id"] )) 	
		{
			// $sql_query = "exec [dbo].[stp_stereotype_unpublished] 1,0,0,0,0,'$sort',$offset,$rp";
			$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0,0,'''$stereotype''','$sort',$offset,$rp";
			$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 1,'" . $this->user_info['text'] . "',$list,0,0,0,0,'''$stereotype'''";
		}
		else
		{
			if ( isset( $where["l.province_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_unpublished] 2,$province,0,0,0,'$sort',$offset,$rp";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 2,'" . $this->user_info['text'] . "',$province,0,0,0,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 2,'" . $this->user_info['text'] . "',$list,$province,0,0,0,'''$stereotype'''";
			}
			if ( isset( $where["l.regency_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				$regency = (int)$where["l.regency_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_unpublished] 3,$province,$regency,0,0,'$sort',$offset,$rp";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 3,'" . $this->user_info['text'] . "',$province,$regency,0,0,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 3,'" . $this->user_info['text'] . "',$list,$province,$regency,0,0,'''$stereotype'''";
			}
			if ( isset( $where["l.district_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				$regency = (int)$where["l.regency_id"];
				$district = (int)$where["l.district_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_unpublished] 4,$province,$regency,$district,0,'$sort',$offset,$rp";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 4,'" . $this->user_info['text'] . "',$province,$regency,$district,0,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 4,'" . $this->user_info['text'] . "',$list,$province,$regency,$district,0,'''$stereotype'''";
			}
			if ( isset( $where["l.village_id"] )) 
			{
				$province = (int)$where["l.province_id"];
				$regency = (int)$where["l.regency_id"];
				$district = (int)$where["l.district_id"];
				$village = (int)$where["l.village_id"];
				// $sql_query = "exec [dbo].[stp_stereotype_unpublished] 5,$province,$regency,$district,$village,'$sort',$offset,$rp";
				$sql_query = "exec [dbo].[stp_stereotype_pub_unpub_new_v1] 5,'" . $this->user_info['text'] . "',$province,$regency,$district,$village,'''$stereotype''','$sort',$offset,$rp";
				$sql_count = "exec [dbo].[stp_count_pub_unpub_new_v1] 5,'" . $this->user_info['text'] . "',$list,$province,$regency,$district,$village,'''$stereotype'''";
			}

		}

		$query = data_query( $sql_query );
        $query_count = data_query( $sql_count );

		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$status = '<img src="' . base_url('assets/style/icon-status') . '/' . $row->icon . '">';
			$detail = '<button class="btn-edit" act="' . base_url( "verivali/detail_data/get_form_detail/" . enc( ['proses_id' => $row->proses_id, 'stereotype' => $row->stereotype] ) ) . '"><i class="fa fa-search"></i></button>';
			$row_data = [
				'id' => $row->proses_id,
				'cell' => [
					'status' => $status,
					'id_prelist' => $row->id_prelist,
					'nama_krt' => $row->nama_krt,
					'nomor_nik' => $row->nomor_nik,
					'alamat' => $row->alamat,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
					'last_update_data' => $row->lastupdate_on,
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

	function act_show() {
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();

		// publish
		if ( isset( $in['publish'] ) && $in['publish'] ) {
			$arr_id = json_decode( $in['item'] );
		
			if ( is_array( $arr_id ) ) {
				$success = $failed = 0;
				$datetime = date( "Y-m-d H:i:s");
				
				$insert_master_data_proses = [];
				$insert_master_data_log = [];
				$update_master_data = [];

				foreach ( $arr_id as $id ) {
					$get_data_cek = get_data( [
						'table' => 'asset.master_data_proses',
						'where' => [
							'parent_id' => $id
						],
						'select' => 'proses_id'
					] )->num_rows();

					// insert into master_data_log
					$get_data = get_data( [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
						'select' => 'proses_id, id_prelist, fiscal_year, no_pbdt_kemsos, vector1, vector2, vector3, vector4, kode_gabungan, location_id, kode_propinsi, kode_kabupaten, kode_kecamatan, kode_desa, alamat, ada_pkh, ada_pbdt, ada_kks_2016, ada_kks_2017, ada_pbi, ada_dapodik, nomor_nik, no_peserta_pkh, no_peserta_kks_2016, no_peserta_pbi, peserta_kip, nama_sls, nama_krt, jumlah_art, jumlah_keluarga, status_bangunan, status_lahan, luas_lantai, lantai, dinding, kondisi_dinding, atap, kondisi_atap, jumlah_kamar, sumber_airminum, nomor_meter_air, cara_peroleh_airminum, sumber_penerangan, daya, nomor_pln, bb_masak, nomor_gas, fasbab, kloset, buang_tinja, ada_tabung_gas, ada_lemari_es, ada_ac, ada_pemanas, ada_telepon, ada_tv, ada_emas, ada_laptop, ada_sepeda, ada_motor, ada_mobil, ada_perahu, ada_motor_tempel, ada_perahu_motor, ada_kapal, aset_tak_bergerak, luas_atb, rumah_lain, jumlah_sapi, jumlah_kerbau, jumlah_kuda, jumlah_babi, jumlah_kambing, status_art_usaha, status_kks, status_kip, status_kis, status_bpjs_mandiri, status_jamsostek, status_asuransi, status_pkh, status_rastra, status_kur, status_keberadaan_rt, status_pekerjaan, apakah_mampu, approval_note, hasil_verivali, tanggal_verivali, ada_art_bekerja, jenis_kelamin_krt, nama_pasangan_krt, status_rumahtangga, jenis_pelanggan_gas, jenis_pelanggan_airminum, jenis_pelanggan_airminum_lainnya, interview_duration_ms, alasan_tidak_ditemukan, data_idbdt_double_dengan, petugas_verivali, percentile, init_data, last_update_data, foto_rumah, foto_ktp, foto_kk, foto_kk1, foto_kk2, foto_kk3, foto_kk4, foto_kk5, foto_kk6, lat, long, psnoka_bpjs, id_asal, musdes_server_submit_date, musdes_mobile_saved_timestamp, musdes_mobile_opened_timestamp, verivali_mobile_saved_timestamp, verivali_mobile_opened_timestamp, musdes_mobile_submitted_timestamp, musdes_mobile_first_open_timestamp, verivali_mobile_submitted_timestamp, verivali_mobile_first_open_timestamp, status, created_by, created_on, lastupdate_by, ba_baseline, ba_verify, ada_art_cacat, nomor_urut_rt, jenis_pelanggan_gas_lainnya'
					] )->row();
					
					$get_data->stereotype = 'PROVINCE-PUBLISHED';
					$get_data->parent_id = $get_data->proses_id;
					$get_data->row_status = 'COPY';
					$get_data->lastupdate_on = $datetime;
					$user_id = $this->user_info['user_id'];
					
					$this->db->query("exec [update_master_data_log] 1,'$user_id','$datetime','Publish Data proses_id $id','','','$id','$get_data->row_status','sukses','$get_data->stereotype' ");		

					if ( $get_data_cek == '0' ) {
						$is_proxy = false;
						if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
							$ip_address = $_SERVER['HTTP_CLIENT_IP'];
						} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
							//whether ip is from proxy
							$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
							$is_proxy = true;
						} else {
							//whether ip is from remote address
							$ip_address = $_SERVER['REMOTE_ADDR'];
						}
						$get_data = get_data( [
							'table' => 'asset.master_data_proses',
							'where' => [
								'proses_id' => $id
							],
							'select' => 'proses_id, id_prelist, fiscal_year, no_pbdt_kemsos, vector1, vector2, vector3, vector4, kode_gabungan, location_id, kode_propinsi, kode_kabupaten, kode_kecamatan, kode_desa, alamat, ada_pkh, ada_pbdt, ada_kks_2016, ada_kks_2017, ada_pbi, ada_dapodik, nomor_nik, no_peserta_pkh, no_peserta_kks_2016, no_peserta_pbi, peserta_kip, nama_sls, nama_krt, jumlah_art, jumlah_keluarga, status_bangunan, status_lahan, luas_lantai, lantai, dinding, kondisi_dinding, atap, kondisi_atap, jumlah_kamar, sumber_airminum, nomor_meter_air, cara_peroleh_airminum, sumber_penerangan, daya, nomor_pln, bb_masak, nomor_gas, fasbab, kloset, buang_tinja, ada_tabung_gas, ada_lemari_es, ada_ac, ada_pemanas, ada_telepon, ada_tv, ada_emas, ada_laptop, ada_sepeda, ada_motor, ada_mobil, ada_perahu, ada_motor_tempel, ada_perahu_motor, ada_kapal, aset_tak_bergerak, luas_atb, rumah_lain, jumlah_sapi, jumlah_kerbau, jumlah_kuda, jumlah_babi, jumlah_kambing, status_art_usaha, status_kks, status_kip, status_kis, status_bpjs_mandiri, status_jamsostek, status_asuransi, status_pkh, status_rastra, status_kur, status_keberadaan_rt, status_pekerjaan, apakah_mampu, approval_note, hasil_verivali, tanggal_verivali, ada_art_bekerja, jenis_kelamin_krt, nama_pasangan_krt, status_rumahtangga, jenis_pelanggan_gas, jenis_pelanggan_airminum, jenis_pelanggan_airminum_lainnya, interview_duration_ms, alasan_tidak_ditemukan, data_idbdt_double_dengan, petugas_verivali, percentile, init_data, last_update_data, foto_rumah, foto_ktp, foto_kk, foto_kk1, foto_kk2, foto_kk3, foto_kk4, foto_kk5, foto_kk6, lat, long, psnoka_bpjs, id_asal, musdes_server_submit_date, musdes_mobile_saved_timestamp, musdes_mobile_opened_timestamp, verivali_mobile_saved_timestamp, verivali_mobile_opened_timestamp, musdes_mobile_submitted_timestamp, musdes_mobile_first_open_timestamp, verivali_mobile_submitted_timestamp, verivali_mobile_first_open_timestamp, status, created_by, created_on, lastupdate_by, ba_baseline, ba_verify, ada_art_cacat, nomor_urut_rt, jenis_pelanggan_gas_lainnya'
						] )->row();
						$get_data->stereotype = 'PROVINCE-PUBLISHED';
						$get_data->parent_id = $get_data->proses_id;
						$get_data->row_status = 'COPY';
						$get_data->lastupdate_on = $datetime;
						$get_data->audit_trails = json_encode(
							[
								"ip" => $ip_address,
								"on" => $datetime,
								"act" => "COPY",
								"user_id" => $this->user_info['user_id'],
								"username" => $this->user_info['user_username'],
								"column_data" => [
									"asset_id" => $id,
									"stereotype" => 'PROVINCE-PUBLISHED'
								],
								"is_proxy_access" => $is_proxy
							]
						);
						$insert_master_data_proses[] = $get_data;
						// save_data( 'asset.master_data_proses', $get_data);
						$insert_master_data_log[] = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Publish Data proses_id ' . $id,
							'data_log_stereotype' => $get_data->stereotype,
							'data_log_row_status' => $get_data->row_status,
							'data_log_created_by' => $this->user_info['user_id'],
							'data_log_created_on' => $datetime,
							'data_log_lastupdate_by' => null,
							'data_log_lastupdate_on' => null,
						];					

						// save_data( 'asset.master_data_log', $insert_master_data_log);

						$update_master_data[] = [
							'stereotype' => 'PROVINCE-PUBLISHED',
							'proses_id' => $id
						];
						$this->move_detail( $id );

						$failed++;
					} else {
						$success++;
					}
				}
				// $this->db->insert_batch( 'asset.master_data_proses2', $insert_master_data_proses );
				// debug($this->db->insert_batch( 'asset.master_data_proses', $insert_master_data_proses ));
				// $this->db->insert_batch( 'asset.master_data_log', $insert_master_data_log );
				// $this->db->update_batch( 'asset.master_data_proses', $update_master_data, 'proses_id' );
				// exec [update_master_data_log] 1,'0','2020-11-02 20:34:31','Publish Data proses_id 1730808','','','1730808','COPY','sukses','PROVINCE-PUBLISHED'
				// $this->db->query("exec [update_master_data_log] 1,$user_id,$datetime,'Publish Data proses_id $id,'','','" .implode(',',$arr_id). "',$get_data->row_status,'sukses',$get_data->stereotype");				

				// update master_data_proses
				$this->db->query("exec [update_master_data_proses] 1,'" .implode(',',$arr_id). "'");
				// $this->db->query("exec [update_master_data_log] 1,'$user_id','$datetime','Publish Data proses_id $id','',''," .implode('|',$arr_id). ",'$get_data->row_status','sukses','$get_data->stereotype' ");
				
				if ( ! empty( $this->data_nokk ) ) $this->db->insert_batch( 'asset.master_data_detail_proses_kk', $this->data_nokk );
				if ( ! empty( $this->data_tanggungan ) ) $this->db->insert_batch( 'asset.master_data_detail_proses_kk', $this->data_tanggungan );
				if ( ! empty( $this->data_usaha ) ) $this->db->insert_batch( 'asset.master_data_detail_proses_kk', $this->data_usaha );
				if ( ! empty( $this->data_default ) ) $this->db->insert_batch( 'asset.master_data_detail_proses', $this->data_default );
				$arr_output['message'] = '<span>' . $success . ' data berhasil dipublish !</span><br><span style="color:red;">' . $failed . ' data gagal dipublish !</span>';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}
		echo json_encode( $arr_output );
	}

	function move_detail( $id = null ) {
		$get_data = get_data( [
			'table' => 'asset.master_data_detail',
			'where' => [
				'proses_id' => $id
			]
		] )->result_array();

		foreach ( $get_data as $key => $value ) {
			if ( $value['stereotype'] == 'NOKK' ) {
				$this->data_nokk[] = [
					'proses_id' => $value['proses_id'],
					'parent_id' => $value['parent_id'],
					'index' => $value['index'],
					'fiscal_year' => $value['fiscal_year'],
					'nuk' => $value['nuk'],
					'nokk' => $value['no_kk'],
					'stereotype' => $value['stereotype'],
					'sort_order' => $value['sort_order'],
					'row_status' => $value['row_status'],
					'created_by' => $value['created_by'],
					'created_on' => $value['created_on'],
					'lastupdate_by' => $value['lastupdate_by'],
					'lastupdate_on' => $value['lastupdate_on'],
				];
			} else if ( $value['stereotype'] == 'ANAK-DALAM-TANGGUNGAN' ) {
				$this->data_tanggungan[] = [
					'proses_id' => $value['proses_id'],
					'parent_id' => $value['parent_id'],
					'index' => $value['index'],
					'fiscal_year' => $value['fiscal_year'],
					// 'art_nisn' => '',
					// 'art_sekolah_nik' => '',
					// 'art_nama_sekolah' => '',
					// 'nama_art_sekolah' => '',
					// 'art_sekolah_alamat' => '',
					'stereotype' => $value['stereotype'],
					'sort_order' => $value['sort_order'],
					'row_status' => $value['row_status'],
					'created_by' => $value['created_by'],
					'created_on' => $value['created_on'],
					'lastupdate_by' => $value['lastupdate_by'],
					'lastupdate_on' => $value['lastupdate_on'],
				];
			}  else if ( $value['stereotype'] == 'ART-USAHA' ) {
				$this->data_usaha[] = [
					'proses_id' => $value['proses_id'],
					'parent_id' => $value['parent_id'],
					'index' => $value['index'],
					'fiscal_year' => $value['fiscal_year'],
					// 'nama_art' => '',
					// 'no_urut_art' => '',
					// 'omset_usaha' => '',
					// 'lokasi_usaha' => '',
					// 'jumlah_pekerja' => '',
					'lapangan_usaha' => $value['lapangan_usaha'],
					// 'kode_lapangan_usaha' => '',
					'stereotype' => $value['stereotype'],
					'sort_order' => $value['sort_order'],
					'row_status' => $value['row_status'],
					'created_by' => $value['created_by'],
					'created_on' => $value['created_on'],
					'lastupdate_by' => $value['lastupdate_by'],
					'lastupdate_on' => $value['lastupdate_on'],
				];
			} else if ( $value['stereotype'] == 'ART' ) {
				unset( $value['id'] );
				$this->data_default[] = $value;
			}
		}
	}

	function act_save() {
		$input = $this->input->post();
		$sql = "
			SELECT max(menu_order) max_sort
			FROM sys_menu
			WHERE menu_parent_id = '" . $input['parent_menu'] . "'
		";
		$query = data_query( $sql );
		$last_sort = $query->row( 'max_sort' );
		$data_save = [
			'menu_parent_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_link' => $input['menu_link'],
			'menu_description' => $input['menu_description'],
			'menu_class_icon' => $input['menu_class_icon'],
			'menu_activity' => json_encode( array_merge( ['show'], $input['menu_action'] ) ),
			'menu_order' => $last_sort + 1,
			'menu_is_active' => '1',
		];
		$menu_id = save_data( 'sys_menu', $data_save );
		if ( $menu_id ){
			$result = [
				'status' => 200,
				'msg' => 'Data Berhasil Disimpan !',
			];
		} else {
			$result = [
				'status' => 500,
				'msg' => 'Data Gagal Disimpan !',
			];
		}
		echo json_encode( $result );
	}

	function act_edit() {
		$input = $this->input->post();
		$arr_input_menu_action = ( ( isset( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'menu_parent_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_link' => $input['menu_link'],
			'menu_description' => $input['menu_description'],
			'menu_class_icon' => $input['menu_class_icon'],
			'menu_activity' => json_encode( array_merge( ['show'], $arr_input_menu_action ) ),
		];
		$menu_id = save_data( 'sys_menu', $data_save, [ 'menu_id' => $input['menu_id'] ] );
		if ( $menu_id ){
			$result = [
				'status' => 200,
				'msg' => 'Data Berhasil Disimpan !',
			];
		} else {
			$result = [
				'status' => 500,
				'msg' => 'Data Gagal Disimpan !',
			];
		}
		echo json_encode( $result );
	}

	function form_cari() {
		
		$option_propinsi = '<option value="0">Pilih Provinsi</option>';
		$option_kota = '<option value="0">Pilih Kota/Kabupaten</option>';
		$option_kelurahan = '<option value="0">Pilih Kelurahan</option>';
		$option_kecamatan = '<option value="0">Pilih Kecamatan</option>';
		
		$params_propinsi = "exec [dbo].[get_level_new_v1] 1,'" . $this->user_info['text'] . "',0,0,0";
		$query_propinsi = $this->db->query($params_propinsi);

		foreach ( $query_propinsi->result() as $key => $value ) {
			$option_propinsi .= '<option value="' . $value->province_id . '">' . $value->propinsi . '</option>';
		}

		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
					<div class="form-group col-md-3">
						<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" type="text" >
							' . $option_propinsi . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control"  type="text" >
							' . $option_kota . '
						</select>
					</div>
					<div class="form-group col-md-2">
						<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control"  type="text">
							' . $option_kecamatan . '
						</select>
					</div>
					<div class="form-group col-md-2">
						<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control"  type="text">
							' . $option_kelurahan . '
						</select>
					</div>
					<div class="form-group col-md-2">
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
		{	
			$params = "exec [dbo].[get_level_new_v1] 2,'" . $this->user_info['text'] . "'," . $id_location . ",0,0";
			
		}elseif($level==4)
		{	
			$select_propinsi=$_GET['select-propinsi'];
			$params = "exec [dbo].[get_level_new_v1] 3,'" . $this->user_info['text'] . "',". $select_propinsi . "," . $id_location . ",0";
			
		}else //if($level==5)
		{	
			$select_propinsi=$_GET['select-propinsi'];
			$select_kabupaten=$_GET['select-kabupaten'];
			$params = "exec [dbo].[get_level_new_v1] 4,'" . $this->user_info['text'] . "',". $select_propinsi . "," . $select_kabupaten . "," . $id_location ;
		}
		$query = $this->db->query($params);
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
		// $params = [
		// 	'table' => 'asset.vw_administration_regions_v1',
		// 	'where' => [
		// 		$parent => null,
		// 		$child => null
		// 	],
		// 	'select' => 'DISTINCT regency_id, district_id, village_id, kabupaten, kecamatan, kelurahan'
		// ];
		// $query = get_data( $params );
		// return $query->num_rows();
		$params = "exec [dbo].[get_level_new_v1] 5,0,0,0";
		$query = $this->db->query($params_propinsi);
		return $query->num_rows();
	}

}