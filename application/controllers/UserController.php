<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct() {
    parent::__construct();

		// $this->load->model('user_model', 'user');
  }

	public function index() {
		$this->load->view('index');
	}

}
