<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['gallery'] = $this->db->get('asset.dokumentasi')->result_array();
		$this->template->title( 'Dokumentasi Kegiatan' );
		$this->template->content( "admin/documentation/view", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function detail($id) {
		$data = array();
		$data['gallery'] = $this->db->get_where('asset.dokumentasi', ['id' => $id])->row_array();
		$this->template->title( 'Dokumentasi Kegiatan' );
		$this->template->content( "admin/documentation/detail", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function store()
	{
		$data = array();

		$kegiatan = $this->input->post('kegiatan', true);
		$date = $this->input->post('tanggal', true);
		$root = './assets/uploads/documentation/';
		$dir = str_replace(' ', '_', $kegiatan);

		if ($_FILES['files']['name'] != NULL) {

			if (!file_exists($root . $date)) {
				mkdir($root . $date, 0777, true);
				if (!file_exists($root . $date . '/' . $dir)) {
					mkdir($root . $date . '/' . $dir, 0777, true);
				}
			}
			$path = $root . $date . '/' . $dir .'/';

			// Count total files
			$countfiles = count($_FILES['files']['name']);

			// Looping all files
			$images = [];
			for($i=0; $i<$countfiles; $i++){

				if(!empty($_FILES['files']['name'][$i])){

					// Define new $_FILES array - $_FILES['file']
					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

					// Set preference
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'jpg|jpeg|png|gif|bmp';
					$config['max_size'] = '2000'; // max_size in kb
					$config['file_name'] = $this->input->post('kegiatan', true);

					//Load upload library
					$this->load->library('upload',$config);

					// File upload

					if($this->upload->do_upload('file')){
						// Get data about the file
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						// Initialize array
						$images[] = $filename;
					} else {
						echo $this->upload->display_errors();
					}
				}

			}
			$data = [
				'nama_kegiatan' => $kegiatan,
				'lokasi_kegiatan' => $this->input->post('lokasi', true),
				'tanggal' => $date,
				'deskripsi' => $this->input->post('deskripsi', true),
				'foto' => json_encode($images),
				'input_date' => date('Y-m-d H:i:s'),
				'input_by' => $_SESSION['user_info']['user_id'],
			];

			$insert = $this->db->insert('asset.dokumentasi', $data);

			if ($insert) {
				$this->session->set_flashdata('flash', 'Data Dokumentasi <b>Berhasil</b> Ditambahkan');
	            $this->session->set_flashdata('class', 'success');
	            redirect('admin/documentation');
			} else {
				$this->session->set_flashdata('flash', 'Data Dokumentasi <b>Gagal</b> Ditambahkan');
	            $this->session->set_flashdata('class', 'warning');
	            redirect('admin/documentation');
			}
		}
	}

	function delete($id)
	{
		$data = $this->db->get_where('asset.dokumentasi', ['id' => $id])->row_array();
		$tanggal = $data['tanggal'];
		$dir = str_replace(' ', '_', $data['nama_kegiatan']);
		$root = './assets/uploads/documentation/';
		$path = $root . $tanggal . '/' . $dir .'/';

		if (! is_dir($path)) {
			throw new InvalidArgumentException("$path must be a directory");
		}
		if (substr($path, strlen($path) - 1, 1) != '/') {
			$path .= '/';
		}
		$files = glob($path . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($path);

		$delete = $this->db->delete('asset.dokumentasi', ['id' => $id]);

		if ($delete) {
			$this->session->set_flashdata('flash', 'Data Dokumentasi <b>Berhasil</b> Dihapus');
			$this->session->set_flashdata('class', 'success');
			redirect('admin/documentation');
		} else {
			$this->session->set_flashdata('flash', 'Data Dokumentasi <b>Gagal</b> Dihapus');
			$this->session->set_flashdata('class', 'warning');
			redirect('admin/documentation');
		}
	}
}
