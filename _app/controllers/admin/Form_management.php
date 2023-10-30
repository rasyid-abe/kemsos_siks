<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_management extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Form Management' );
		$this->template->content( "admin/form_management", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
