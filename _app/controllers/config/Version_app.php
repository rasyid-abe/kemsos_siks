<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version_app extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->json = [];
		$this->dir = "config/version_app/";
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		// $data['is_superuser'] = ( $this->user_info['user_group_name'] == 'root') ? TRUE : FALSE;
		$data['grid'] = [
			'col_id' => 'id_version',
			'sort' => 'asc',
			'columns' => "
				{ name:'detail', display:'Detail', width:60, sortable:false, align:'center', datasuorce: false},
				{ name:'app_version_code', display:'Code Version', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'app_version', display:'App Version', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'force_update_after', display:'Tanggal', width:150, sortable:true, align:'left', datasuorce: false},
				{ name:'description', display:'Deskripsi', width:250, sortable:true, align:'left', datasuorce: false},
			",
			'toolbars' => "
				{ display:'Tambah', name:'add', bclass:'add', onpress:add, urlaction:'" . base_url( $this->dir ) . "get_form' },
				{ separator: true },
				{ display:'Pilih Semua', name:'selectall', bclass:'selectall', onpress:check },
				{ separator: true },
				{ display:'Batalkan Pilihan', name:'selectnone', bclass:'selectnone', onpress:check },
				{ separator: true },
				{ display:'Hapus', name:'delete', bclass:'delete', onpress:act_show, urlaction:'" . base_url( $this->dir ) . "act_show' },
				{ separator: true },
			",
			'filters' => "
				{ display:'Nama Menu', name:'menu_name', type:'text', isdefault: true },
				{ display:'Status', name:'menu_is_active', type:'select', option: '1:Aktif|0:Tidak Aktif' },
			",
		];
		$data['grid']['title'] = 'Version Apps';
		$data['grid']['link_data'] =  base_url( $this->dir ) . "get_data";
		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "general/Table_grid_popup", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_data(){
		$input = $this->input->post();
		$params = [
			'table' => [
				'version_apps' => ''
			],
			'select' => '*',
			'order_by' => $input['sortname'] . ' ' . $input['sortorder'],
			'offset' => ( ( $input['page'] - 1 ) * $input['rp'] ),
			'limit' => $input['rp'],
		];
		$query = get_data( $params );
		$params_count = [
			'table' => [
				'version_apps' => ''
			],
			'select' => 'count(id_version) jumlah',
		];
		$query_count = get_data( $params_count );
		header("Content-type: application/json");
		$data = [];
		foreach ( $query->result() as $par => $row ) {
			$detail = '<button act="' . base_url( 'config/version_app' ) . '/get_form?par=' . enc( [ 'id_version' => $row->id_version ] ) . '" class="btn btn-warning btn-xs btn-edit" title="Detail" style="padding: 0.1rem 0.2rem !important;font-size: 0.5rem !important;line-height: 1.5 !important;border-radius: 2px !important;"><i class="fa fa-edit"></i></button>';
			$row_data = [
				'id' => $row->id_version,
				'cell' => [
					'id_version' => $row->id_version,
					'app_version' => $row->app_version,
					'app_version_code' => $row->app_version_code,
					'force_update_after' => $row->force_update_after,
					'description' => $row->description,
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
						'table' => 'version_apps',
						'where' => [
							'id_version' => $id
						]
					];
					$check = get_data( $params_check );
					if ( $check ) {
						delete_data( 'version_apps', 'id_version', $id );
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

	function get_form(){
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
		$data = [];
		if ( ( isset( $par['id_version'] ) ) && ! empty( $par['id_version'] ) ) {
			$data['form_title'] = "Edit User Menu";
			$data['form_action'] = base_url( $this->dir . 'act_edit' );
			$params_detail = [
				'select' => '*',
				'table' => 'version_apps',
				'where' => [
					'id_version' => $par['id_version'],
				],
			];
			$query_detail = get_data( $params_detail );
			$row = $query_detail->row();
			
		} else {
			$data['form_title'] = "Tambah Versi App";
			$data['form_action'] = base_url( $this->dir . 'act_save' );
			$row = [];
			
		}

		$data['form_data'] = '
			<ul id="msg-error" class="col-md-12"></ul>
			<div id="f_data" class="row col-12">
				<div class="col-md-12">
					<div class="row">
						<label class="col-12">Code Version</label>
						<div class="col-12 form-group">
							<input type="hidden" name="id_version" value="' . ( ( ( isset( $par['id_version'] ) ) && ! empty( $par['id_version'] ) ) ? $par['id_version'] : "0" ) . '">
							<input class="form-control" name="app_version_code" value="' . ( ( empty( $row ) ) ? '' : $row->app_version_code ) . '" required >
						</div>
					</div>
					<div class="row">
						<label class="col-12">Version</label>
						<div class="col-12 form-group">
							<div class="input-group ">
								<input id="no_hp" class="form-control" name="app_version" value="' . ( ( empty( $row ) ) ? '' : $row->app_version ) . '" required >
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-12">Sha Checksum</label>
						<div class="col-12 form-group">
							<input class="form-control" name="sha_checksum" value="' . ( ( empty( $row ) ) ? '' : $row->sha_checksum ) . '" >
						</div>
					</div>
					<div class="row">
						<label class="col-12">Description</label>
						<div class="col-12 form-group">
							<input class="form-control" name="description" value="' . ( ( empty( $row ) ) ? '' : $row->description ) . '" required >
						</div>
					</div>
				</div>
				
			</div>
			
		';
		$this->load->view("general/Form_view", $data);
	}

	function act_save(){
		$this->load->library( 'encryption' );
		$input = $this->input->post();
		
		$data_save_user_account = [
			'app_version_code' => $input['app_version_code'],
			'app_version' => $input['app_version'],
			'force_update_after' => date('Y-m-d'),
			'description' => $input['description'],
			'sha_checksum' => $input['sha_checksum'],
			
		];
		$id = save_data( 'version_apps', $data_save_user_account );
		if ( $id ){
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
			'app_version_code' => $input['app_version_code'],
			'app_version' => $input['app_version'],
			'description' => $input['description'],
			'sha_checksum' => $input['sha_checksum'],
		];
		$id = save_data( 'version_apps', $data_save, [ 'id_version' => $input['id_version'] ] );
		
		if ( $id ){
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
