<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_management extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Master Data Lokasi' );
		$this->template->content( "admin/group_management", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
