<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_action extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = 'config/menu_action';
	}

	function index() {
		$this->show();
	}

	function show() {
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = array();
		$data['is_superuser'] = ( in_array( 'root', $this->user_info['user_group'] ) ? TRUE : FALSE );
        $data['grid'] = [
            'col_id' => 'menu_action_id',
            'sort' => 'asc',
            'columns' => "
				{ name:'action', display:'Action', width:60, sortable:false, align:'center', datasuorce: false},
                { name:'menu_action_name', display:'Action Name', width:150, sortable:true, align:'left', datasuorce: false},
                { name:'menu_action_title', display:'Sction Titile', width:150, sortable:true, align:'left', datasuorce: false},
                { name:'menu_action_description', display:'Description', width:250, sortable:false, align:'left', datasuorce: false},
            ",
            'toolbars' => "
				{ display:'Tambah', name:'add', bclass:'add', onpress:add, urlaction:'" . base_url( $this->dir ) . "/get_form' },
				{ separator: true },
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:act_show, urlaction:'" . base_url( $this->dir ) . "/act_show' },
				{ separator: true },
			",
            'filters' => "
				{ display:'Action Name', name:'menu_action_name', type:'text', isdefault: true },
				{ display:'Description', name:'menu_action_description', type:'text' },
			",
       ];

		$data['grid']['title'] = 'Menu Action';
		$data['grid']['link_data'] = site_url( $this->dir ) . "/get_show_data";

		$this->template->breadcrumb( $this->breadcrumb );

        $this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data(){
        $par = ( isset( $_GET['par'] ) ? dec( $_GET['par'] ) : '0' ) ;
        $input = $this->input->post();
        $params = [
            'table' => 'core_menu_action',
            'select' => 'menu_action_id, menu_action_name, menu_action_title, menu_action_description',
            'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
            'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
            'limit' => $input['rp'],
        ];
        $query = get_data( $params );
		$params_count = [
            'table' => 'core_menu_action',
            'select' => 'count(menu_action_id) jumlah',
        ];
		$query_count = get_data( $params_count );
        header("Content-type: application/json");
        $data = [];
        foreach ( $query->result() as $par => $row ) {
			$edit = '<button act="' . base_url( $this->dir ) . '/get_form?par=' . enc( [ 'action_id' => $row->menu_action_id ] ) . '" class="btn btn-warning btn-sm btn-edit" title="Edit"><i class="fa fa-edit"></i></button>';
            $row_data = [
				'id' => $row->menu_action_id,
				'cell' => [
					'action' => $edit,
	                'menu_action_name' => $row->menu_action_name,
	                'menu_action_title' => $row->menu_action_title,
	                'menu_action_description' => $row->menu_action_description,
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
        if ( isset( $in['delete'] ) && $in['delete'] == true ) {
            $arr_id = json_decode( $in['item'] );
            if ( is_array( $arr_id ) ) {
                $item_deleted = $item_undeleted = 0;
                foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'core_menu_previlage_action',
						'where' => [
							'action_id' => $id
						]
					];
					$query = get_data( $params_check );
                    if ( $query->num_rows() ) {
                        $deleted = delete_data( 'core_menu_previlage_action', 'action_id', $id );
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
        if ( isset( $in['publish'] ) && $in['publish'] == true ) {
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
        if ( isset( $in['unpublish'] ) && $in['unpublish'] == true ) {
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
		if ( ( isset( $par['action_id'] ) ) && ! empty( $par['action_id'] ) ) {
			$data['form_title'] = "Edit Previlage Action";
			$data['form_action'] = base_url( $this->dir . '/act_edit' );
			$params_detail = [
				'table' => 'core_menu_previlage_action',
				'where' => [
					'action_id' => $par['action_id'],
				],
			];
			$query = get_data( $params_detail );
			$row = $query->row();
		} else {
			$data['form_title'] = "Tambah Previlage Action";
			$data['form_action'] = base_url( $this->dir . '/act_save' );
			$row = [];
		}

        $data['form_data'] = '
            <div class="row col-md-12">
                <div class="col-md-6">
                    <label class="col-12">Action title</label>
                    <div class="col-12 form-group">
						<input type="hidden" name="action_id" value="' . ( ( ( isset( $par['action_id'] ) ) && ! empty( $par['action_id'] ) ) ? $par['action_id'] : "0" ) . '">
                        <input class="form-control" name="action_title" value="' . ( ( empty( $row ) ) ? '' : $row->action_title ) . '" required >
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="col-12">Action Description</label>
                    <div class="col-12 form-group">
                        <textarea class="form-control" name="action_description">' . ( ( empty( $row ) ) ? '' : $row->action_description ) . '</textarea>
                    </div>
                </div>
            </div>
        ';
		$this->load->view("general/Form_view", $data);
    }

	function act_save(){
		$input = $this->input->post();
		$data_save = [
			'menu_action_name' => url_title( $input['action_title'], 'dash', true ),
			'menu_action_title' => $input['action_title'],
			'menu_action_description' => $input['action_description'],
		];
		$menu_id = save_data( 'dbo.core_menu_action', $data_save );
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
		$data_save = [
			'action_name' => url_title( $input['action_title'], 'dash', true ),
			'action_title' => $input['action_title'],
			'action_description' => $input['action_description'],
		];
		$menu_id = save_data( 'core_menu_previlage_action', $data_save, [ 'action_id' => $input['action_id'] ] );
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
