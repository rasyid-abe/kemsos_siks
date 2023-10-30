<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Detail_data extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'verivali/all_data/' );
	}

	function index() {
		redirect( base_url() );
	}

	function get_form_detail( $get_par = null) {
		$par = dec( $get_par );
		$proses_id = $par['proses_id'];
		$data = [];
		$params_detail = [
			'table' => 'asset.master_data_proses',
			'where' => [
				'proses_id' => $proses_id,
			],
		];
		$query_detail = get_data( $params_detail );

		$params_art = "
			SELECT md.*, mk.nokk, mk.proses_id
			FROM asset.master_data_detail_proses md 
			LEFT JOIN asset.master_data_detail_proses_kk mk 
			ON md.proses_id = mk.proses_id AND md.nuk = mk.nuk
			WHERE md.proses_id = '" . $proses_id . "'";
		$query_art = data_query( $params_art );

		$params_kk = [
			'table' => 'asset.master_data_detail_proses_kk',
			'where' => [
				'proses_id' => $proses_id
			],
		];
		$query_kk = get_data( $params_kk );

		$params_anak_tanggungan = [
			'table' => 'asset.master_data_detail_proses_tanggungan',
			'where' => [
				'proses_id' => $proses_id
			],
		];
		$query_tanggungan = get_data( $params_anak_tanggungan );

		$params_usaha = [
			'table' => 'asset.master_data_detail_proses_usaha',
			'where' => [
				'proses_id' => $proses_id
			],
		];
		$query_usaha = get_data( $params_usaha );
		
		$jml_foto = [
			'table' => 'dbo.files',
			'select' => 'count(*) as jumlah',
			'where' => [
				'owner_id' => $proses_id,
				'row_status' => 'ACTIVE',
				"files.stereotype like 'F-%'" => null,
			],
		];
		$query_jml_foto = get_data( $jml_foto );

		$jml_foto_hapus = [
			'table' => 'dbo.files',
			'select' => 'count(*) as jumlah',
			'where' => [
				'owner_id' => $proses_id,
				'row_status' => 'DELETED',
				"files.stereotype like 'F-%'" => null,
			],
		];
		$query_jml_foto_hapus = get_data( $jml_foto_hapus );

		$params_foto = [
			'select' => 'owner_id, row_status, internal_filename, file_name, stereotype, description, file_size, latitude, longitude, created_on, created_by, file_type',
			'table' => [
				'dbo.files' => '',
				
			],
			'where' => [
				'owner_id' => $proses_id,
				"files.stereotype like 'F-%'" => null,
			],
		];
		$query_foto = get_data( $params_foto );
		$data['row'] = $query_detail->row();
		$data['art'] = $query_art->result();
		$data['kk'] = $query_kk->result();
		$data['tanggungan'] = $query_tanggungan->result();
		$data['usaha'] = $query_usaha->result();
		$data['foto'] = $query_foto->result();
		$data['jml_foto'] = $query_jml_foto->row();
		$data['jml_foto_hapus'] = $query_jml_foto_hapus->row();
		$data['legend'] = $this->db->get('dbo.ref_references')->result_array();
		$data['grid']['title'] = 'Daftar Data Detail';

		// menu slug, and what action
		$data['acl_approve'] = $this->get_acl('daftar-semua-data', 'approve');

		$this->template->breadcrumb( $this->breadcrumb );

		$this->template->title( $data['grid']['title'] );
		$this->template->content( "verivali/Detail_prelist", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_form_detail_art( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$id = $params['id'];
		$data = [];
		$params_art = [
			'table' => 'asset.master_data_detail_proses',
			'where' => [
				'id' => $id
			],
		];
		$query_art = get_data( $params_art );
		$data['art'] = $query_art->row();

		$this->load->view("verivali/detail_prelist_art", $data);
	}

	function get_form_detail_kk( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$id = $params['id'];
		$data = [];
		$params_kk = [
			'table' => 'asset.master_data_detail_proses_kk',
			'where' => [
				'id' => $id
			],
		];
		$query_kk = get_data( $params_kk );
		$data['kk'] = $query_kk->row();

		$this->load->view("verivali/detail_prelist_kk", $data);
	}

	function get_form_detail_anak( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$id = $params['id'];
		$data = [];
		$params_anak = [
			'table' => 'asset.master_data_detail_proses_tanggungan',
			'where' => [
				'id' => $id
			],
		];
		$query_anak = get_data( $params_anak );
		$data['anak'] = $query_anak->row();

		$this->load->view("verivali/detail_prelist_anak", $data);
	}

	function get_form_detail_usaha( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$id = $params['id'];
		$data = [];
		$params_usaha = [
			'table' => 'asset.master_data_detail_proses_usaha',
			'where' => [
				'id' => $id
			],
		];
		$query_usaha = get_data( $params_usaha );
		$data['usaha'] = $query_usaha->row();

		$this->load->view("verivali/detail_prelist_usaha", $data);
	}

	function act_detail_save_prelist() {
		$in = $this->input->post();
		unset($in['KDPROP']);
		unset($in['KDKAB']);
		unset($in['KDKEC']);
		unset($in['KDDESA']);
		unset($in['ada_art_cacat_label']);
		$id=$in['proses_id'];

		if ( save_data( 'asset.master_data_proses', $in, ['proses_id' => $in['proses_id']] ) ){

			$this->update_trails($id,$in);
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

	function act_detail_save_kk() {
		$in = $this->input->post();
		$id=$in['id'];
		unset($in['id']);
		if ( save_data( 'asset.master_data_detail_proses_kk', $in, ['id' => $id] ) ){

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

	function act_detail_save_anak() {
		$in = $this->input->post();
		$id=$in['id'];
		unset($in['id']);
		if ( save_data( 'asset.master_data_detail_proses_tanggungan', $in, ['id' => $id] ) ){

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

	function act_detail_save_usaha() {
		$in = $this->input->post();
		$id=$in['id'];
		unset($in['id']);
		if ( save_data( 'asset.master_data_detail_proses_usaha', $in, ['id' => $id] ) ){

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

	function edit_prelist(){		
		$detail_id = $this->input->post('id');
		$proses_id = $this->input->post('proses_id');
		$flag_dokumen = $this->input->post('flag_dokumen');
		$nama = $this->input->post('nama');
		$nik = $this->input->post('nik');
		$sukses = $gagal = 0;
		
		$user_ip = client_ip();
		$upd_data = [
			'nama' => $nama,
			'nik' => $nik,
			'flag_dokumen' => $flag_dokumen,
			'lastupdate_by' => $this->user_info['user_id'],
			'lastupdate_on' => date('Y-m-d H:i:s')
		];
		
		$this->db->where('id', $detail_id);
		$update = $this->db->update('asset.master_data_detail_proses', $upd_data);

		$data_log = [];
		if ($update) {
			$sukses ++;
			$data_log['status'] = 'sukses';
		} else {
			$gagal++;
			$data_log['status'] = 'gagal';
		}

		$data_log['detail_id'] = $detail_id;
		$data_log['description'] = 'Edit data ART';
		$data_log['created_by'] = $this->user_info['user_id'];
		$data_log['created_on'] =  date('Y-m-d H:i:s');

		$in_log = $this->db->insert('asset.master_data_detail_log', $data_log);

		redirect('verivali/detail_data/get_form_detail/'. enc( ['proses_id' => $proses_id] ) );

	}

	// function act_detail_save_art() {
	// 	$in = $this->input->post();
	// 	$id = $in['id'];
	// 	unset($in['id']);
	// 	if ( save_data( 'asset.master_data_detail_proses', $in, ['id' => $id] ) ){

	// 		die(
	// 			json_encode(
	// 				[
	// 					'status' => 200,
	// 					'message' => ' Data Berhasil Diubah !.',
	// 				]
	// 			)
	// 		);
	// 	} else {
	// 		die(
	// 			json_encode(
	// 				[
	// 					'status' => 400,
	// 					'message' => ' Data Gagal Diubah !.',
	// 				]
	// 			)
	// 		);
	// 	}

	// }

	function update_trails($id,$data){
		$params_get_audit_trail = [
			'table' => 'asset.master_data_proses',
			'where' => [
				'proses_id' => $id
			],
			'select' => 'audit_trails,stereotype'
		];
		$user_ip = client_ip();
		$stereotype = get_data( $params_get_audit_trail )->row('stereotype');
		$audit_trails = get_data( $params_get_audit_trail )->row('audit_trails');
		$old_json=json_decode($audit_trails);

		$column_data['asset_id']=$id;
		$column_data['stereotype']=$stereotype;
		$column_data['properties']=$data;
		$up['ip'] = $user_ip['ip_address'];
		$up['on'] = date("Y-m-d H:i:s");
		$up['act'] ='UPDATED' ;
		$up['user_id'] =$this->user_info['user_id'];
		$up['username'] =$this->user_info['user_username'] ;
		$up['column_data'] =$column_data;
		$up['is_proxy_access'] =$user_ip['is_proxy'] ;
		$new_json[]=$up;
		if(empty($old_json))
			$res=$new_json;
		else
			$res = array_merge($new_json,$old_json);

		$update['audit_trails'] = json_encode($res);
		save_data( 'asset.master_data_proses', $update, ['proses_id' => $id] );

	}

}
