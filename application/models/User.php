<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author DRX
 */
 class User extends CI_Model {
        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        function register($name,$username,$pwd)
        {
            // is username unique?
            $res = $this->db->get_where('user',array('Username' => $username));
            if ($res->num_rows() > 0) {
                return 'Username already exists';
            }
            // username is unique
            $hashpwd = sha1($pwd);
            $data = array('FullName' => $name,'Username' => $username,
                          'Password' => $hashpwd);
            $this->db->insert('user',$data);
            return null; // no error message because all is ok
        }
        
        function login($username,$pwd)
        {
            /*$this->db->where(array('username' => $username,'password' => sha1($pwd)));
            $res = $this->db->get('users',array('name'));
            if ($res->num_rows() != 1) { // should be only ONE matching row!!
                return false;
            }
            return $res->row_array();*/
            
            $this->db->where(array('Username' => $username,'Password' => sha1($pwd)));
            $res = $this->db->get('user',array('name'));
            if ($res->num_rows() != 1) { // should be only ONE matching row!!
                return false;
            }

            // remember login
            $session_id = $this->session->userdata('session_id');
            // remember current login
            $row = $res->row_array();
            $this->db->insert('logins',array('name' => $row['FullName'],'session_id' => $session_id));
            return $row;
        }
        
         
        function is_loggedin()
        {
            $session_id = $this->session->userdata('session_id');
            $res = $this->db->get_where('logins',array('session_id' => $session_id));
            if ($res->num_rows() == 1) {
                $row = $res->row_array();
                return $row['name'];
            }
            else {
                return false;
            }
        }
    }
?>
