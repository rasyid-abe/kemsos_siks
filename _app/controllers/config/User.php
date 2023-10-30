<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->json = [];
		$this->dir = "config/user/";
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['grid'] = [
			'col_id' => 'user_account_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'status', display:'Status', width:60, sortable:true, align:'center', datasuorce: false},
				{ name:'detail', display:'Detail', width:60, sortable:false, align:'center', datasuorce: false},
				{ name:'user_account_id', display:'User Id', width:120, sortable:true, align:'left', datasuorce: false},
				{ name:'user_account_username', display:'Username', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'user_group_title', display:'Group', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'user_full_name', display:'Nama Lengkap', width:180, sortable:true, align:'left', datasuorce: false},
				{ name:'user_profile_nik', display:'NIK', width:180, sortable:true, align:'left', datasuorce: false},
				{ name:'user_account_email', display:'Email', width:180, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Tambah', name:'add', bclass:'add', onpress:add, urlaction:'" . base_url( $this->dir ) . "get_add_form' },
				{ separator: true },
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Aktifkan', name:'publish', bclass:'publish', onpress:act_show, urlaction: '" . base_url( $this->dir ) . "act_show'},
				{ separator: true },
				{ display:'Non Aktifkan', name:'unpublish', bclass:'unpublish', onpress:act_show, urlaction:'" . base_url( $this->dir ) . "act_show'},
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:act_show, urlaction:'" . base_url( $this->dir ) . "act_show' },
				{ separator: true },
			",
			'filters' => "
				{ display:'User Id', name:'user_account_id', type:'text', isdefault: true },
				{ display:'Username', name:'user_account_username', type:'text', isdefault: true },
				{ display:'Group', name:'user_group_id', type:'select', option: '2:Korwil|3:Enumerator|4:Supervisor|5:Monitoring-Kualitas|1003:Korkab' },
				{ display:'NIK', name:'user_profile_nik', type:'text', isdefault: true },
				{ display:'Nama Lengkap', name:'user_profile_first_name', type:'text', isdefault: true },
			",
		];
		$data['grid']['title'] = 'User Management';
		$data['grid']['link_data'] =  base_url( $this->dir ) . "get_show_data";
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "admin/User", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data(){
		$input = $this->input->post();
		$where = [];
		$par = $input['querys'];
		if ( !empty($par) ) {
			$params = json_decode( $par, true );
			foreach ($params as $key => $value) {
				if ($value['filter_field'] == 'user_account_id') {
					$where['cua.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_account_username') {
					$where['cua.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_group_id') {
					$where['cug.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_profile_nik') {
					$where['cup.'.$value['filter_field']] = $value['filter_value'];
				} elseif ($value['filter_field'] == 'user_profile_first_name') {
					$where['cup.'.$value['filter_field']] = $value['filter_value'];
				}
			}
		}

		$sql_where = '';

		$user_location = $this->user_info['user_location'];
		$in_location = '';
		if ( ! in_array( '100000', $user_location ) ) {
			$sql_where .= 'user_account_create_by = ' . $this->user_info['user_id'] .' AND';
		}

		if (!empty($where)) {
			foreach ($where as $key => $value) {
				if ($key == 'cua.user_account_id') {
					$sql_where .= "cua.user_account_id LIKE '%" .$value. "%' AND ";
				} else if ($key == 'cua.user_account_username') {
					$sql_where .= "cua.user_account_username LIKE '%" .$value. "%' AND ";
				} else if ($key == 'cug.user_group_id') {
					$sql_where .= "cug.user_group_id LIKE '%" .$value. "%' AND ";
				} else if ($key == 'cup.user_profile_nik') {
					$sql_where .= "cup.user_profile_nik LIKE '%" .$value. "%' AND ";
				} else {
					$sql_where .= "cup.user_profile_first_name LIKE '%" .$value. "%' AND ";
				}
			}
		}

		$sql_query = "
		SELECT 
		DISTINCT user_group_title, 
		user_group_group_id, 
		user_profile_nik, 
		user_account_email, 
		user_account_id, 
		user_account_username, 
		user_account_is_active, 
		user_profile_first_name, 
		user_profile_last_name 
		FROM dbo.core_user_account cua 
		LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id 
		LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id 
		LEFT JOIN dbo.core_user_group cug ON ug.user_group_group_id = cug.user_group_id 
		LEFT JOIN dbo.user_location ul ON cua.user_account_id = ul.user_location_user_account_id 
		LEFT JOIN dbo.ref_locations l ON ul.user_location_location_id = l.location_id
		WHERE $sql_where 1=1
		ORDER BY user_account_id ".$input['sortorder']." OFFSET ".( ( $input['page'] - 1 ) * $input['rp'] )." ROWS FETCH NEXT ".$input['rp']." ROWS ONLY
		";

		$sql_count = "
			SELECT count(DISTINCT user_account_id) jumlah FROM dbo.core_user_account cua LEFT JOIN dbo.user_group ug ON cua.user_account_id = ug.user_group_user_account_id LEFT JOIN dbo.core_user_profile cup ON cua.user_account_id = cup.user_profile_id LEFT JOIN dbo.core_user_group cug ON ug.user_group_group_id = cug.user_group_id LEFT JOIN dbo.user_location ul ON cua.user_account_id = ul.user_location_user_account_id LEFT JOIN dbo.ref_locations l ON ul.user_location_location_id = l.location_id WHERE $sql_where 1=1
		";

		$query = data_query( $sql_query );
		$query_count = data_query( $sql_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$is_active = '<i class="' . ( ( $row->user_account_is_active == '0' ) ? 'fa fa-times-circle' : 'fa fa-check-circle' ) . '" style=";font-size:16px;' . ( ( $row->user_account_is_active == '0' ) ? 'color:#f52c51;' : 'color:#22d672;' ) . '"></i>';
			$user_full_name = $row->user_profile_first_name. ' ' .$row->user_profile_last_name;


			$detail = '<button act="' . base_url( 'config/user' ) . '/get_form_detail/' . enc( [ 'user_id' => $row->user_account_id ] ) . '" class="btn btn-warning btn-xs btn-edit" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
			
			
			
			$row_data = [
				'id' => $row->user_account_id,
				'cell' => [
					'user_account_id' => $row->user_account_id,
					'user_account_username' => $row->user_account_username,
					'user_full_name' => $user_full_name,
					'user_group_group_id' => $row->user_group_group_id,
					'user_account_email' => $row->user_account_email,
					'user_profile_nik' => $row->user_profile_nik,
					'user_group_title' => $row->user_group_title,
					'status' => $is_active,
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

	function get_show_location( $parent_id = '0', $ret = 1 ){
		$params_location = [
			'table' => 'dbo.ref_locations',
			'select' => 'location_id, parent_id, name, full_name, level',
			'where' => ['parent_id' => $parent_id]
		];
		$location = get_data( $params_location )->result();
		if ( $ret ) {
			echo json_encode( $this->format_json( $location, $parent_id ) );
		} else {
			return json_encode( $this->format_json( $location, $parent_id ) );
		}
	}

	function get_location_active( $user_id ) {
		$params_location = [
			'table' => [
				'dbo.user_location' => '',
				'dbo.ref_locations' => 'user_location_location_id = location_id',
			],
			'select' => 'country_id, province_id, regency_id, district_id, village_id, full_name as name, level',
			'where' => [
				'user_location_user_account_id' => $user_id,
			],
		];
		$location = get_data( $params_location )->result_array();
		if ( count( $location ) ) {
			foreach ( $location as $key => $loc ) {
				$location[$key]['parent'] = [
					'1' => $loc['country_id'],
					'2' => $loc['province_id'],
					'3' => $loc['regency_id'],
					'4' => $loc['district_id'],
					'5' => $loc['village_id'],
				];
				$location[$key]['item'] = [];
			}
		}
		return json_encode( $location );
	}

	function get_loc( $parent_id ) {
		$params_location = [
			'table' => 'dbo.ref_locations',
			'select' => 'location_id, parent_id',
			'where' => [
				'parent_id' => $parent_id,
			],
		];

		return get_data( $params_location )->row();
	}

	function format_json( $location, $parent_id ){
		$arr_location = [];
		if ( $parent_id == '0' ) {
			$arr_location = [
				[
					'id' => '100000',
					'name' => 'Indonesia',
					'level' => '1',
					'parent_id'=> '0',
					'item' => [],
				],
			];
		} else {
			foreach ( $location as $key => $loc) {
				$arr_location[] = [
					'id' => $loc->location_id,
					'name' => $loc->full_name,
					'level' => $loc->level,
					'parent_id' => $loc->parent_id,
					'item' => [],
				];
			}
		}
		return $arr_location;
	}

	function act_show(){
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();
		//delete
		if ( isset( $in['delete'] ) && $in['delete'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$item_deleted = $item_undeleted = 0;
				foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'core_user_account',
						'where' => [
							'user_account_id' => $id
						]
					];
					$check = get_data( $params_check );
					if ( $check ) {
						delete_data( 'core_user_account', 'user_account_id', $id );
						delete_data( 'core_user_profile', 'user_profile_id', $id );
						$item_deleted++;
					} else {
						$item_undeleted++;
					}
				}
				$arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
				$arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		//publish
		if ( isset( $in['publish'] ) && $in['publish'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = 0;
				foreach ($arr_id as $id) {
					$params = [
						'table' => 'core_user_account',
						'data' => [
							'user_account_is_active' => '1',
						],
						'where' => [
							'user_account_id' => $id
						]
					];
					save_data( $params );
					$success++;
				}

				$arr_output['message'] = $success .' data berhasil diaktifkan.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		//unpublish
		if ( isset( $in['unpublish'] ) && $in['unpublish'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$success = 0;
				foreach ($arr_id as $id) {
					$params = [
						'table' => 'core_user_account',
						'data' => [
							'user_account_is_active' => '0',
							'user_account_token' => '',
						],
						'where' => [
							'user_account_id' => $id
						]
					];
					save_data( $params );
					$success++;
				}
				$arr_output['message'] = $success . ' data berhasil dinonaktifkan.';
				$arr_output['message_class'] = 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode( $arr_output );
	}

	function get_add_form(){
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = [];
		if ( ( isset( $par['user_group_id'] ) ) && ! empty( $par['user_group_id'] ) ) {
			$data['form_title'] = "Edit User Menu";
			$data['form_action'] = base_url( $this->dir . 'act_edit' );
			$params_detail = [
				'select' => 'user_group_id, user_group_title, user_group_description',
				'table' => 'core_user_group',
				'where' => [
					'user_group_id' => $par['user_group_id'],
				],
			];
			$query_detail = get_data( $params_detail );
			$row = $query_detail->row();
			$params_detail_menu = [
				'select' => 'user_role_menu_id, user_role_menu_action',
				'table' => 'core_user_role',
				'where' => [
					'user_role_user_group_id' => $par['user_group_id'],
				],
			];
			$data_menu = $this->struktur_data_menu( get_data( $params_detail_menu, true ) );
		} else {
			$data['form_title'] = "Tambah Pengguna";
			$data['form_action'] = base_url( $this->dir . 'act_add' );
			$row = [];
			$data_menu = [];
		}

		$data['form_data'] = '
			<ul id="msg-error" class="col-md-12"></ul>
			<div id="f_data" class="row col-12">
				<div class="col-md-6">
					<div class="row">
						<label class="col-12 f-w-900">Nama Lengkap</label>
						<div class="col-12 form-group">
							<input type="hidden" name="user_account_id" value="' . ( ( ( isset( $par['user_account_id'] ) ) && ! empty( $par['user_group_id'] ) ) ? $par['user_group_id'] : "0" ) . '">
							<input type="text" class="form-control form-control-sm" name="user_first_name" value="" required >
						</div>
					</div>
					<div class="row">
						<label class="col-12 f-w-900">NIK</label>
						<div class="col-12 form-group">
							<input minlength="16" maxlength="16" pattern=".{16,16}" title="Wajib 16 digit." id="value_nik" class="form-control form-control-sm" name="user_nik" value="" required >
						</div>
					</div>
					<div class="row">
						<label class="col-12 f-w-900">Email</label>
						<div class="col-12 form-group">
							<input type="email" class="form-control form-control-sm" name="user_email" value="" required >
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<label class="col-12 f-w-900">No. HP</label>
						<div class="col-12 form-group">
							<div class="input-group ">
								<div class="input-group-prepend">
									<div class="input-group-text form-control form-control-sm">+62</div>
								</div>
								<input minlength="10" maxlength="12" id="no_hp" class="form-control form-control-sm" name="user_no_hp" value="" required >
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-12 f-w-900">Username</label>
						<div class="col-12 form-group">
							<input class="form-control form-control-sm" name="user_username" value="" required readonly style="padding-left:10px;">
						</div>
					</div>
				</div>
				<div class="col-sm-12 custom-control custom-checkbox m-30">
					<input type="checkbox" class="custom-control-input" > <label class="custom-control-label">Send account credential to user email</label> <br> <br>
					<input type="checkbox" class="custom-control-input" > <label class="custom-control-label">Send SMS account credential to user mobile phone</label>
				</div>
			</div>

			<script>
				$(document).ready(function(){
					$("#no_hp").on( "input", function(){
						$("input[name=\'user_username\']").val( "0" + $(this).val() );
					});

					$("#btn_save").on( "click", function() {
						console.log("click save");
						$.ajax({
							url: $( "#form-data" ).attr( "action" ),
							type: "POST",
							dataType: "json",
							data: $("#form-data").serialize(),
							beforeSend: function( xhr ) {
								$("#modalLoader").modal("show");
							},
							success : function(data) {
								if ( data.status == 200 ) {
									$("#gridview").flexReload();
									$("#response_message").html(data.msg).show().addClass("alert alert-success");
									$("#modalForm").modal("hide");
								} else {
									$("#msg-error").html(data.msg).addClass("alert alert-danger");
								}
							},
						});
					});
				});
			</script>

			<script>
				// Restricts input for the given textbox to the given inputFilter.
				function setInputFilter(textbox, inputFilter) {
				["input"].forEach(function(event) {
					textbox.addEventListener(event, function() {
					if (inputFilter(this.value)) {
						this.oldValue = this.value;
						this.oldSelectionStart = this.selectionStart;
						this.oldSelectionEnd = this.selectionEnd;
					} else if (this.hasOwnProperty("oldValue")) {
						this.value = this.oldValue;
						this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
					} else {
						this.value = "";
					}
					});
				});
				}

				// Install input filters.
				setInputFilter(document.getElementById("no_hp"), function(value) {
				return /^-?\d*$/.test(value); });
				setInputFilter(document.getElementById("value_nik"), function(value) {
				return /^-?\d*$/.test(value); });
			</script>
		';
		$this->load->view("general/Form_view", $data);
	}

	function act_add(){
		$this->load->library( 'encryption' );
		$input = $this->input->post();
		$no_hp = '';
		$result = [
			'status' => 500,
			'msg' => [],
		];
		$status = false;

		if ( ! empty( $input['user_no_hp'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $input['user_no_hp'] ) ) {
				if ( strlen( $input['user_no_hp'] ) >= 9 && strlen( $input['user_no_hp'] ) <= 12 ) {
					$status = true;
					$no_hp = "+62" . $input['user_no_hp'];

					if ( ! empty( $input['user_username'] ) ) {
						$getUser = $this->db->get_where('dbo.core_user_account', ['user_account_username' => $input['user_username']])->num_rows();
						if ( $getUser > 0 ) {
							$status = false;
							$result['msg'][] =  '<li>Isian <b>Username</b> harus unik!</li>';
						} else {
							if ( ! empty( $input['user_nik'] ) ) {
								if ( preg_match( '/^[1-9][0-9]*$/' , $input['user_nik'] ) ) {
									if ( strlen( $input['user_nik'] ) != 16 ) {
										$status = false;
										$result['msg'][] =  '<li>Panjang Isian <b>NIK</b> harus 16 karakter!</li>';
									} else {
										$status = true;
									}
								} else {
									$status = false;
									$result['msg'][] =  '<li>Isian <b>NIK</b> harus diisi dengan karakter numerik!</li>';
								}
							} else {
								$status = false;
								$result['msg'][] =  '<li>Isian <b>NIK</b> harus diisi!</li>';
							}
						}
					}

				} else {
					$status = false;
					$result['msg'][] =  '<li>Panjang Isian <b>No. HP</b> 10 - 13 karakter!</li>';
				}
			} else {
				$status = false;
				$result['msg'][] =  '<li>Isian <b>No. HP</b> harus karakter numerik!</li>';
			}
		} else {
			$status = false;
			$result['msg'][] =  '<li>Isian <b>No. HP</b> harus diisi!</li>';
		}

		if ( $status ) {
			$data_save_user_account = [
				'user_account_username' => $input['user_username'],
				'user_account_password' => $this->encryption->encrypt( $this->get_random_char( 6 ) ),
				'user_account_email' => $input['user_email'],
				'user_account_is_active' => '1',
				'user_account_create_by' => $this->user_info['user_id'],
			];
			$id = save_data( 'core_user_account', $data_save_user_account );

			$data_save_user_profile = [
				'user_profile_id' => $id,
				'user_profile_first_name' => $input['user_first_name'],
				// 'user_profile_last_name' => $input['user_last_name'],
				'user_profile_nik' => $input['user_nik'],
				'user_profile_no_hp' => $no_hp,
				'user_profile_address' => '-'
			];
			save_data( 'core_user_profile', $data_save_user_profile );
			if ( ! empty( $id ) ){
				$result['status'] = 200;
				$result['msg'][] = 'Data Berhasil Disimpan!';
			} else {
				$result['msg'][] = 'Data Gagal Disimpan!';
			}
		}
		echo json_encode( $result );
	}

	function act_edit(){
		$input = $this->input->post();
		$arr_input_menu_action = ( ( isset( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'user_group_title' => $input['user_group_title'],
			'user_group_name' => url_title( $input['user_group_title'], 'dash', true ),
			'user_group_description' => $input['user_group_description'],
		];
		$id = save_data( 'core_user_group', $data_save, [ 'user_group_id' => $input['user_group_id'] ] );
		if ( isset( $input['menu'] ) ){
			delete_data( 'core_user_role', 'user_role_user_group_id', $input['user_group_id'] );
			$data_save_role = [];
			foreach ( $input['menu'] as $key => $menu ) {
				$data_save_role[] = [
					'user_role_user_group_id' => $input['user_group_id'],
					'user_role_menu_id' => $menu,
					'user_role_menu_action' =>  ( ( isset( $input['menu_action'][$menu] ) ) ? json_encode( $input['menu_action'][$menu] ) : null ),
				];
			}
			$insert_menu = $this->db->insert_batch( 'core_user_role', $data_save_role );
		}
		if ( $id || $insert_menu ){
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

	function get_random_char( $length = 6 ) {
		$str = "";
		$characters = array_diff( array_merge( range('A','Z'), range('a','z'), range('0','9') ), ["O", "0", "l", "I", "1"]);
		$clear_char = [];
		foreach ( $characters as $key => $value ) {
			$clear_char[] = $value;
		}
		$max = count( $clear_char ) - 1;
		for ( $i = 0; $i < $length; $i++ ) {
			$rand = mt_rand( 0, $max );
			$str .= $clear_char[$rand];
		}
		return $str;
	}

	function get_childs($id)
	{
		// $id = $this->input->post('id');

		$sql = "
			SELECT rl.location_id, rl.parent_id, rl.name, rl.full_name, (SELECT COUNT(*) FROM dbo.ref_locations WHERE parent_id = rl.location_id) as hasChild
			FROM dbo.ref_locations rl
			WHERE parent_id = $id
		";

		return $this->db->query($sql)->result_array();
	}

	function get_show_userloc($where)
	{
		$sql = "
			SELECT rl.location_id, rl.parent_id, rl.name, rl.full_name, (SELECT COUNT(*) FROM dbo.ref_locations WHERE parent_id = rl.location_id) as hasChild
			FROM dbo.ref_locations rl
			WHERE location_id $where
		";
		
		return $this->db->query($sql)->result_array();
	}

	function get_form_detail( $par = null ) {
		
		$user_info = $_SESSION['user_info'];
		$this->load->library( 'encryption' );
		
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		
		
		$user_id = '';
		$user_id = $params['user_id'];
		$data = '';
		$data = [];
		$data['url_service'] = base_url( 'config/user/get_show_location' );


		if (in_array('root', $user_info['user_group'])) {
			$res_loc_id = 100000;
		} else {
			$sql = "
				SELECT user_location_location_id, level FROM dbo.user_location
				JOIN dbo.ref_locations ON user_location_location_id = location_id
				WHERE user_location_user_account_id = ".$user_info['user_id']."
			";
			$get_Data = $this->db->query($sql)->result_array();

			$arr_level = [];
			$arr_loc_id = [];
			$where = '';
		
			for ($i=0; $i < count($get_Data); $i++) {
				$arr_level[] = $get_Data[$i]['level'];
				$arr_loc_id[] = $get_Data[$i]['user_location_location_id'];
			}
			$res_level = min($arr_level);
			$allow_loc = $arr_loc_id;
			if (in_array('korwil', $user_info['user_group'])) {
				foreach ($arr_loc_id as $key => $value) {
					if (strlen($value) < 3) {
						$allow_loc[] = $value;
					}
				}
			}
			
			$data_in = "'" . implode("','", $allow_loc) . "'";
			$in_where = preg_replace('/\s+/', '', $data_in);
			$where = ' IN ('.$in_where.')';
			$userloc = $this->get_show_userloc($where);

			$area_1 = [];

			for ($i=0; $i < count($userloc); $i++) {
				$get_child1 = $this->get_childs($userloc[$i]['location_id']);
				$area_2 = [];
				for ($j=0; $j < count($get_child1); $j++) {
					$get_child2 = $this->get_childs($get_child1[$j]['location_id']);
					$area_3 = [];
					for ($k=0; $k < count($get_child2); $k++) {
						$area_3[] = [
							'location_id' => $get_child2[$k]['location_id'],
							'parent_id' => $get_child2[$k]['parent_id'],
							'name' => $get_child2[$k]['name'],
							'full_name' => $get_child2[$k]['full_name'],
						];
					}
					$area_2[] = [
						'location_id' => $get_child1[$j]['location_id'],
						'parent_id' => $get_child1[$j]['parent_id'],
						'name' => $get_child1[$j]['name'],
						'full_name' => $get_child1[$j]['full_name'],
						'hasChild' => $area_3,
					];
				}
				$area_1[] = [
					'location_id' => $userloc[$i]['location_id'],
					'parent_id' => $userloc[$i]['parent_id'],
					'name' => $userloc[$i]['name'],
					'full_name' => $userloc[$i]['full_name'],
					'hasChild' => $area_2,
				];
			}
			$data['userloc'] = $area_1;
		}

		$data['location'] = $this->get_show_location('0', 0);

		$data['location_active'] = $this->get_location_active( $user_id );

		$data['grid_loc'] = [
			'col_id' => 'user_location_id',
			'sort' => 'asc',
			'columns' => "
				{ name:'user_location_location_id', display:'ID', width:40, sortable:true, align:'center', datasuorce: false},
				{ name:'province_name', display:'Provinsi', width:150, sortable:false, align:'ledt', datasuorce: false},
				{ name:'regency_name', display:'Kota / Kab.', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'district_name', display:'Kecamatan', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'village_name', display:'Desa', width:150, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:remove_location, urlaction:'" . base_url( 'config/user' ) . "/act_show_location' },
				{ separator: true },
			",
			'link_data' => base_url( 'config/user/get_show_user_location/' . $user_id ),
		];
		$data['grid_group'] = [
			'col_id' => 'user_group_id',
			'sort' => 'asc',
			'columns' => "
				{ name:'user_group_group_id', display:'ID', width:40, sortable:true, align:'center', datasuorce: false},
				{ name:'user_group_title', display:'Nama Group', width:150, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:remove_location, urlaction:'" . base_url( 'config/user' ) . "/act_show_group' },
				{ separator: true },
			",
			'link_data' => base_url( 'config/user/get_show_user_group/' . $user_id ),
		];

		$data['grid_subordinat_user'] = [
			'col_id' => 'user_account_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'checkbox', display:'', width:25, sortable:false, align:'center', datasuorce: false},
				{ name:'user_account_id', display:'ID', width:70, sortable:true, align:'center', datasuorce: false},
				{ name:'user_account_username', display:'Username', width:100, sortable:true, align:'center', datasuorce: false},
				{ name:'user_full_name', display:'Full Name', width:240, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
			",
			'link_data' => base_url( 'config/user/get_show_all_user' ),
		];

		$data['grid_subordinat_detail'] = [
			'col_id' => 'user_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'user_id', display:'ID', width:70, sortable:true, align:'center', datasuorce: false},
				{ name:'user_account_username', display:'Username', width:150, sortable:true, align:'center', datasuorce: false},
				{ name:'user_full_name', display:'Full Name', width:300, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
			",
			'link_data' => base_url( 'config/user/get_show_subordinates/' . $user_id ),
		];

		$data['grid_logs_user'] = [
			'col_id' => 'data_log_id',
			'sort' => 'desc',
			'columns' => "
				{ name:'data_log_created_by', display:'ID', width:70, sortable:true, align:'center', datasuorce: false},
				{ name:'data_log_stereotype', display:'Stereotype', width:200, sortable:true, align:'center', datasuorce: false},
				{ name:'data_log_created_on', display:'Time', width:150, sortable:true, align:'center', datasuorce: false},
				{ name:'data_log_row_status', display:'Status', width:100, sortable:true, align:'left', datasuorce: false},
				{ name:'data_log_description', display:'Description', width:470, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
			",
			'link_data' => base_url( 'config/user/get_logs_user/' . $user_id ),
		];

		$data['user_id'] = $params['user_id'];
		$data['dir'] = $this->dir;

		$data['user_group'] = $this->get_data_user_group();
		$data['user_detail'] = $this->get_user_information( $user_id );
		$data['user_database'] = $this->get_user_database( $user_id );
		$data['user_device'] = $this->get_data_user_device( $user_id );
		$this->load->view("admin/Detail_user", $data);
	
	}

	function act_show_location() {
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();
		//delete
		if ( isset( $in['delete'] ) && $in['delete'] ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$item_deleted = $item_undeleted = 0;
				foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'user_location',
						'where' => [
							'user_location_id' => $id
						]
					];
					$check = get_data( $params_check );
					if ( $check ) {
						delete_data('user_location', 'user_location_id', $id);
						$item_deleted++;
					} else {
						$item_undeleted++;
					}
				}
				$arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
				$arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
			} else {
				$arr_output['message'] = 'Anda belum memilih data.';
				$arr_output['message_class'] = 'response_error alert alert-danger';
			}
		}

		echo json_encode( $arr_output );
	}

	function act_show_group() {
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();
		//delete
		if ( ( isset( $in['type'] ) && $in['type'] == 'delete' ) || ( isset( $in['delete'] ) && $in['delete'] ) ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$item_deleted = $item_undeleted = 0;
				foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'user_group',
					];
					if ( isset( $in['type'] ) ) {
						$where = [
							'user_group_group_id' => $id,
							'user_group_user_account_id' => $in['id_user'],
						];
					} else {
						$where = [
							'user_group_id' => $id
						];
					}
					$params_check['where'] = $where;
					$check = get_data( $params_check );
					if ( $check ) {
						$user_group_id = ( ( isset( $in['type'] ) ) ? $check->row('user_group_id') : $id );
						delete_data('user_group', 'user_group_id', $user_group_id);
						$item_deleted++;
					} else {
						$item_undeleted++;
					}
				}
				$arr_output['status'] = 200;
				$arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
			} else {
				$arr_output['status'] = 400;
				$arr_output['message'] = 'Anda belum memilih data.';
			}
		}

		if ( isset( $in['type'] ) && $in['type'] == 'add' ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$item_success = $item_unsuccess = 0;
				foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'user_group',
						'where' => [
							'user_group_group_id' => $id,
							'user_group_user_account_id' => $in['id_user']
						]
					];
					$check = get_data( $params_check );
					if ( $check->num_rows() == '0' ) {
						$params_save_user_group = [
							'user_group_user_account_id' => $in['id_user'],
							'user_group_group_id' => $id,
						];
						save_data( 'user_group', $params_save_user_group );
						$item_success++;
						$arr_output['status'] = 200;
						$arr_output['message'] = 'Data berhasil disimpan.';
					} else {
						$item_unsuccess++;
						$arr_output['status'] = 400;
						$arr_output['message'] = 'Data Sudah Ada.';
					}
				}
			} else {
				$arr_output['status'] = 400;
				$arr_output['message'] = 'Anda belum memilih data.';
			}
		}

		echo json_encode( $arr_output );
	}

	function get_show_user_location( $user_id = null ) {
		$input = $this->input->post();
		$params = [
			'table' => [
				'dbo.user_location' => '',
				'dbo.ref_locations' => 'user_location_location_id = location_id'
			],
			'select' => 'user_location_id, user_location_location_id, province_name, regency_name, district_name, village_name',
			'where' => [
				'user_location_user_account_id' => $user_id,
			],
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
		];
		$query = get_data( $params );
		$params_count = [
			'table' => [
				'dbo.user_location' => '',
				'dbo.ref_locations' => 'user_location_location_id = location_id'
			],
			'select' => 'count(user_location_id) jumlah',
			'where' => [
				'user_location_user_account_id' => $user_id,
			],
		];
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$row_data = [
				'id' => $row->user_location_id,
				'cell' => [
					'user_location_location_id' => $row->user_location_location_id,
					'province_name' => $row->province_name,
					'regency_name' => $row->regency_name,
					'district_name' => $row->district_name,
					'village_name' => $row->village_name,
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

	function get_show_user_group( $user_id = null ) {
		$input = $this->input->post();
		$params = [
			'table' => [
				'dbo.user_group a' => '',
				'dbo.core_user_group b' => 'a.user_group_group_id = b.user_group_id'
			],
			'select' => 'a.user_group_id, a.user_group_group_id, b.user_group_title',
			'where' => [
				'a.user_group_user_account_id' => $user_id,
			],
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
		];
		$query = get_data( $params );
		$params_count = [
			'table' => [
				'dbo.user_group a' => '',
				'dbo.core_user_group b' => 'a.user_group_group_id = b.user_group_id'
			],
			'select' => 'count(a.user_group_id) jumlah',
			'where' => [
				'user_group_user_account_id' => $user_id,
			],
		];
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$row_data = [
				'id' => $row->user_group_id,
				'cell' => [
					'user_group_group_id' => $row->user_group_group_id,
					'user_group_title' => $row->user_group_title,
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

	function my_user_location()
	{
		$post = $this->input->post();
		$result = [];
		if ($post) {
			$cek = $this->db->get_where('dbo.user_location', [
				'user_location_user_account_id' => (int)$post['user'],
				'user_location_location_id' => $post['id'],
			])->num_rows();

			if ($cek > 0) {
				$result = [
					'status' => false,
					'msg' => 'Lokasi sudah diinputkan.'
				];
			} else {
				$save = [
					'user_location_user_account_id' => $post['user'],
					'user_location_location_id' => $post['id'],
				];
				$insert = $this->db->insert('dbo.user_location', $save);
				if ($insert) {
					$result = [
						'status' => true,
						'msg' => 'Lokasi berhasil Disimpan.',
					];
				} else {
					$result = [
						'status' => false,
						'msg' => 'Lokasi gagal disimpan.'
					];
				}
			}
		}

		echo json_encode($result);
	}

	function save_show_user_location(){
		$inp = $this->input->post();
		$jml_suc = $jml_fail = 0;
		// $inp['id_user'] = '';
		// $inp['id_loc']  = '' ;
		// $inp['id_val'] = '';
		// dump($inp);
		
		// CHECK DATA

		$querytext = "
								WITH CTE_TableName AS (
       
									select c.level ,cast(c.location_id as varchar(100)) location_id
															 from core_user_profile a
																  left JOIN user_location b on a.user_profile_id = b.user_location_user_account_id
																  left JOIN ref_locations c on b.user_location_location_id = c.location_id
																  where a.user_profile_id = '" . $inp['id_user'] . "' and c.location_id = " . $inp['id_loc'] . "
															group by c.level ,c.location_id
															
							 
									
														)
												SELECT t0.level
													, STUFF((
														SELECT ',' + t1.location_id
														FROM CTE_TableName t1
														WHERE t1.level = t0.level
														ORDER BY t1.location_id
														FOR XML PATH('')), 1, LEN(','), '') AS location_id
												FROM CTE_TableName t0
												GROUP BY t0.level
												ORDER BY level;
								";


		// $querytext = "select c.level level,string_agg(c.location_id,',') as location_id
		// 						from core_user_profile a
		// 							 left JOIN user_location b on a.user_profile_id = b.user_location_user_account_id
		// 							 left JOIN ref_locations c on b.user_location_location_id = c.location_id
		// 					   where a.user_profile_id = '" . $inp['id_user'] . "' and c.location_id = " . $inp['id_loc'] . "
		// 					   group by level
		// 					   order by level";

		$query = $this->db->query($querytext);

		$params_save_user_location = [
			'user_location_user_account_id' => $inp['id_user'],
			'user_location_location_id' => $inp['id_loc']
			];	
		if ($query->num_rows() == 0)			{
			if ($inp['id_val'] == 1) {
				save_data( 'user_location', $params_save_user_location );
				echo json_encode(
									[
										'status' => 200,
										'msg' => 'Data berhasil disimpan!'
									]
								);

			}
		}else {
			if ($inp['id_val'] == 0) {
				delete_data( 'user_location', $params_save_user_location );
				echo json_encode(
									[
										'status' => 200,
										'msg' => 'Data berhasil didelete!'
									]
								);
			}elseif ($inp['id_val'] == 1) {
				echo json_encode(
									[
										'status' => 200,
										'msg' => 'Data sudah tersimpan!'
									]
								);

			}
		}
		// dump($query->num_rows());

	

		// ISI DATA
		// $querytext = "INSERT INTO user_location (user_location_user_account_id, user_location_location_id) VALUES ($inp['id_user'], $inp['id_loc'])"
		// $query_propinsi = $this->db->query($querytext);
		

		// $params_save_user_location = [
		// 	'user_location_user_account_id' => $inp['id_user'],
		// 	'user_location_location_id' => $id
		// ];
		// save_data( 'user_location', $params_save_user_location );


		
		// if ( is_array( $inp['id_loc'] ) ) {
		// 	foreach ( $inp['id_loc'] as $id ) {
		// 		$params_cek = [
		// 			'table' => 'user_location',
		// 			'select' => 'user_location_id',
		// 			'where' => [
		// 				'user_location_user_account_id' => $inp['id_user'],
		// 				'user_location_location_id' => $id,
		// 			],
		// 		];
		// 		$query = get_data( $params_cek );
		// 		if ( $query->num_rows() == 0 ) {
		// 			$params_save_user_location = [
		// 				'user_location_user_account_id' => $inp['id_user'],
		// 				'user_location_location_id' => $id
		// 			];

					
		// 			save_data( 'user_location', $params_save_user_location );


		// 			$jml_suc++;
		// 		} else {
		// 			$jml_fail++;
		// 		}
		// 	}

		// 	echo json_encode( [
		// 			'status' => 200,
		// 			'msg' => $jml_suc . ' Data Berhasil Disimpan.' . $jml_fail . ' Data Gagal Disimpan.',
		// 		]
		// 	);
		// } else {
		// 	$params_cek = [
		// 		'table' => 'user_location',
		// 		'select' => 'user_location_id',
		// 		'where' => [
		// 			'user_location_user_account_id' => $inp['id_user'],
		// 			'user_location_location_id' => $inp['id_loc'],
		// 		],
		// 	];		

		// 	$cek_bps = [
		// 		'table' => 'ref_locations',
		// 		'select' => 'bps_province_code',
		// 		'where' => [
		// 			'location_id' => $inp['id_loc']
		// 		],
		// 	];

		// 	$hasil_bps = get_data( $cek_bps )->row('bps_province_code');
			
		// 	$cek_prelist_m = [
		// 		'table' => [
		// 			'asset.master_data_proses md' => '',
		// 			'dbo.ref_locations loc' => 'md.location_id = loc.location_id'
		// 		],
		// 		'select' => 'count(md.proses_id) jml',
		// 		'where' => [
		// 			'md.kode_propinsi' => $hasil_bps
		// 		],
		// 	];

		// 	$cek_prelist_p = [
		// 		'table' => [
		// 			'asset.master_data_proses mdp' => '',
		// 			'dbo.ref_locations loc' => 'mdp.location_id = loc.location_id'
		// 		],
		// 		'select' => 'count(mdp.proses_id) jml',
		// 		'where' => [
		// 			'mdp.kode_propinsi' => $hasil_bps
		// 		],
		// 	];

		// 	$query = get_data( $params_cek );
		// 	$jml_md = get_data( $cek_prelist_m )->row( 'jml' );
		// 	$jml_mdp = get_data( $cek_prelist_p )->row( 'jml' );
		// 	if ( $query->num_rows() == 0 ) {
		// 		if ( $jml_md > 0 || $jml_mdp > 0) {
		// 			$params_save_user_location = [
		// 				'user_location_user_account_id' => $inp['id_user'],
		// 				'user_location_location_id' => $inp['id_loc'],
		// 			];

		// 			if ($inp['id_loc'] == '100000') {
		// 				echo json_encode(
		// 						[
		// 							'status' => 500,
		// 							'msg' => 'Tidak dapat memasukan Negara.',
		// 						]
		// 					);
		// 			}

		// 			if ($inp['id_loc'] != '100000') {
		// 				save_data( 'user_location', $params_save_user_location );
		// 				echo json_encode(
		// 					[
		// 						'status' => 200,
		// 						'msg' => 'Data Berhasil Disimpan.',
		// 					]
		// 				);
		// 			}
		// 		}
		// 		else {
		// 			echo json_encode(
		// 				[
		// 					'status' => 500,
		// 					'msg' => 'Lokasi tidak valid atau Prelist tidak ditemukan.',
		// 				]
		// 			);
		// 		}
		// 	} else {
		// 		echo json_encode(
		// 			[
		// 				'status' => 500,
		// 				'msg' => 'Data Sudah Ada.',
		// 			]
		// 		);
		// 	}
		// }
	}

	function remove_user_location() {
		$inp = $this->input->post();
		$jml_suc = $jml_fail = 0;
		foreach ( $inp['id_loc'] as $id ) {
			$params_cek = [
				'table' => 'user_location',
				'select' => 'user_location_id',
				'where' => [
					'user_location_user_account_id' => $inp['id_user'],
					'user_location_location_id' => $id,
				],
			];
			$query = get_data( $params_cek );
			if ( $query->num_rows() > 0 ) {
				delete_data( 'user_location', 'user_location_id', $query->row( 'user_location_id' ) );
				$jml_suc++;
			} else {
				$jml_fail++;
			}
		}
		echo json_encode( [
				'status' => 200,
				'msg' => $jml_suc . ' Data Berhasil Dihapus !. ' . $jml_fail . ' Data Gagal Dihapus !',
			]
		);
	}

	function get_user_database( $id_user ){
		$params_user = [
			'table' => [
				'dbo.files_db' => ''
			],
			'where' => [
				'owner_id' => $id_user
			]
		];
		$query_user = get_data( $params_user );
		return $query_user->result();
	}
	function get_user_information( $id_user ){
		$params_user = [
			'table' => [
				'core_user_account' => '',
				'core_user_profile' => 'user_account_id = user_profile_id',
			],
			'where' => [
				'user_account_id' => $id_user
			]
		];
		$query_user = get_data( $params_user );
		return $query_user->row();
	}

	function act_fetch_database() {
		$this->load->library( 'encryption' );
		$in = $this->input->post();
		$params_user_file = [
			'table' => 'dbo.files_db',
			'where' => [
				'owner_id' => $in['user_id'],
				'row_status' => 'ACTIVE'
			],
		];

		$query_user_file = get_data( $params_user_file );
		if ( $query_user_file->num_rows() == 0 ) {
			$params_file = [
			'owner_id' => $in['user_id'],
			'row_status' => 'ACTIVE',
			'created_by' => $this->user_info['user_id'],
			'created_on' => date( "Y-m-d H:i:s"),
			];
			if ( save_data( 'dbo.files_db', $params_file ) ){
				echo json_encode(
					[
						'status' => 200,
						'message' => ' Request fetch db berhasil di masukan',
					]
				);
			} else {
				echo json_encode(
					[
						'status' => 400,
						'message' => ' Request fetch db gagal !.',
					]
				);
			}
		}
		else
		{
			echo json_encode(
					[
						'status' => 400,
						'message' => ' Masih ada requset fetch yang belum selesai',
					]
				);
		}

	}

	function act_detail_save_account() {
		$this->load->library( 'encryption' );
		$in = $this->input->post();
		$params_edit_account = [
			'user_account_email' => $in['user_email'],
			'user_account_password' => $this->encryption->encrypt( $in['user_password'] ),
			'user_account_is_active' => $in['user_is_active']
		];
		if ( save_data( 'core_user_account', $params_edit_account, ['user_account_id' => $in['user_id']] ) ){
			echo json_encode(
				[
					'status' => 200,
					'message' => ' Data Berhasil Diubah.',
				]
			);
		} else {
			echo json_encode(
				[
					'status' => 400,
					'message' => ' Data Gagal Diubah.',
				]
			);
		}
	}

	function act_detail_save_account_properties() {
		$in = $this->input->post();
		$status = false;
		if ( ! empty( $in['nik'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $in['nik'] ) ) {
				if ( strlen( $in['nik'] ) != 16 ) {
					die(
						json_encode(
							[
								'status' => 400,
								'message' => 'Panjang Isian nik harus 16 karakter !.',
							]
						)
					);
				} else {
					$status = true;
				}
			} else {
				die(
					json_encode(
						[
							'status' => 400,
							'message' => 'Isian nik harus diisi dengan karakter numerik !',
						]
					)
				);
			}
		} else {
			$status = true;
		}
		if ( $status ) {
			$params_edit_profile = [
				'user_profile_first_name' => $in['first_name'],
				'user_profile_last_name' => $in['last_name'],
				'user_profile_nik' => $in['nik'],
				'user_profile_android_id' => $in['android_id']
			];
			if ( save_data( 'core_user_profile', $params_edit_profile, ['user_profile_id' => $in['user_id']] ) ){
				die(
					json_encode(
						[
							'status' => 200,
							'message' => ' Data Berhasil Diubah !.',
						]
					)
				);
			} else {
				die(
					json_encode(
						[
							'status' => 400,
							'message' => ' Data Gagal Diubah !.',
						]
					)
				);
			}
		}
	}


	function get_show_all_user(){
		$input = $this->input->post();
		$sql_where = '';

		$user_location = $this->user_info['user_location'];
		$in_location = '';
		if ( ! in_array( '100000', $user_location ) ) {
			$params = [
				'select' => 'user_account_id, user_account_username, user_profile_first_name, user_profile_last_name',
				'table' => [
					'core_user_account' => '',
					'core_user_profile' => 'user_account_id = user_profile_id',
				],
				'where' => [
					'user_account_is_active' => '1',
					'user_account_create_by' => $this->user_info['user_id']
				],
				'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
				'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
				'limit' => $input['rp'],
			];
			$query = get_data( $params );
			$params_count = [
				'table' => [
					'core_user_account' => '',
					'core_user_profile' => 'user_account_id = user_profile_id',
				],
				'select' => 'count(user_account_id) jumlah',
				'where' => [
					'user_account_is_active' => '1',
					'user_account_create_by' => $this->user_info['user_id']
				],
			];
		} else {
			$params = [
				'select' => 'user_account_id, user_account_username, user_profile_first_name, user_profile_last_name',
				'table' => [
					'core_user_account' => '',
					'core_user_profile' => 'user_account_id = user_profile_id',
				],
				'where' => [
					'user_account_is_active' => '1'
				],
				'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
				'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
				'limit' => $input['rp'],
			];
			$query = get_data( $params );
			$params_count = [
				'table' => [
					'core_user_account' => ''
				],
				'select' => 'count(user_account_id) jumlah',
				'where' => [
					'user_account_is_active' => '1',
					'user_account_create_by' => $this->user_info['user_id']
				],
			];
		}

		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$select = '<b class="subor"></b>';
			$row_data = [
				'id' => $row->user_account_id,
				'cell' => [
					'checkbox' => $select,
					'user_account_id' => $row->user_account_id,
					'user_account_username' => $row->user_account_username,
					'user_full_name' => $row->user_profile_first_name . ' ' . $row->user_profile_last_name,
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

	function get_show_subordinates( $user_id = null ){
		$input = $this->input->post();

		$params = [
			'select' => 'user_id, user_account_username, user_profile_first_name, user_profile_last_name',
			'table' => [
				'dbo.user_subordinate' => '',
				'dbo.core_user_account' => 'user_id = user_account_id',
				'dbo.core_user_profile' => 'user_id = user_profile_id',
			],
			'where' => [
				'parent_id' => $user_id
			],
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
		];
		$query = get_data( $params );
		$params_count = [
			'table' => [
				'dbo.user_subordinate' => '',
				'dbo.core_user_account' => 'user_id = user_account_id',
				'dbo.core_user_profile' => 'user_id = user_profile_id',
			],
			'select' => 'count(user_id) jumlah',
		];
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$select = '<input type="checkbox" name="is_selected" class="row-checked">';
			$row_data = [
				'id' => $row->user_id,
				'cell' => [
					'user_id' => $row->user_id,
					'user_account_username' => $row->user_account_username,
					'user_full_name' => $row->user_profile_first_name . ' ' . $row->user_profile_last_name,
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

	function get_logs_user( $user_id = null ){
		$input = $this->input->post();
		$params = [
			'select' => '*',
			'table' => [
				'asset.master_data_log' => ''
			],
			'where' => [
				'data_log_created_by' => $user_id
			],
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
		];
		$query = get_data( $params );
		$params_count = [
			'table' => [
				'asset.master_data_log' => ''
			],
			'select' => 'count(data_log_id) jumlah',
			'where' => [
				'data_log_created_by' => $user_id
			],
		];
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$select = '<input type="checkbox" name="is_selected" class="row-checked">';
			$lastupdate = date("d-m-Y H:i:s",strtotime($row->data_log_created_on));
			$row_data = [
				'id' => $row->data_log_created_by,
				'cell' => [
					'data_log_created_by' => $row->data_log_created_by,
					'data_log_created_on' => $lastupdate,
					'data_log_stereotype' => $row->data_log_stereotype,
					'data_log_row_status' => $row->data_log_row_status,
					'data_log_description' => $row->data_log_description,
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

	function get_menu(){
		$params_menu = [
			'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_class, menu_description, menu_action',
			'table' => 'core_menu',
			'where' => [
				'menu_is_active' => '1',
			],
		];
		$query_menu = get_data( $params_menu, 1 );
		$group_menu = [];
		if ( count( $query_menu ) > 1 ) {
			foreach ( $query_menu as $key => $menu ) {
				$group_menu[$menu['menu_parent_menu_id']][] = $menu;
			}
		}
		return $group_menu;
	}

	function get_data_user_group() {
		$params_user_group = [
			'table' => 'dbo.core_user_group',
			'select' => 'user_group_id, user_group_name, user_group_title',
			'where' => [
				'user_group_is_active' => '1',
				'user_group_id !=' => '1',
			],
			'order_by' => 'user_group_id'
		];

		if ($_SESSION['user_info']['user_id'] > 1) {
			foreach ($_SESSION['user_info']['user_group'] as $key => $value) {
				if ($value == 'korkab') {
					$params_user_group['where'] = ['user_group_parent_id' => 1003];
				}
				if ($value == 'korwil') {
					$params_user_group['where'] = ['user_group_parent_id' => 2];
				}
			}
		}

		$query_user_group = get_data( $params_user_group );

		$html_group = '';
		if ( $query_user_group->num_rows() > 0 ) {
			foreach ( $query_user_group->result() as $key => $group ) {
				$html_group .= "
					<div class='col-sm-12 custom-control custom-checkbox'>
						<label class='form-check-label' for='{$group->user_group_name}'>
							<input type='checkbox' class='ck form-check-input' id='{$group->user_group_name}' name='user_group_id[]' value='{$group->user_group_id}'>&nbsp;&nbsp;{$group->user_group_title}
						</label>
					</div>
				";
			}
		}
		return $html_group;
	}

	function get_data_user_device( $id_user ) {
		$params_user = [
			'table' => 'dbo.user_log',
			'where' => [
				'user_id' => $id_user
			]
		];
		$query_user = get_data( $params_user );
		return $query_user->row();
	}

	function act_reset_android_id(){
		$user_id = $this->input->post('user_id');
		$id = null;
		$response = [
			'status' => 200,
			'msg' => 'Android ID Gagal direset! ',
			'class' => 'alert alert-danger'
		];
		if ( !empty( $user_id ) ) {
			$update_android_id = [
				'table' => 'core_user_profile',
				'data' => [
					'user_profile_android_id' => ''
				],
				'where' => [
					'user_profile_id' => $user_id
				],
			];
			$id = save_data( $update_android_id );
		}
		if ( $id ) {
			$response['msg'] = 'Android ID berhasil direset!';
			$response['class'] = 'alert alert-success';
		}
		echo json_encode( $response );
	}

	function act_update_profile(){
		$in = $this->input->post();
		$response = [
			'status' => false,
			'msg' =>[],
			'class' => 'alert alert-danger'
		];
		$no_hp = '';
		$no_hp2 = '';
		$status = false;
		if ( ! empty( $in['nik'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $in['nik'] ) ) {
				if ( strlen( $in['nik'] ) != 16 ) {
					$response['msg'][] =  '<li>Panjang Isian <b>NIK</b> harus 16 karakter!</li>';
				} else {
					$status = true;
				}
			} else {
				$response['msg'][] =  '<li>Isian <b>NIK</b> harus diisi dengan karakter numerik!</li>';
			}
		} else {
			$status = true;
		}

		if ( ! empty( $in['nomor_ktp'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $in['nomor_ktp'] ) ) {
				if ( strlen( $in['nomor_ktp'] ) != 16 ) {
					$response['msg'][] =  '<li>Panjang Isian <b>Nomor KTP</b> harus 16 karakter!</li>';
				} else {
					$status = true;
				}
			} else {
				$response['msg'][] =  '<li>Isian <b>Nomor KTP</b> harus diisi dengan 16 karakter numerik!</li>';
			}
		} else {
			$status = true;
		}

		if ( ! empty( $in['no_hp'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $in['no_hp'] ) ) {
				if ( strlen( $in['no_hp'] ) >= 9 && strlen( $in['no_hp'] ) <= 13 ) {
					$status = true;
					$no_hp = "+62" . $in['no_hp'];
				} else {
					$response['msg'][] =  '<li>Panjang Isian <b>Nomor HP Utama</b> 10 - 13 karakter !</li>';
				}
			} else {
				$response['msg'][] =  '<li>Isian <b>Nomor HP Utama</b> harus karakter numerik !</li>';
			}
		} else {
			$status = true;
		}
		if ( ! empty( $in['no_hp2'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $in['no_hp2'] ) ) {
				if ( strlen( $in['no_hp2'] ) >= 10 && strlen( $in['no_hp2'] ) <= 13 ) {
					$status = true;
					$no_hp2 = "+62" . $in['no_hp2'];
				} else {
					$response['msg'][] =  '<li>Panjang Isian <b>Nomor HP Alternatif</b> 10 - 13 karakter !</li>';
				}
			} else {
				$response['msg'][] =  '<li>Isian <b>Nomor HP Alternatif</b> harus karakter numerik !</li>';
			}
		} else {
			$status = true;
		}
		if ( $status ) {
			$id = null;
			if ( ! empty( $in['user_id'] ) ) {
				$upload_foto = $this->act_upload_foto( $in['user_id'] );
				$update_profile = [
					'table' => 'core_user_profile',
					'data' => [
						'user_profile_first_name' => $in['first_name'],
						'user_profile_last_name' => $in['last_name'],
						'user_profile_born_date' => $in['tanggal_lahir'],
						'user_profile_born_place' => $in['tempat_lahir'],
						'user_profile_sex' => ( isset( $in['sex'] ) ? $in['sex'] : '' ),
						'user_profile_address' => $in['address'],
						'user_profile_nik' => $in['nik'],
						'user_profile_nip' => $in['nip'],
						'user_profile_sub_regional' => $in['sub_regional'],
						'user_profile_nomor_ktp' => $in['nomor_ktp'],
						'user_profile_email_alternatif' => $in['email_alternatif'],
						'user_profile_no_hp' => $no_hp,
						'user_profile_no_hp2' => $no_hp2,
						'user_profile_android_id' => $in['android_id'],
						'user_profile_tgl_kontrak' => $in['tanggal_kontrak'],
					],
					'where' => [
						'user_profile_id' => $in['user_id']
					],
				];
				if ( $upload_foto['status'] === true ) {
					$update_profile['data']['user_profile_image'] = $upload_foto['data']['name'];
				} else if ( $upload_foto['status'] === 'no_image' ) {
					$update_profile['data']['user_profile_image'] = $upload_foto['data']['name'];
				} else {
					$response['msg'][] = 'Foto gagal di upload!';
				}
				$id = save_data( $update_profile );
				$response['msg'][] = 'Profile berhasil diupdate!';
				if ( $id ) {
					$response['status'] = true;
					$response['msg'][] = 'Profile berhasil diupdate!';
					$response['class'] = 'alert alert-success';
				}
			}
		}
		echo json_encode( $response );
	}

	function act_upload_foto( $user_id ) {
		$res = [
			'status' => false,
			'data' => null,
		];
		$upload_image = $_FILES['image']['name'];
		$old_image = $this->db->get_where('dbo.core_user_profile', ['user_profile_id' => $user_id])->row('user_profile_image');
		if ($upload_image != '') {
			$config['upload_path'] = './assets/uploads/images/users/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1024';
			// $config['file_name'] = $user_id;
			$this->load->library( 'upload', $config );
			// $this->upload->overwrite = true;
			if ( ! $this->upload->do_upload('image')) {
				$res['data'] = $this->upload->display_errors();
			} else {
				if (($old_image !== null) || ($old_image !== 'default')) {
					unlink(FCPATH . 'assets/uploads/images/users/' . $old_image);
				}
				$uploadedImage = $this->upload->data('file_name');
				// $uploadedImage['resize'] = $this->resizeImage( $uploadedImage );
				$res['status'] = true;
				$res['data']['name'] = $uploadedImage;
			}
		} else {
			$res['status'] = 'no_image';
			$res['data']['name'] = $old_image;
		}
		return $res;
	}

	public function resizeImage( $filename ) {
		$status_resize = true;
		$source_path = './assets/uploads/images/users/' . $filename;
		$target_path = './assets/uploads/images/users/thumbnail/';
		$config_manip = array(
			'image_library' => 'gd2',
			'source_image' => $source_path,
			'new_image' => $target_path,
			'maintain_ratio' => TRUE,
			'width' => 150,
			'height' => 150
		);

		$this->load->library( 'image_lib', $config_manip );
		if ( ! $this->image_lib->resize() ) {
		 	$this->image_lib->display_errors();
		 	$status_resize = false;
		}
		$this->image_lib->clear();
		return $status_resize;
	}

	function act_save_user_subordinate(){
		$in = $this->input->post();
		$res = [];
		if ( ! empty( $in['id'] ) && ! empty( $in['id_user'] ) ) {
			if ( is_array( $in['id'] ) ) {
				$datetime = date( "Y-m-d H:i:s" );
				$params = [
					'table' => 'dbo.user_subordinate'
				];
				$sukses = $gagal = 0;
				foreach ( $in['id'] as $id ) {
					$params_cek = [
						'table' => 'dbo.user_subordinate',
						'where' => [
							'parent_id' => $in['id_user'],
							'user_id' => $id,
						],
						'select' => 'count(user_id) jumlah'
					];
					$jumlah = get_data( $params_cek )->row('jumlah');
					if ( $jumlah >= '1' ) {
						$gagal++;
					} else {
						$params['data'] = [
							'user_id' => $id,
							'parent_id' => $in['id_user'],
							'row_status' => 'ACTIVE',
							'created_by' => $this->user_info['user_id'],
							'created_on' => $datetime
						];
						save_data( $params );
						$sukses++;
					}
				}
				$res['status'] = 200;
				$res['msg'] =  "$sukses Data Berhasil Disimpan ! " . ( ( $gagal > '0' ) ? $gagal . " Data Gagal Disimpan !" : null ) ;;
			} else {
				$res['status'] = 500;
				$res['msg'] = ' Data Gagal Disimpan!.';
			}
		} else {
			$res['status'] = 500;
			$res['msg'] = ' Data Gagal Disimpan!.';
		}
		die( json_encode( $res ) );
	}

	function act_remove_user_subordinate(){
		$in = $this->input->post();
		$res = [];
		if ( ! empty( $in['id'] ) && ! empty( $in['id_user'] ) ) {
			if ( is_array( $in['id'] ) ) {
				$sukses = $gagal = 0;
				$datetime = date( "Y-m-d H:i:s" );
				foreach ( $in['id'] as $id ) {
					$params_cek = [
						'table' => 'dbo.user_subordinate',
						'where' => [
							'parent_id' => $in['id_user'],
							'user_id' => $id,
						],
						'select' => 'count(user_id) jumlah'
					];
					$jumlah = get_data( $params_cek )->row('jumlah');
					if ( $jumlah >= '1' ) {
						delete_data( 'dbo.user_subordinate', 'user_id', $id );
						$sukses++;
					} else {
						$gagal++;
					}
				}
				$res['status'] = 200;
				$res['msg'] = "$sukses Data Berhasil Dihapus! " . ( ( $gagal > '0' ) ? $gagal . " Data Gagal Dihapus!" : null ) ;
			} else {
				$res['status'] = 500;
				$res['msg'] = ' Data Gagal Dihapus!.';
			}
		} else {
			$res['status'] = 500;
			$res['msg'] = ' Data Gagal DiHapus!.';
		}
		die( json_encode( $res ) );
	}

	function restore_db( $par = null ) {
		$this->load->view("admin/restore_db");
	}

	public function restore_db2()
	{
		$challange = $this->input->post('challange');
		$ciphertext = $this->CaesarEncryptCTR($challange,-7,-3);
		$acode = str_split($ciphertext);
		$code4 = '';
		$code4 .= $acode[1];
		$code4 .= $acode[3];
		$code4 .= $acode[6];
		$code4 .= $acode[4];
		$nilai['hasil'] = $code4;

		$params_insert_master_data_log = [
			'data_log_master_data_id' => $this->user_info['user_id'],
			'data_log_status' => 'sukses',
			'data_log_description' => 'User ' . $this->user_info['user_id'] . ' mengenerate restore code dengan challange_code = '.$challange.'-'.$code4,
			'data_log_stereotype' => 'GENERATE-RESTORE-DB-PASSKEY',
			'data_log_row_status' => 'GENERATE-RESTORE-DB-PASSKEY',
			'data_log_created_by' => $this->user_info['user_id'],
			'data_log_created_on' => date( "Y-m-d H:i:s"),
			'data_log_lastupdate_by' => null,
			'data_log_lastupdate_on' => null,
		];
		$proses_id = save_data( 'asset.master_data_log', $params_insert_master_data_log);

		echo json_encode($nilai);
	}

	function CaesarEncryptCTR($str, $alphabet_offset = 7, $number_offset = 3) {
		$encrypted_text = "";

		$alphabet_offset = $alphabet_offset % 26;
		if ($alphabet_offset < 0)
		{
			$alphabet_offset += 26;
		}

		$number_offset = $number_offset % 10;
		if ($number_offset < 0)
		{
			$number_offset += 10;
		}

		$i = 0;
		while ($i < strlen($str))
		{
			$c = $str[$i];
			if(($c >= 'A') && ($c <= 'Z')) // upper case
			{
				if((ord($c) + $alphabet_offset) > ord("Z"))
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset - 26);
				}
				else
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset);
				}
			}
			else if(($c >= 'a') && ($c <= 'z')) // lower case
			{
				if((ord($c) + $alphabet_offset) > ord("z"))
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset - 26);
				}
				else
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset);
				}
			}
			else if(($c >= '0') && ($c <= '9')) // numeric
			{
				if((ord($c) + $number_offset) > ord("9"))
				{
					$encrypted_text .= chr(ord($c) + $number_offset - 10);
				}
				else
				{
					$encrypted_text .= chr(ord($c) + $number_offset);
				}
			}
			else
			{
				$encrypted_text .= $c;
			}
			$i++;
		}
		return $encrypted_text;
	}

	function profile_user() {
		$user_info = $_SESSION['user_info'];
	
		$sqln = "
			SELECT * FROM dbo.core_user_account ua
			JOIN dbo.core_user_profile up ON ua.user_account_id = up.user_profile_id
			WHERE user_account_id = ".$user_info['user_id']."
		";
		$get_datan = $this->db->query($sqln)->row();

		$data = array();
		$data['grid']['title'] = 'Edit Profile User';
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['datap'] = $get_datan;
		$this->template->breadcrumb( $this->breadcrumb );
		$this->template->title( $data['grid']['title'] );
		$this->template->content( "admin/profile", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function simpan_profile() {
		$in = $this->input->post();
		$params_edit_account = [
			'user_account_email' => $in['user_email']
		];
		
		$params_edit_profile = [
			'user_profile_nik' => $in['nik'],
			'user_profile_sex' => $in['gender'],
			'user_profile_born_place' => $in['tmplahir'],
			'user_profile_born_date' => $in['tgllahir'],
		];

		$akunn = save_data( 'core_user_account', $params_edit_account, ['user_account_id' => $in['user_id']] );
		$profile = save_data( 'core_user_profile', $params_edit_profile, ['user_profile_id' => $in['user_id']] );

		if ( $akunn && $profile ){
			$result['status'] = 200;
			$result['msg'][] = 'Data Berhasil Diubah.';
			$this->session->set_flashdata('msg', 'Data User Berhasil Diubah.');
		} else {
			$result['msg'][] = 'Data Gagal Diubah';
			$this->session->set_flashdata('msg', 'Data User Gagal Diubah.');
		}
	}

	function simpan_password_baru() {
		$this->load->library( 'encryption' );
		$in = $this->input->post();
		$user_info = $_SESSION['user_info'];
	
		$sqlp = "
			SELECT * FROM dbo.core_user_account ua
			WHERE ua.user_account_id = ".$user_info['user_id']."
		";
		$get_datap = $this->db->query($sqlp)->row();
		$passold   = $this->encryption->decrypt( $get_datap->user_account_password );

		if($passold == $in['kata_sandi_lama']) {
			$params_edit_account = [
				'user_account_password' => $this->encryption->encrypt( $in['kata_sandi_baru'] )
			];
			if ( save_data( 'core_user_account', $params_edit_account, ['user_account_id' => $in['user_id']] ) ){
				echo json_encode(
					[
						'status' => 200,
						'message' => 'Data Berhasil Diubah.',
					]
				);
				$this->session->set_flashdata('msg', 'Data User Berhasil Diubah.');
			} else {
				echo json_encode(
					[
						'status' => 400,
						'message' => 'Data Gagal Diubah.',
					]
				);
				$this->session->set_flashdata('msg', 'Data User Gagal Diubah.');
			}
		} else {
			echo json_encode(
				[
					'status' => 400,
					'message' => 'Password Salah.',
				]
			);
		}
	}

	function sess(){
		disp($_SESSION);
	}
}
