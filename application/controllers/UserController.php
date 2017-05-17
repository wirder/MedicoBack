<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct() {
    parent::__construct();

		$this->load->model('user_model', 'user');
  }

	public function index() {
		$this->load->view('index');
	}

    public function login()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if($method != 'POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            $params = json_decode(file_get_contents('php://input'), TRUE);

            $username = $params['username'];
            $password = $params['password'];

            $response = $this->user->login($username,$password);
            json_output($response['status'],$response);
        }
    }

    public function register() {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
            $params = json_decode(file_get_contents('php://input'), TRUE);

            if (empty($params['username'])) {
                return json_output(403, array('status' => 403, 'message' => 'Le champ username ne doit pas être vide'));
            }
            if (empty($params['password'])) {
                return json_output(403, array('status' => 403, 'message' => 'Le champ password ne doit pas être vide'));
            }
            if (empty($params['email'])) {
                return json_output(403, array('status' => 403, 'message' => 'Le champ email ne doit pas être vide'));
            }
            $username = $params['username'];
            $password = $params['password'];
            $email = $params['email'];
            if ($this->user->check_username($username) === true) {
                return json_output(403, array('status' => 403, 'message' => 'Ce username existe déjà'));
            }
            if ($this->user->check_email($email) === true) {
                return json_output(403, array('status' => 403, 'message' => 'Cette email existe déjà'));
            }

            $form_datas = array(
                'username' => $username,
                'password' => md5($password),
                'email' => $email
            );

            $this->user->save($form_datas);
            $response = $this->user->login($username,$password);
            return json_output(200, $response);
        }
    }

}
