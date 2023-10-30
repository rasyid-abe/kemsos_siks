<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapangan extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Dashboard Lapangan' );
		$this->template->content( "admin/dashboard/lapangan", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
