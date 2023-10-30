<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_semua_data extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Daftar Semua Data' );
		$this->template->content( "admin/daftar_semua_data", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
