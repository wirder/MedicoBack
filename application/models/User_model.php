<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

  private $table = 'users';

    public function login($username,$password)
    {
        $q  = $this->db->select('password,id')->from('users')->where('username',$username)->get()->row();
        if($q == ""){
            return array('status' => 403,'message' => 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id              = $q->id;
            if ($hashed_password === md5($password)) {
                $last_login = date('Y-m-d H:i:s');
                $token = bin2hex(openssl_random_pseudo_bytes(32));
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->trans_start();
                $this->db->where('id',$id)->update('users',array('last_login' => $last_login));
                $this->db->insert('users_authentication',array('id_user' => $id,'token' => $token,'date_expired' => $expired_at));
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    return array('status' => 500,'message' => 'Internal server error.');
                } else {
                    $this->db->trans_commit();
                    return array('status' => 200,'message' => 'Successfully login.','id' => $id, 'token' => $token, 'username' => $username);
                }
            } else {
                return array('status' => 403,'message' => 'Wrong password.');
            }
        }
    }

    public function check_username($username){
        $this->db->select("id")
            ->where("username", $username);

        $query = $this->db->get($this->table);
        if ( $query->num_rows() > 0 )
            return true;

        return false;
    }

    public function check_email($email){
        $this->db->select("id")
            ->where("email", $email);

        $query = $this->db->get($this->table);
        if ( $query->num_rows() > 0 )
            return true;

        return false;
    }

    public function save($datas = NULL) {
        if ( !empty($datas) ) {
            $lastId = $this->db->insert($this->table, $datas);
            return $lastId;
        }

        return false;
    }

    public function auth() {
        $id_user  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $q  = $this->db->select('date_expired')->from('users_authentication')->where('id_user',$id_user)->where('token',$token)->get()->row();
        if($q == ""){
            return json_output(401,array('status' => 401,'message' => 'Unauthorized (auth).'));
        } else {
            if($q->date_expired < date('Y-m-d H:i:s')){
                return json_output(401,array('status' => 401,'message' => 'Your session has been expired.'));
            } else {
                $date_upd = date('Y-m-d H:i:s');
                $date_expired = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('id_user',$id_user)->where('token',$token)->update('users_authentication',array('date_expired' => $date_expired,'date_upd' => $date_upd));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }

}
