 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not_surveyed_yet_list extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/not_surveyed_yet_list/' );
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
			'col_id' => 'asset_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:40, sortable:false, align:'center', datasuorce: false},
				{ name:'id_prelist', display:'Id Prelist', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'nama_krt', display:'Nama KRT', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'nomor_nik', display:'NIK', width:80, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten',  width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Kelurahan', width:90, sortable:true, align:'left', datasuorce: false},
				{ name:'jenis_kelamin_krt', display:'Gender', width:40, sortable:true, align:'left', datasuorce: false},
				{ name:'status_rumahtangga', display:'Status', width:50, sortable:true, align:'left', datasuorce: false},
				{ name:'apakah_mampu', display:'Mampu', width:50, sortable:true, align:'left', datasuorce: false},
				{ name:'hasil_verivali', display:'Hasil Vervali', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_musdes', display:'Enum Musdes', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'petugas_verivali', display:'Enum Verval', width:60, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:90, sortable:true, align:'left', datasuorce: false},
				{ name:'detail', display:'Detail', width:50, sortable:true, align:'center', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				// { display:'Publish', name:'publish', bclass:'publish', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				// { separator: true },
				// { display:'Revoke', name:'batch', bclass:'batch', onpress:act_show, urlaction: '" . $this->dir . "act_show'},
				// { separator: true },
			",
			'filters' => "
                { display:'ID Prelist', name:'md.id_prelist', type:'text', isdefault: true },
                { display:'Nama KRT', name:'md.nama_krt', type:'text', isdefault: true },
                { display:'NIK', name:'md.nomor_nik', type:'text', isdefault: true },
                { display:'Alamat', name:'md.alamat', type:'text' },
                { display:'Enum Musdes', name:'u1.user_profile_first_name', type:'text', isdefault: true },
                { display:'Enum Verval', name:'u2.user_profile_first_name', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Data Verval';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['grid']['table_title'] = 'Daftar Data Verval';

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
							$( "#select-kabupaten ").html( "<option value=\'0\'> -- Semua Kota/Kabupaten -- </option>" );
						} else {
							get_location(params);
						}
						$( "#select-kecamatan ").html( "<option value=\'0\'> -- Semua Kecamatan -- </option>" );
						$( "#select-kelurahan ").html( "<option value=\'0\'> -- Semua Kelurahan -- </option>" );
					});

					$("#select-kabupaten").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "4",
							"title": "Kecamatan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kecamatan ").html( "<option value=\'0\'> -- Semua Kecamatan -- </option>" );
						} else {
							get_location(params);
						}
						$( "#select-kelurahan ").html( "<option value=\'0\'> -- Semua Kelurahan -- </option>" );
					});

					$("#select-kecamatan").on( "change", function(){
						let params = {
							"location_id": $(this).val(),
							"level": "5",
							"title": "Kelurahan",
						}
						if ( $(this).val() == "0" ) {
							$( "#select-kelurahan ").html( "<option value=\'0\'> -- Semua Kelurahan -- </option>" );
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
                                    "status_rumahtangga": $( "#select-hasil-musdes ").val(),
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
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_view", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
		$input = $this->input->post();
		$where = [];
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $field == 'stereotype' || $field == 'status_rumahtangga' ) {
					if ( $value > '0' ) $where['md.' . $field] = $value;
					else $where["md.stereotype IN ('VERIVALI-PUBLISHED', 'VERIVALI-REVOKED', 'VERIVALI-GRABBED', 'VERIVALI-GRAB-REVOKED', 'VERIVALI-DOWNLOADED', 'VERIVALI-DOWNLOAD-REVOKED') "] = null;
				} else {
					if ( $value > '0' ) $where['l.' . $field] = $value;
				}
			}
		} else {
			$where["md.stereotype IN ('VERIVALI-PUBLISHED', 'VERIVALI-REVOKED', 'VERIVALI-GRABBED', 'VERIVALI-GRAB-REVOKED', 'VERIVALI-DOWNLOADED', 'VERIVALI-DOWNLOAD-REVOKED') "] = null;

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

        $sql_query = "
            SELECT
                md.proses_id,
                md.stereotype,
                md.row_status,
                md.id_prelist,
                md.nomor_nik,
                md.nama_krt,
                md.alamat,
                md.jenis_kelamin_krt,
                md.nama_pasangan_krt,
                md.status_rumahtangga,
                md.apakah_mampu,
                md.hasil_verivali,
                concat ( u1.user_profile_first_name, ' ', u1.user_profile_last_name ) AS surveyor_musdes,
                concat ( u2.user_profile_first_name, ' ', u2.user_profile_last_name ) AS surveyor_verval,
                md.lastupdate_on,
                l.province_name,
                l.regency_name,
                l.district_name,
                l.village_name,
                r.icon
            FROM asset.master_data_proses md
            LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
            LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id
            AND a1.stereotype = 'MUSDES'
            AND a1.row_status = 'ACTIVE'
            LEFT JOIN dbo.ref_assignment a2 ON md.proses_id = a2.proses_id
            AND a2.stereotype = 'VERIVALI'
            AND a2.row_status = 'ACTIVE'
            LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
            LEFT JOIN dbo.core_user_profile u2 ON a2.user_id = u2.user_profile_id
    		WHERE $sql_where 1=1
    		ORDER BY md.lastupdate_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( id_prelist ) jumlah
            FROM asset.master_data_proses md
            LEFT JOIN dbo.ref_locations l ON md.location_id = l.location_id
            LEFT JOIN dbo.ref_references r ON r.short_label = md.stereotype
            LEFT JOIN dbo.ref_assignment a1 ON md.proses_id = a1.proses_id
            AND a1.stereotype = 'MUSDES'
            AND a1.row_status = 'ACTIVE'
            LEFT JOIN dbo.ref_assignment a2 ON md.proses_id = a2.proses_id
            AND a2.stereotype = 'VERIVALI'
            AND a2.row_status = 'ACTIVE'
            LEFT JOIN dbo.core_user_profile u1 ON a1.user_id = u1.user_profile_id
            LEFT JOIN dbo.core_user_profile u2 ON a2.user_id = u2.user_profile_id
    		WHERE $sql_where 1=1
		";

        $query = data_query( $sql_query );
        $query_count = data_query( $sql_count );

		// $params = [
		// 	'table' => [
		// 		'asset.master_data_prosess md' => '',
		// 		'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left'],
		// 		'dbo.ref_references r' => ['r.short_label = md.stereotype', 'left'],
		// 		'dbo.ref_assignment a1' => ["md.proses_id = a1.proses_id and a1.stereotype='MUSDES' and a1.row_status='ACTIVE'", 'left'],
		// 		'dbo.ref_assignment a2' => ["md.proses_id = a2.proses_id and a2.stereotype='VERIVALI' and a2.row_status='ACTIVE'", 'left'],
		// 		'dbo.core_user_profile u1' => ['a1.user_id=u1.user_profile_id', 'left'],
		// 		'dbo.core_user_profile u2' => ['a2.user_id=u2.user_profile_id', 'left']
		// 	],
		// 	'select' => "
		// 		md.proses_id,
		// 		md.stereotype,
		// 		md.row_status,
		// 		md.id_prelist,
		// 		md.nomor_nik,
		// 		md.nama_krt,
		// 		md.alamat,
		// 		md.jenis_kelamin_krt,
		// 		md.nama_pasangan_krt,
		// 		md.status_rumahtangga,
		// 		md.apakah_mampu,
		// 		md.hasil_verivali,
		// 		concat(u1.user_profile_first_name,' ',u1.user_profile_last_name) as surveyor_musdes,
		// 		concat(u2.user_profile_first_name,' ',u2.user_profile_last_name) as surveyor_verval,
		// 		md.lastupdate_on,
		// 		l.province_name,
		// 		l.regency_name,
		// 		l.district_name,
		// 		l.village_name,
		// 		r.icon",
		// 	'order_by' => 'md.lastupdate_on ' . $input['sortorder'],
		// 	'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
		// 	'limit' => $input['rp'],
		// 	'where' => $where
		// ];
        //
		// if ( ! empty( $input['filterRules'] ) ) {
		// 	$filterRules = filter_json( $input['filterRules'] );
		// 	$params = array_merge( $params, $filterRules );
		// }
		// $query = get_data( $params );
		// $params_count = [
		// 	'table' => [
		// 		'asset.master_data_proses md' => '',
		// 		'dbo.ref_locations l' => ['md.location_id = l.location_id', 'left']
		// 	],
		// 	'select' => 'count(id_prelist) jumlah',
		// 	'where' => $where,
		// ];
		// $query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$gender = "";
			$status_ruta = "";
			$mampu = "";
			$hasil_verivali = "";

			if($row->jenis_kelamin_krt == '1') {
				$gender = "Laki-laki";
			} else if ($row->jenis_kelamin_krt == '2') {
				$gender = "Perempuan";
			}

			if($row->status_rumahtangga == '1') {
				$status_ruta = "<span class='text-success font-weight-bold'>Ditemukan</span>";
			} else if ($row->status_rumahtangga == '2') {
				$status_ruta = "<span class='text-danger font-weight-bold'>Tidak Ditemukan</span>";
			} else if ($row->status_rumahtangga == '3') {
				$status_ruta = "<span class='text-warning font-weight-bold'>Data Ganda</span>";
			} else if ($row->status_rumahtangga == '4') {
				$status_ruta = "<span class='text-primary font-weight-bold'>Usulan Baru</span>";
			}

			if($row->apakah_mampu == '1') {
				$mampu = "<span class='text-danger font-weight-bold'>Ya</span>";
			} else if ($row->apakah_mampu == '2') {
				$mampu = "<span class='text-success font-weight-bold'>Tidak</span>";
			}

			if($row->hasil_verivali == '1') {
				$hasil_verivali = "<span class='text-success font-weight-bold'>Selesai Dicacah</span>";
			} else if ($row->hasil_verivali == '2') {
				$hasil_verivali = "<span class='text-danger font-weight-bold'>Ruta Tidak Ditemukan</span>";
			} else if ($row->hasil_verivali == '3') {
				$hasil_verivali = "<span class='text-info font-weight-bold'>Ruta Pindah/Bangunan Tidak Ada</span>";
			} else if ($row->hasil_verivali == '4') {
				$hasil_verivali = "<span class='text-primary font-weight-bold'>Bagian Dari Dokumen Ruta</span>";
			} else if ($row->hasil_verivali == '5') {
				$hasil_verivali = "<span class='text-warning font-weight-bold'>Responden Menolak</span>";
			} else if ($row->hasil_verivali == '6') {
				$hasil_verivali = "<span class='text-danger font-weight-bold'>Data Ganda</span>";
            }
			$lastupdate = date("d-m-Y H:i:s",strtotime($row->lastupdate_on));
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
					'jenis_kelamin_krt' => $gender,
					'nama_pasangan_krt' => $row->nama_pasangan_krt,
					'status_rumahtangga' => $status_ruta,
					'apakah_mampu' => $mampu,
					'hasil_verivali' => $hasil_verivali,
					'petugas_musdes' => $row->surveyor_musdes,
					'petugas_verivali' => $row->surveyor_verval,
					'last_update_data' => $lastupdate,
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
				foreach ( $arr_id as $id ) {
					$params_get_cek = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'parent_id' => $id
						],
					];
					$get_data_cek = get_data( $params_get_cek )->num_rows();
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
						$params_get = [
							'table' => 'asset.master_data_proses',
							'where' => [
								'proses_id' => $id
							],
							// 'select' => 'asset_id, stereotype, row_status'
						];
						$get_data = get_data( $params_get )->row();
						$get_data->stereotype = 'PROVINCE-PUBLISHED';
						$get_data->parent_id = $get_data->proses_id;
						unset( $get_data->proses_id );
						unset( $get_data->tanggal_pemerikasaan );
						unset( $get_data->nama_pemerika );
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
						save_data( 'asset.master_data_proses', $get_data);
						$params_insert_master_data_log = [
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
						save_data( 'asset.master_data_log', $params_insert_master_data_log);

						$params_update_master_data = [
							'table' => 'asset.master_data_proses',
							'data' => [
								'stereotype' => 'PROVINCE-PUBLISHED'
							],
							'where' => [
								'proses_id' => $id
							],
						];
						save_data( $params_update_master_data);
						$this->move_detail( $id );

						$success++;
						$arr_output['message'] = $success .' data berhasil dipublish.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					} else {
						$failed++;
						$arr_output['message'] = $failed .' data gagal dipublish.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					}
				}
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		// batch
		if ( isset( $in['batch'] ) && $in['batch'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = $failed = 0;
				$datetime = date( "Y-m-d H:i:s");
				foreach ( $arr_id as $id ) {
					$row = null;
					$params_get = [
						'table' => 'asset.master_data_proses',
						'where' => [
							'proses_id' => $id
						],
					];
					$query_data = get_data( $params_get );
					if ( $query_data->num_rows() == '0' ) {
						$params_get['where'] = [
							'parent_id' => $id
						];
						$query_data = get_data( $params_get );
						$row = ( ( $query_data->num_rows() >= 1 ) ? $query_data->row() : null );
					} else {
						$row = $query_data->row();
					}
					$arr_stereotype = ['MUSDES-GRABBED', 'MUSDES-DOWNLOADED', 'MUSDES-SURVEY', 'VERIVALI-GRABBED', 'VERIVALI-DOWNLOADED', 'VERIVALI-SURVEY', 'MUSDES-GRAB-REVOKED', 'MUSDES-DOWNLOAD-REVOKED', 'MUSDES-SURVEY-REVOKED', 'VERIVALI-GRAB-REVOKED', 'VERIVALI-DOWNLOAD-REVOKED', 'VERIVALI-SURVEY-REVOKED'];
					if ( $row != null && in_array( $row->stereotype, $arr_stereotype ) ) {

						$data_update_mdp = [
							'table' => 'asset.master_data_proses',
							'data' => [],
							'where' => [],
						];
						if ( $row->stereotype == 'MUSDES-GRABBED' ) {
							$data_update_mdp['data']['stereotype'] = 'MUSDES-GRAB-REVOKED';
							$stereotype_assignment = 'MUSDES';
						} else if ( $row->stereotype == 'MUSDES-DOWNLOADED' ) {
							$data_update_mdp['data']['stereotype'] = 'MUSDES-DOWNLOAD-REVOKED';
							$stereotype_assignment = 'MUSDES';
						} else if ( $row->stereotype == 'MUSDES-SURVEY' ) {
							$data_update_mdp['data']['stereotype'] = 'MUSDES-SURVEY-REVOKED';
							$stereotype_assignment = 'MUSDES';
						} else if ( $row->stereotype == 'VERIVALI-GRABBED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-GRAB-REVOKED';
							$stereotype_assignment = 'VERIVALI';
						} else if ( $row->stereotype == 'VERIVALI-DOWNLOADED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-DOWNLOAD-REVOKED';
							$stereotype_assignment = 'VERIVALI';
						} else if ( $row->stereotype == 'VERIVALI-SURVEY' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-SURVEY-REVOKED';
							$stereotype_assignment = 'VERIVALI';
						} else if ( $row->stereotype == 'MUSDES-GRAB-REVOKED' ) {
							$data_update_mdp['data']['stereotype'] = 'PROVINCE-PUBLISHED';
							$stereotype_assignment = null;
						} else if ( $row->stereotype == 'MUSDES-DOWNLOAD-REVOKED' ) {
							$data_update_mdp['data']['stereotype'] = 'PROVINCE-PUBLISHED';
							$stereotype_assignment = null;
						} else if ( $row->stereotype == 'MUSDES-SURVEY-REVOKED' ) {
							$data_update_mdp['data']['stereotype'] = 'PROVINCE-PUBLISHED';
							$stereotype_assignment = null;
						} else if ( $row->stereotype == 'VERIVALI-GRAB-REVOKED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
							$stereotype_assignment = null;
						} else if ( $row->stereotype == 'VERIVALI-DOWNLOAD-REVOKED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
							$stereotype_assignment = null;
						} else if ( $row->stereotype == 'VERIVALI-SURVEY-REVOKED' ) {
							$data_update_mdp['data']['stereotype'] = 'VERIVALI-PUBLISHED';
							$stereotype_assignment = null;
						}

						$user_ip = client_ip();
						$audit_trails = json_decode( $row->audit_trails, true );
						$audit_trails[] = [
							"ip" => $user_ip['ip_address'],
							"on" => $datetime,
							"act" => "BATCH",
							"user_id" => $this->user_info['user_id'],
							"username" => $this->user_info['user_username'],
							"column_data" => [
								"asset_id" => $id,
								"stereotype" => $data_update_mdp['data']['stereotype']
							],
							"is_proxy_access" =>  $user_ip['is_proxy']
						];

						$data_update_mdp['data']['audit_trails'] = json_encode( $audit_trails );
						$data_update_mdp['data']['lastupdate_on'] = $datetime;
						$data_update_mdp['where'] = ( ( $row->row_status == 'COPY' ) ? [ 'parent_id' => $id ] : [ 'proses_id' => $id ] );
						save_data( $data_update_mdp );

						$params_insert_master_data_log = [
							'data_log_master_data_id' => $id,
							'data_log_status' => 'sukses',
							'data_log_description' => 'Revoke Data id_prelist ' . $row->id_prelist,
							'data_log_stereotype' => $data_update_mdp['data']['stereotype'],
							'data_log_row_status' => $row->row_status,
							'data_log_lastupdate_by' => $this->user_info['user_id'],
							'data_log_lastupdate_on' => $datetime,
						];
						save_data( 'asset.master_data_log', $params_insert_master_data_log);

						if ( $stereotype_assignment != null ) {
							$params_update_assignment = [
								'table' => 'dbo.ref_assignment',
								'data' => [
									'row_status' => 'DELETED'
								],
								'where' => [
									'proses_id' => $id,
									'stereotype' => $stereotype_assignment,
								],
							];
							save_data( $params_update_assignment);
						}

						$success++;
						$arr_output['message'] = $success .' data berhasil dibatch.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					} else {
						$failed++;
						$arr_output['message'] = $failed .' data gagal dibatch.';
						$arr_output['message_class'] = 'response_confirmation alert alert-success';
					}
				}
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode( $arr_output );
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
        $option_hasil_musdes = '<option value="0">Semua Hasil Musdes</option>';

		$where_propinsi = [];

		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['location_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
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

        $arr_hasil_musdes = [
			'1' => 'Ditemukan',
			'2' => 'Tidak Ditemukan',
			'3' => 'Data Ganda',
			'4' => 'Usulan Baru',
		];
		foreach ( $arr_hasil_musdes as $kode => $musdes) {
			$option_hasil_musdes .= '<option value="' . $kode . '" >' . $musdes . '</option>';
		}


		$form_cari = '
			<div class="row" style="font-size:12px;margin-top:-10px;margin-bottom:-10px;">
				<div class="row col-md-12">
					<div class="form-group col-md-4">
						<select id="select-propinsi" name="propinsi" class="js-example-basic-single form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_propinsi . '
						</select>
					</div>
					<div class="form-group col-md-4">
						<select id="select-kabupaten" name="kabupaten" class="js-example-basic-single form-control" ' . ( ( ( $jml_kota == '1' ) && ( ! empty( $user_location['regency_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kota . '
						</select>
					</div>
					<div class="form-group col-md-4">
						<select id="select-kecamatan" name="kecamatan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kecamatan == '1' ) && ( ! empty( $user_location['district_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kecamatan . '
						</select>
					</div>
				</div>
				<div class="row col-md-12">
					<div class="form-group col-md-3">
						<select id="select-kelurahan" name="kelurahan" class="js-example-basic-single form-control" ' . ( ( ( $jml_kelurahan == '1' ) && ( ! empty( $user_location['village_id'] ) ) ) ? 'disabled ' : '' ) . '>
							' . $option_kelurahan . '
						</select>
					</div>
					<div class="form-group col-md-3">
						<select id="select-status" name="status" class="js-example-basic-single form-control">
							<option value="">Semua Status</option>
							<option value="VERIVALI-PUBLISHED">7.Prelist Akhir DIPUBLISH KORKAB</option>
							<option value="VERIVALI-REVOKED">7a.Dibatalkan / Diulang, di Proses - 7</option>
							<option value="VERIVALI-GRABBED">8.Prelist Akhir DITERIMA ENUMERATOR</option>
							<option value="VERIVALI-GRAB-REVOKED">8a.Dibatalkan / Diulang, di Proses - 8</option>
							<option value="VERIVALI-DOWNLOADED">9.Prelist Akhir DIUNDUH ENUMERATOR</option>
							<option value="VERIVALI-DOWNLOAD-REVOKED">9a.Dibatalkan / Diulang, di Proses - 9</option>
						</select>
					</div>
                    <div class="form-group col-md-3">
						<select id="select-hasil-musdes" name="hasil_musdes" class="js-example-basic-single form-control">
							' . $option_hasil_musdes . '
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
