<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		redirect( base_url( 'dashboard/eksekutif') );
	}
}
