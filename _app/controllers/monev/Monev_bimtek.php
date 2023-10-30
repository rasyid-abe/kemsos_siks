 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monev_bimtek extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'monev/monev_bimtek/' );
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
				{ name:'detail', display:'Detail', width:60, sortable:false, align:'center', datasuorce: false},
				{ name:'province_name', display:'Propinsi', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'regency_name', display:'Kabupaten', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'tanggal', display:'Tanggal', width:80, sortable:false, align:'center', datasuorce: false},
				{ name:'alamat', display:'Alamat', width:170, sortable:true, align:'left', datasuorce: false},
				{ name:'jumlah_korcam_bimtek', display:'Jumlah Korcam', width:120, sortable:true, align:'center', datasuorce: false},
				{ name:'jumlah_pengawas_bimtek', display:'Jumlah Pengawas', width:120, sortable:false, align:'center', datasuorce: false},
				{ name:'jumlah_pengumpul_data_bimtek', display:'Jumlah Pengumpul Data', width:120, sortable:true, align:'center', datasuorce: false},
				{ name:'petugas_monev', display:'Petugas Monev', width:80, sortable:true, align:'left', datasuorce: false},
				{ name:'last_update_data', display:'Last Update', width:150, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
			",
			'filters' => "
				{ display:'Petugas Monev', name:'u.user_profile_first_name', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'Monev Bimtek';
		$data['grid']['link_data'] = $this->dir . "get_show_data";
		$data['grid']['table_title'] = 'Daftar Semua Data';

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
									"hasil_verivali": $( "#select-hasil-verivali ").val(),
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
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
		$input = $this->input->post();
		$where = [];
		if ( isset( $input['params'] ) ) {
			$par = $input['params'];
			$params = json_decode( $par, true );
			foreach ( $params[0] as $field => $value ) {
				if ( $value > '0' ) $where['l.' . $field] = $value;
			}
		} else {
			if ( ( ! empty( $this->user_info['user_location'] ) ) || ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE ) ) {
				$user_location = $this->get_user_location();
				$jml_negara = ( ( ! empty( $user_location['country_id'] ) ) ? count( explode( ',', $user_location['country_id'] ) ) : '0' );
				$jml_propinsi = ( ( ! empty( $user_location['province_id'] ) ) ? count( explode( ',', $user_location['province_id'] ) ) : '0' );
				$jml_kota = ( ( ! empty( $user_location['regency_id'] ) ) ? count( explode( ',', $user_location['regency_id'] ) ) : '0' );


				if ( ! empty( $jml_negara) ) $where['l.country_id ' . ( ( $jml_negara >= '2' ) ? "IN ({$user_location['country_id']}) " : "= {$user_location['country_id']}" )] = null;
				if ( ! empty( $jml_propinsi) ) $where['l.province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : "= {$user_location['province_id']}" )] = null;
				if ( ! empty( $jml_kota) ) $where['l.regency_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;

			} else {
				$where['l.country_id'] = '0';
				$where['l.province_id'] = '0';
				$where['l.regency_id'] = '0';
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
            if ($key == 'surveyor_musdes') {
				$sql_where .= "u1.user_profile_first_name LIKE '%" .$value. "%' AND ";
			} else if ($key == 'surveyor_verval') {
				$sql_where .= "u2.user_profile_first_name LIKE '%" .$value. "%' AND ";
			} else {
				$sql_where .= $key." LIKE '%" .$value. "%' AND ";
			}
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
                mb.monev_bimtek_id,
                mb.tanggal_pelaksanaan_bimtek,
                mb.alamat_bimtek,
                mb.jumlah_korcam_bimtek,
                mb.jumlah_pengawas_bimtek,
                mb.jumlah_pengumpul_data_bimtek,
                mb.lastupdate_on,
                l.province_name,
                l.regency_name,
                l.district_name,
                l.village_name,
                CONCAT ( u.user_profile_first_name, ' ', u.user_profile_last_name ) AS petugas_monev
            FROM monev.monev_bimtek mb
            LEFT JOIN dbo.ref_locations l ON mb.location_id = l.location_id
            LEFT JOIN dbo.core_user_profile u ON mb.created_by = u.user_profile_id
    		WHERE $sql_where 1=1
    		ORDER BY mb.lastupdate_on ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
            SELECT COUNT
                ( monev_bimtek_id ) jumlah
                FROM monev.monev_bimtek mb
                LEFT JOIN dbo.ref_locations l ON mb.location_id = l.location_id
                LEFT JOIN dbo.core_user_profile u ON mb.created_by = u.user_profile_id
            WHERE $sql_where 1=1
		";


        $query = data_query( $sql_query );
        $query_count = data_query( $sql_count );
        // print_r($query->result());
        // die;

		// $params = [
		// 	'table' => [
		// 		'monev.monev_bimteka mb' => '',
		// 		'dbo.ref_locations l' => ['mb.location_id = l.location_id', 'left'],
		// 		'dbo.core_user_profile u' => ['mb.created_by = u.user_profile_id', 'left'],
		// 	],
		// 	'select' => "
		// 		mb.monev_bimtek_id,
		// 		mb.tanggal_pelaksanaan_bimtek,
		// 		mb.alamat_bimtek,
		// 		mb.jumlah_korcam_bimtek,
		// 		mb.jumlah_pengawas_bimtek,
		// 		mb.jumlah_pengumpul_data_bimtek,
		// 		mb.lastupdate_on,
		// 		l.province_name,
		// 		l.regency_name,
		// 		l.district_name,
		// 		l.village_name,
		// 		CONCAT(u.user_profile_first_name,' ', u.user_profile_last_name) as petugas_monev",
		// 	'order_by' => 'mb.lastupdate_on ' . $input['sortorder'],
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
		// 		'monev.monev_bimtek mb' => '',
		// 		'dbo.ref_locations l' => ['mb.location_id = l.location_id', 'left'],
		// 		'dbo.core_user_profile u' => ['mb.created_by = u.user_profile_id', 'left'],
		// 	],
		// 	'select' => 'count(monev_bimtek_id) jumlah',
		// 	'where' => $where,
		// ];
		// $query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$lastupdate = date("d-m-Y H:i:s",strtotime($row->lastupdate_on));
			$tanggal = date("d-m-Y",strtotime($row->tanggal_pelaksanaan_bimtek));
			$detail = '<button act="' . base_url( 'monev/monev_bimtek' ) . '/get_form_detail/' . enc( [ 'monev_bimtek_id' => $row->monev_bimtek_id ] ) . '" class="btn btn-warning btn-xs btn-edit" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
			$row_data = [
				'id' => $row->monev_bimtek_id,
				'cell' => [
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
					'monev_bimtek_id' => $row->monev_bimtek_id,
					'tanggal' => $tanggal,
					'alamat' => $row->alamat_bimtek,
					'jumlah_korcam_bimtek' => $row->jumlah_korcam_bimtek,
					'jumlah_pengawas_bimtek' => $row->jumlah_pengawas_bimtek,
					'jumlah_pengumpul_data_bimtek' => $row->jumlah_pengumpul_data_bimtek,
					'petugas_monev' => $row->petugas_monev,
					'detail' => $detail,
					'last_update_data' => $lastupdate,
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


	function get_form_detail( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$monev_bimtek_id = $params['monev_bimtek_id'];
		$data = [];
		$data['monev_bimtek_id'] = $params['monev_bimtek_id'];
		$data['monev_detail'] = $this->get_monev_bimtek_information( $monev_bimtek_id );

		$params_foto = [
			'select' => 'owner_id, stereotype, row_status, internal_filename, file_name, description, file_size, latitude, longitude, created_on, created_by, file_type, user_account_username',
			'table' => [
				'dbo.files' => '',
				'dbo.core_user_account' => 'user_account_id = created_by'
			],
			'where' => [
				'owner_id' => $monev_bimtek_id,
				"files.stereotype like 'MB-%'" => null,
			],
		];
		$query_foto = get_data( $params_foto );
		$data['foto'] = $query_foto->result();

		$this->load->view("monev/detail_monev_bimtek", $data);
	}

	function get_monev_bimtek_information( $monev_bimtek_id ){
		$params_user = [
			'table' => [
				'monev.monev_bimtek mb' => '',
				'dbo.ref_locations l' => ['mb.location_id = l.location_id', 'left'],
			],
			'where' => [
				'mb.monev_bimtek_id' => $monev_bimtek_id
			]
		];
		$query_user = get_data( $params_user );
		return $query_user->row();
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
							$params_cek_assigment = [
								'table' => 'asset.master_data_proses',
								'where' => [
									'parent_id' => $id
								],
								'select' => 'proses_id'
							];
							$query_assignment = get_data( $params_cek_assigment );
							$proses_id = ( ( $query_assignment->num_rows() > 0 ) ? $query_assignment->row( 'proses_id' ) : $id );
							$params_update_assignment = [
								'table' => 'dbo.ref_assignment',
								'data' => [
									'row_status' => 'DELETED'
								],
								'where' => [
									'proses_id' => $proses_id,
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

	function move_detail( $id = null ) {
		$params_get = [
			'table' => 'asset.master_data_detail',
			'where' => [
				'proses_id' => $id
			]
		];
		$get_data = get_data( $params_get )->result_array();

		foreach ( $get_data as $key => $value ) {
			$table = '';
			if ( $value['stereotype'] == 'NOKK' ) {
				$data_nokk = [
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
				save_data( "asset.master_data_detail_proses_kk", $data_nokk );
			} else if ( $value['stereotype'] == 'ART' ) {
				unset( $value['id'] );
				save_data( "asset.master_data_detail_proses", $value );
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
		$user_location = $this->get_user_location();
		$jml_negara = count( explode( ',', $user_location['country_id'] ) );
		$jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
		$jml_kota = count( explode( ',', $user_location['regency_id'] ) );

		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';


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
