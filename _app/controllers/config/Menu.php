<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Backend_Controller {

	public function __construct() {
		parent::__construct();
        $this->json = [];
	}

	function index() {
		$this->show_grid();
	}

	function show() {
        $par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = array();
        $data['is_superuser'] = ( $this->user_info['user_group_name'] == 'root') ? TRUE : FALSE;
        $data['grid'] = [
            'col_id' => 'menu_id',
            'col_sort' => 'menu_name',
            'columns' => "
                {field:'menu_name',title:'Menu Name',width:150,sortable:\"true\",align:'left'},
                {field:'menu_slug',title:'Slug',width:150,sortable:\"true\",align:'left'},
                {field:'menu_sub',title:'Sub Menu',width:80,sortable:\"true\",align:'center'},
                {field:'menu_url',title:'URL',width:180,sortable:\"true\",align:'left'},
                {field:'menu_class',title:'Class',width:50,sortable:\"true\",align:'center'},
                {field:'menu_description',title:'Deskription', width:300,sortable:\"true\",align:'left'},
                {field:'menu_is_active',title:'Status',width:60,sortable:\"true\",align:'center'},
            ",
            'toolbar' => ['add', 'edit', 'enable', 'disable', 'order_up', 'order_down', 'remove'],
            'filter' => '[
                {field:"menu_is_active",type:"combobox",}
                ]'
       ];
       if ( empty( $par ) ) {
           $data['grid']['title'] = 'Menu';
           $data['grid']['table_title'] = 'Tabel Menu';
           $data['grid']['link_data'] = site_url("config/menu/get_data");
       } else {
           $data['grid']['link_data'] = site_url("config/menu/get_data?par=") . enc( $par['menu_id'] );
           $data['grid']['title'] = 'Sub Menu';
           $data['grid']['table_title'] = 'Tabel Sub Menu';
       }
       $this->template->breadcrumb( $this->breadcrumb );
       $this->template->header_script( '
           <link rel="stylesheet" type="text/css" href="' . base_url( 'assets/addons/easyui/themes/default/easyui.css' ) . '">
       ' );
       $this->template->footer_script( '
           <script type="text/javascript" src="' . base_url( 'assets/addons/easyui/jquery.easyui.min.js') . '"></script>
           <script type="text/javascript" src="' . base_url( 'assets/addons/easyui/datagrid-bufferview.js' ) . '"></script>
           <script type="text/javascript" src="' . base_url( 'assets/addons/easyui/datagrid-filter.js' ) . '"></script>
       ' );
        $this->template->title( 'Menu' );
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_data(){
        $par = ( isset( $_GET['par'] ) ? dec( $_GET['par'] ) : '0' ) ;
        $input = $this->input->post();
        $params = [
            'table' => 'core_menu',
            'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_slug, menu_url, menu_description, menu_class, menu_sort, menu_is_active, menu_name parent_name',
            'order_by' => $input['sort'],
            'offset' => ( ( $input['page'] - 1 ) * $input['rows'] ),
            'limit' => $input['rows'],
            'where' => ['menu_parent_menu_id' => $par],
        ];
        if ( ! empty( $input['filterRules'] ) ) {
            $filterRules = filter_json( $input['filterRules'] );
            $params = array_merge( $params, $filterRules );
        }
        $query = get_data( $params );
        $arr_menu = [];
        foreach( $query->result_array() as $menu ) {
            $arr_menu[$menu['menu_parent_menu_id']][$menu['menu_id']] = $menu;
        }
        header("Content-type: application/json");
        $data = [];
        foreach ( $query->result() as $par => $row ) {
            $is_active = '<i class=" ' . ( ( $row->menu_is_active == '0' ) ? 'mdi mdi-lightbulb' : 'mdi mdi-lightbulb-on' ) . '" style=";font-size:16px;' . ( ( $row->menu_is_active == '0' ) ? 'color:#000;' : 'color:#d6cb22;' ) . '"></i>';
            $row_data = [
                'menu_id' => $row->menu_id,
                'menu_parent_menu_id' => $row->menu_parent_menu_id,
                'menu_name' => $row->menu_name,
                'menu_sub' => '<a href="' . base_url( "config/menu/show?par=" ) . enc( ['menu_id' => $row->menu_id, 'menu_name' => $row->menu_name] ) . '"><i class="fa fa-align-right"></i><a>',
                'menu_slug' => $row->menu_slug,
                'menu_url' => $row->menu_url,
                'menu_class' => '<i class="' . $row->menu_class. '"></i>',
                'menu_description' => $row->menu_description,
                'menu_order' => $row->menu_sort,
                'menu_is_active' => $is_active,
            ];
            $data[] = $row_data;
        }
        $result = [
            'status' => 200,
            'total' => $query->num_rows(),
            'rows' => $data,
        ];
        echo json_encode( $result );
    }

    function show_grid() {
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = array();
        $data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
        $data['grid'] = [
            'col_id' => 'menu_id',
            'sort' => 'asc',
            'columns' => "
				{ name:'menu_action', display:'Action', width:60, sortable:false, align:'center', datasuorce: false},
                { name:'menu_name', display:'Menu Name', width:150, sortable:true, align:'left', datasuorce: false},
                { name:'menu_slug', display:'Slug', width:150, sortable:true, align:'left', datasuorce: false},
                { name:'menu_sub', display:'Sub Menu', width:80, sortable:false, align:'center', datasuorce: false},
                { name:'menu_url', display:'URL', width:180, sortable:true, align:'left', datasuorce: false},
                { name:'menu_class', display:'Class', width:50, sortable:true, align:'center', datasuorce: false},
                { name:'menu_description', display:'Deskription',  width:300, sortable:true, align:'left', datasuorce: false},
                { name:'menu_is_active', display:'Status', width:60, sortable:true, align:'center', datasuorce: false},
            ",
            'toolbars' => "
				{ display:'Tambah', name:'add', bclass:'add', onpress:add, urlaction:'" . base_url( 'config/menu' ) . "/get_form?par=" . enc( [ 'parent_id' => $par['menu_id'] ] ) . "' },
				{ separator: true },
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Aktifkan', name:'publish', bclass:'publish', onpress:act_show, urlaction: '" . site_url( 'config/menu/act_show' ) . "'},
				{ separator: true },
				{ display:'Non Aktifkan', name:'unpublish', bclass:'unpublish', onpress:act_show, urlaction:'" . site_url( 'config/menu/act_show' ) . "'},
				{ separator: true },
				{ display:'Up', name:'up', bclass:'sort_up', onpress:act_sort, urlaction:'" . site_url( 'config/menu/act_show' ) . "' },
				{ separator: true },
				{ display:'Down', name:'down', bclass:'sort_down', onpress:act_sort, urlaction:'" . site_url( 'backend/service/administrator_service/act_show' ) . "' },
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:act_show, urlaction:'" . site_url( 'config/menu/act_show' ) . "' },
				{ separator: true },
			",
            'filters' => "
				{ display:'Nama Menu', name:'menu_name', type:'text', isdefault: true },
				{ display:'Status', name:'menu_is_active', type:'select', option: '1:Aktif|0:Tidak Aktif' },
			",
       ];
       if ( empty( $par ) ) {
           $data['grid']['title'] = 'Menu';
           $data['grid']['table_title'] = 'Tabel Menu';
           $data['grid']['link_data'] = site_url("config/menu/get_data_grid");
       } else {
           $data['grid']['link_data'] = site_url("config/menu/get_data_grid?par=") . enc( $par['menu_id'] );
           $data['grid']['title'] = 'Sub Menu';
           $data['grid']['table_title'] = 'Tabel Sub Menu';
       }
       $this->template->breadcrumb( $this->breadcrumb );

        $this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_data_grid(){
        $par = ( isset( $_GET['par'] ) ? dec( $_GET['par'] ) : '0' ) ;
        $input = $this->input->post();
        $params = [
            'table' => 'core_menu',
            'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_slug, menu_url, menu_description, menu_class, menu_sort, menu_is_active, menu_name parent_name',
            'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
            'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
            'limit' => $input['rp'],
            'where' => ['menu_parent_menu_id' => $par],
        ];
        if ( ! empty( $input['filterRules'] ) ) {
            $filterRules = filter_json( $input['filterRules'] );
            $params = array_merge( $params, $filterRules );
        }
        $query = get_data( $params );
		$params_count = [
            'table' => 'core_menu',
            'select' => 'count(menu_id) jumlah',
			'where' => ['menu_parent_menu_id' => $par],
        ];
		$query_count = get_data( $params_count );
        header("Content-type: application/json");
        $data = [];
        foreach ( $query->result() as $par => $row ) {
            $is_active = '<i class=" ' . ( ( $row->menu_is_active == '0' ) ? 'mdi mdi-lightbulb' : 'mdi mdi-lightbulb-on' ) . '" style=";font-size:16px;' . ( ( $row->menu_is_active == '0' ) ? 'color:#000;' : 'color:#d6cb22;' ) . '"></i>';
			$edit = '<button act="' . base_url( 'config/menu' ) . '/get_form?par=' . enc( [ 'parent_id' => $row->menu_parent_menu_id, 'menu_id' => $row->menu_id ] ) . '" class="btn btn-warning btn-sm btn-edit" title="Edit"><i class="fa fa-edit"></i></button>';
            $row_data = [
				'id' => $row->menu_id,
				'cell' => [
					'menu_action' => $edit,
	                'menu_parent_menu_id' => $row->menu_parent_menu_id,
	                'menu_name' => $row->menu_name,
	                'menu_sub' => '<a href="' . base_url( "config/menu/show_grid?par=" ) . enc( ['menu_id' => $row->menu_id, 'menu_name' => $row->menu_name] ) . '"><i class="fa fa-align-right"></i><a>',
	                'menu_slug' => $row->menu_slug,
	                'menu_url' => $row->menu_url,
	                'menu_class' => '<i class="' . $row->menu_class. '"></i>',
	                'menu_description' => $row->menu_description,
	                'menu_order' => $row->menu_sort,
	                'menu_is_active' => $is_active,
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
						'table' => 'core_menu',
						'where' => [
							'menu_id' => $id
						]
					];
					$check = get_data( $params_check );
                    if ( $check ) {
                        delete_data('core_menu', 'menu_id', $id);
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
						'table' => 'core_menu',
						'data' => [
							'menu_is_active' => '1',
						],
						'where' => [
							'menu_id' => $id
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
						'table' => 'core_menu',
						'data' => [
							'menu_is_active' => '0',
						],
						'where' => [
							'menu_id' => $id
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
		if ( ( isset( $par['menu_id'] ) ) && ! empty( $par['menu_id'] ) ) {
			$data['form_title'] = "Edit Menu";
			$data['form_action'] = base_url( 'config/menu' . '/act_edit' );
			$params_detail = [
				'select' => 'menu_name, menu_url, menu_class, menu_action, menu_description',
				'table' => 'core_menu',
				'where' => [
					'menu_id' => $par['menu_id'],
				],
			];
			$query = get_data( $params_detail );
			$row = $query->row();
		} else {
			$data['form_title'] = "Tambah Menu";
			$data['form_action'] = base_url( 'config/menu' . '/act_save' );
			$row = [];
		}
		$params_parent = [
			'select' => 'menu_name',
			'table' => 'core_menu',
			'where' => ['menu_id' => $par['parent_id']],
		];
		$query_parent = get_data( $params_parent );
		$params_action = [
			'table' => 'core_menu_action',
			'sort_by' => 'core_menu_id'
		];
		$query_action = get_data( $params_action );
		$disp_menu_action = '';
		$jumlah_action = $query_action->num_rows();
		$jumlah_per_row = ceil( $jumlah_action / 3 );
		foreach ( $query_action->result() as $key => $value ) {
			$disp_menu_action .= '
			<div class="col-4">
				<div class="custom-control custom-checkbox">
					<input name="menu_action[]" class="custom-control-input" type="checkbox" id="customCheckbox_' . ( $value->menu_action_id ) . '" value="' . $value->menu_action_name . '"  ' . ( ( $value->menu_action_name == 'show' ) ? 'checked disabled' : '' ) . '>
					<label for="customCheckbox_' . ( $value->menu_action_id ) . '" class="custom-control-label">' . $value->menu_action_title . '</label>
				</div>
			</div>';
		}
        $data['form_data'] = '
            <div class="row col-12">
				<div class="col-12">
					<label class="col-6">Menu Parent</label>
					<div class="col-6 form-group">
						<input type="text" class="form-control" value="' . $query_parent->row('menu_name') . '" readonly>
					</div>
				</div>
                <div class="col-md-6">
                    <label class="col-12">Menu Name</label>
                    <div class="col-12 form-group">
						<input type="hidden" name="parent_menu" value="' . ( ( ( isset( $par['parent_id'] ) ) && ! empty( $par['parent_id'] ) ) ? $par['parent_id'] : "0" ) . '">
						<input type="hidden" name="menu_id" value="' . ( ( ( isset( $par['menu_id'] ) ) && ! empty( $par['menu_id'] ) ) ? $par['menu_id'] : "0" ) . '">
                        <input class="form-control" name="menu_name" value="' . ( ( empty( $row ) ) ? '' : $row->menu_name ) . '" required >
                    </div>
                    <label class="col-12">Menu Class Icon</label>
                    <div class="col-12 form-group">
                        <input class="form-control" name="menu_class" value="' . ( ( empty( $row ) ) ? '' : $row->menu_class ) . '" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="col-12">Menu url</label>
                    <div class="col-12 form-group">
                        <input class="form-control" name="menu_url" value="' . ( ( empty( $row ) ) ? '' : $row->menu_url ) . '" required>
                    </div>
                    <label class="col-12">Menu Description</label>
                    <div class="col-12 form-group">
                        <textarea class="form-control" name="menu_description">' . ( ( empty( $row ) ) ? '' : $row->menu_description ) . '</textarea>
                    </div>
                </div>
				<div class="col-12">
					<label class="col-6">Action :</label>
					<div class="row col-12">' .
						$disp_menu_action . '
					</div>
				</div>
            </div>
        ';
		$this->load->view("general/Form_view", $data);
    }

	function act_save(){
		$input = $this->input->post();
		$sql = "
			SELECT max(menu_sort) max_sort
			FROM core_menu
			WHERE menu_parent_menu_id = '" . $input['parent_menu'] . "'
		";
		$query = data_query( $sql );
		$last_sort = $query->row( 'max_sort' );
        $menu_action = ( ( ! empty( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'menu_parent_menu_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_url' => $input['menu_url'],
			'menu_description' => $input['menu_description'],
			'menu_class' => $input['menu_class'],
			'menu_action' => json_encode( array_merge( ['show'], $menu_action ) ),
			'menu_sort' => $last_sort + 1,
			'menu_is_active' => '1',
		];
		$menu_id = save_data( 'core_menu', $data_save );
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

	function act_edit(){
		$input = $this->input->post();
		$arr_input_menu_action = ( ( isset( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'menu_parent_menu_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_url' => $input['menu_url'],
			'menu_description' => $input['menu_description'],
			'menu_class' => $input['menu_class'],
			'menu_action' => json_encode( array_merge( ['show'], $arr_input_menu_action ) ),
		];
		$menu_id = save_data( 'core_menu', $data_save, [ 'menu_id' => $input['menu_id'] ] );
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
}
