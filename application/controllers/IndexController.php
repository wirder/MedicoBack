<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

	public function index() {

    $this->data['hello'] = 'Hello world!';
		$this->load->view('index', $this->data);

	}

}
