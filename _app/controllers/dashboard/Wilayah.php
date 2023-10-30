<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Dashboard Wilayah' );
		$this->template->content( "admin/dashboard/wilayah", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
