<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_group extends Backend_Controller {

	public function __construct() {
		parent::__construct();
        $this->json = [];
	}

	function index() {
		$this->show();
	}

	function show() {
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = array();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
        $data['grid'] = [
            'col_id' => 'user_group_id',
            'sort' => 'asc',
            'columns' => "
				{ name:'action', display:'Action', width:60, sortable:false, align:'center', datasuorce: false},
                { name:'user_group_name', display:'Group Name', width:150, sortable:true, align:'left', datasuorce: false},
                { name:'user_group_description', display:'Description', width:150, sortable:true, align:'left', datasuorce: false},
                { name:'user_group_is_active', display:'Status', width:60, sortable:true, align:'center', datasuorce: false},
            ",
            'toolbars' => "
				{ display:'Tambah', name:'add', bclass:'add', onpress:add, urlaction:'" . base_url( 'config/user_group' ) . "/get_form?par=" . enc( [ 'parent_id' => $par['menu_id'] ] ) . "' },
				{ separator: true },
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Aktifkan', name:'publish', bclass:'publish', onpress:act_show, urlaction: '" . base_url( 'config/user_group' ) . "/act_show'},
				{ separator: true },
				{ display:'Non Aktifkan', name:'unpublish', bclass:'unpublish', onpress:act_show, urlaction:'" . base_url( 'config/user_group' ) . "/act_show'},
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:act_show, urlaction:'" . base_url( 'config/user_group' ) . "/act_show' },
				{ separator: true },
			",
            'filters' => "
				{ display:'Nama Menu', name:'menu_name', type:'text', isdefault: true },
				{ display:'Status', name:'menu_is_active', type:'select', option: '1:Aktif|0:Tidak Aktif' },
			",
		];
		$data['grid']['title'] = 'User Group';
		$data['grid']['link_data'] =  base_url( 'config/user_group' ) . "/get_data";
		$this->template->breadcrumb( $this->breadcrumb );

        $this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_data(){
        $par = ( isset( $_GET['par'] ) ? dec( $_GET['par'] ) : '0' ) ;
        $input = $this->input->post();
        $params = [
            'table' => 'core_user_group',
            'select' => 'user_group_id, user_group_name, user_group_title, user_group_description, user_group_is_active',
            'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
            'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
            'limit' => $input['rp'],
        ];
        $query = get_data( $params );
		$params_count = [
            'table' => 'core_user_group',
            'select' => 'count(user_group_id) jumlah',
        ];
		$query_count = get_data( $params_count );
        header("Content-type: application/json");
        $data = [];
        foreach ( $query->result() as $par => $row ) {
            $is_active = '<i class=" ' . ( ( $row->user_group_is_active == '0' ) ? 'mdi mdi-lightbulb' : 'mdi mdi-lightbulb-on' ) . '" style=";font-size:16px;' . ( ( $row->user_group_is_active == '0' ) ? 'color:#000;' : 'color:#d6cb22;' ) . '"></i>';
			$edit = '<button act="' . base_url( 'config/user_group' ) . '/get_form?par=' . enc( [ 'user_group_id' => $row->user_group_id ] ) . '" class="btn btn-warning btn-sm btn-edit" title="Edit"><i class="fa fa-edit"></i></button>';
            $row_data = [
				'id' => $row->user_group_id,
				'cell' => [
					'action' => $edit,
	                'user_group_title' => $row->user_group_title,
	                'user_group_name' => $row->user_group_name,
	                'user_group_description' => $row->user_group_description,
	                'user_group_is_active' => $is_active,
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
        //delete
        if ( isset( $in['delete'] ) && $in['delete'] ) {
            $arr_id = json_decode( $in['item'] );
            if ( is_array( $arr_id ) ) {
                $item_deleted = $item_undeleted = 0;
                foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'core_user_group',
						'where' => [
							'user_group_id' => $id
						]
					];
					$check = get_data( $params_check );
                    if ( $check ) {
                        delete_data( 'core_user_group', 'user_group_id', $id );
                        delete_data( 'core_user_role', 'user_role_user_group_id', $id );
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
						'table' => 'core_user_group',
						'data' => [
							'user_group_is_active' => '1',
						],
						'where' => [
							'user_group_id' => $id
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
						'table' => 'core_user_group',
						'data' => [
							'user_group_is_active' => '0',
						],
						'where' => [
							'user_group_id' => $id
						]
					];
                    save_data( $params );
                    $success++;
                }
                $arr_output['message'] = $success . ' data bank berhasil dinonaktifkan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        echo json_encode( $arr_output );
	}

    function get_form(){
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
        $data = [];
		if ( ( isset( $par['user_group_id'] ) ) && ! empty( $par['user_group_id'] ) ) {
			$data['form_title'] = "Edit User Menu";
			$data['form_action'] = base_url( 'config/user_group' . '/act_edit' );
			$params_detail = [
				'select' => 'user_group_id, user_group_title, user_group_description, user_group_parent_id',
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
			$data['form_title'] = "Tambah User Group";
			$data['form_action'] = base_url( 'config/user_group' . '/act_save' );
			$row = [];
			$data_menu = [];
		}

		$disp_menu = $this->grouping_menu( [ 'data_menu' => $data_menu ] );
		$data['extra_style'] = '
            <style>
                .ul-menu {list-style-type: none; margin: 0; padding: 0 0 0 25px; display: none; }
                .li-menu {cursor: pointer; -webkit-user-select: none; /* Safari 3.1+ */ -moz-user-select: none; /* Firefox 2+ */ -ms-user-select: none; /* IE 10+ */ user-select: none; font-size: 23px; padding-right: 10px; display: block; }
                .label-menu {font-family: sans-serif;}
                .label-action {font-family: sans-serif;}
                .custom-control-label:before{top:10px !important;}
                .custom-control-label:after{top:20px !important;}
            </style>
        ';

        $data['extra_script'] = '
            <script>
            	$(document).ready( function(){
            		$(".menu-label").on( "click", function(){
            			let id_el = $(this).attr("id");
            			id_el = id_el.split("_");
            			if ( $(this).hasClass("action-active") ) {
            				console.log("active");
            				$(this).removeClass("action-active");
            				$("div.action-" + id_el[1]).hide();
            				$("div.action-" + id_el[1]).children("input").removeAttr("checked");
            			} else {
            				console.log("non-active");
            				$(this).addClass("action-active");
            				$("div.action-" + id_el[1]).show();
            				$("div.action-" + id_el[1]).children("input").attr("checked", "true");
            			}
            		});
            	});
            </script>
        ';

		$option_parent = '<option value="0">Pilih Parent Group</option>';

		$params_parent = [
			'table' => 'dbo.core_user_group',
			'select' => 'user_group_id, user_group_title',
		];

		$query_parent = get_data( $params_parent );
		foreach ( $query_parent->result() as $key => $value ) {
			if (!empty($row)) {
				$selected = '';
				if ($row->user_group_parent_id == $value->user_group_id) {
					$selected = "selected";
				}
				$option_parent .= '<option value="' . $value->user_group_id . '" '.$selected.'>' . $value->user_group_title . '</option>';
			} else {
				$option_parent .= '<option value="' . $value->user_group_id . '">' . $value->user_group_title . '</option>';
			}
		}

        $data['form_data'] = '
            <div class="row col-12">
                <div class="col-md-6">
                    <label class="col-12">Group Title</label>
                    <div class="col-12 form-group">
						<input type="hidden" name="user_group_id" value="' . ( ( ( isset( $par['user_group_id'] ) ) && ! empty( $par['user_group_id'] ) ) ? $par['user_group_id'] : "0" ) . '">
                        <input class="form-control" name="user_group_title" value="' . ( ( empty( $row ) ) ? '' : $row->user_group_title ) . '" required >
                    </div>
				</div>
                <div class="col-md-6">
                    <label class="col-12">Group Parent</label>
                    <div class="col-12 form-group">
						<select id="select-parent" name="user_group_parent_id" class="form-control">
							' . $option_parent . '
						</select>
                    </div>
				</div>
				<div class="col-md-12">
                    <label class="col-12">User Group Description</label>
                    <div class="col-12 form-group">
                        <textarea class="form-control" name="user_group_description">' . ( ( empty( $row ) ) ? '' : $row->user_group_description ) . '</textarea>
                    </div>
                </div>
			</div>
			<div class="col-12">
				<label class="col-12">Action :</label>
				<div class="row col-12 mb-3">' .
					$disp_menu . '
				</div>
            </div>
        ';
		$this->load->view("general/Form_view", $data);
    }

	function act_save(){
		$input = $this->input->post();
		$data_save = [
			'user_group_title' => $input['user_group_title'],
			'user_group_name' => url_title( $input['user_group_title'], 'dash', true ),
			'user_group_description' => $input['user_group_description'],
			'user_group_is_active' => '1',
			'user_group_parent_id' => $input['user_group_parent_id'],
		];
		$this->db->insert('core_user_group', $data_save);
   		$insert_id = $this->db->insert_id();
		if ( isset( $input['menu'] ) ){
			delete_data( 'core_user_role', 'user_role_user_group_id', $insert_id );
			$data_save_role = [];
			foreach ( $input['menu'] as $key => $menu ) {
				$data_save_role[] = [
					'user_role_user_group_id' => $insert_id,
					'user_role_menu_id' => $menu,
					'user_role_menu_action' =>  ( ( isset( $input['menu_action'][$menu] ) ) ? json_encode( $input['menu_action'][$menu] ) : null ),
				];
			}
			$insert_menu = $this->db->insert_batch( 'core_user_role', $data_save_role );
		}
		if ( $insert_id || $insert_menu ){
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

	function act_edit(){
		$input = $this->input->post();
		$arr_input_menu_action = ( ( isset( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'user_group_title' => $input['user_group_title'],
			'user_group_name' => url_title( $input['user_group_title'], 'dash', true ),
			'user_group_description' => $input['user_group_description'],
			'user_group_parent_id' => $input['user_group_parent_id'],
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

	function struktur_data_menu( $data_menu ){
		$group_menu = [];
		foreach ( $data_menu as $key => $menu ) {
			$group_menu[$menu['user_role_menu_id']] = $menu;
		}
		return $group_menu;
	}

	function grouping_menu( $params = [] ){
		$data_menu = ( ( isset( $params['data_menu'] ) ) ? $params['data_menu'] : [] );
		$arr_menu = ( ( isset( $params['add_menu'] ) ) ? $params['add_menu'] : [] );
		$parent_id = ( ( isset( $params['parent_id'] ) ) ? $params['parent_id'] : 0 );
		$disp_menu = ( ( isset( $params['disp_menu'] ) ) ? $params['disp_menu'] : '' );
		if ( empty( $arr_menu ) ) $arr_menu = $this->get_menu();
		foreach ( $arr_menu[$parent_id] as $key => $value ) {
			$have_child = array_key_exists( $value['menu_id'], $arr_menu );
			$menu_act = json_decode( $value['menu_action'] );
			$data_menu_act = ( ( ( ! empty( $data_menu[$value['menu_id']] ) ) ) ? json_decode( $data_menu[$value['menu_id']]['user_role_menu_action'] ) : [] );
			$disp_menu .= '
				<li class="li-menu custom-checkbox col-12">
					<input name="menu[]" class="custom-control-input" type="checkbox" id="menu_' . ( $value["menu_id"] ) . '" value="' . ( ( ! empty( $row ) ) ? $value['menu_id'] : $value['menu_id'] ) . '" ' . ( ( array_key_exists( $value['menu_id'], $data_menu) ) ? 'checked' : '' ) . '>
					<label id="menu_' . ( $value['menu_id'] ) . '" for="menu_' . ( $value['menu_id'] ) . '" class="menu-label custom-control-label  ' . ( ( ( ! empty( $data_menu_act ) ) && ( is_array( $menu_act ) ) ) ? 'action-active' : '' ) . '"><span class="label-menu">' . $value['menu_name'] . '</span></label>';
				$disp_menu .= '
					<div class="action action-' . $value['menu_id'] . ' col-12">';
				if ( ! $have_child ) {
					$disp_menu .= '
						<ul class="ul-action-' . $value['menu_id'] . ' row col-12">';
					if ( ( is_array( $menu_act ) ) ) {
						foreach ( $menu_act as $k => $act ) {
							$disp_menu .= '
							<div class="action-' . $value['menu_id'] . ' custom-control custom-checkbox col-4"  style="display: ' . ( ( ( ! empty( $data_menu_act ) ) && ( in_array( $act, $data_menu_act ) ) ) ? 'block' : 'none' ) . ';">
								<input name="menu_action[' . $value['menu_id'] . '][]" class="action-' . $value['menu_id'] . ' custom-control-input" type="checkbox" id="' . $value['menu_id'] . '_' . $act . '" value="' . $act . '" ' . ( ( ( ! empty( $data_menu_act ) ) && ( in_array( $act, $data_menu_act ) ) ) ? 'checked' : '' ) . '>
								<label for="' . $value['menu_id'] . '_' . $act . '" class="custom-control-label"><span ="label-action">' . $act . '</span></label>
							</div>';
						}
					}
					$disp_menu .= '
						</ul>';
				}
				$disp_menu .= '
					</div>';
			if ( $have_child ) {
				$disp_menu .= '
					<ul class="ul-menu-' . $value['menu_id'] . ' col-12">';
				$par = [
					'data_menu' => $data_menu,
					'arr_menu' => $arr_menu,
					'parent_id' => $value['menu_id'],
					'disp_menu' => $disp_menu
				];
				$disp_menu = $this->grouping_menu( $par );
				$disp_menu .= '
					</ul>
				</li>';
			}
		}
		return $disp_menu;
	}

}
