<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author DRX
 */
class User extends MY_Model {

    const DB_TABLE = 'user';
    const DB_TABLE_PK = 'userId';

    public $userId;
    public $username;
    public $password;
    public $fullName;
    public $email;
    public $profileImagePath;
    public $userTypeId;
    public $joinedDate;
    public $website;
    public $linkedInUrl;
    public $sOUrl;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function register($name, $username, $pwd, $email, $website) {
        // is username unique?
        $usernameExists = $this->db->get_where('user', array('username' => $username));
        if ($usernameExists->num_rows() > 0) {
            return "Username already exists";
        }
        // username is unique

        $emailExists = $this->db->get_where('user', array('email' => $email));
        if ($emailExists->num_rows() > 0) {
            return "Email already exists";
        }

        $hashpwd = sha1($pwd);
        $this->load->helper('date');
        $datestring = "%Y-%m-%d %h-%i-%a";
        $time = time();

        $formattedDate = mdate($datestring, $time);
        $data = array('fullName' => $name, 'username' => $username,
            'password' => $hashpwd, 'email' => $email, 'website' => $website, 'joinedDate' => $formattedDate);
        $this->db->insert('user', $data);
        return null;
    }

    function login($username, $pwd, $rememberLogin) {
        $this->db->where(array('username' => $username, 'password' => sha1($pwd)));
        $res = $this->db->get('user', array('name'));
        if ($res->num_rows() != 1) { // should be only ONE matching row!!
            return false;
        }

        // remember login
        if ($rememberLogin == false) {
            // User does not want to remember his session
            $this->session->sess_expiration = 7200;
            $this->session->sess_expire_on_close = TRUE;
        }
        $session_id = $this->session->userdata('session_id');
        $this->session->set_userdata(array('session_id' => $session_id));
        // remember current login
        $row = $res->row_array();
        $this->db->insert('logins', array('name' => $row['username'], 'session_id' => $session_id));
        return $row;
    }

    function emailExists($email) {
        $this->db->select('fullName');
        $this->db->where('email', $email);
        $result = $this->db->get('user');
        if ($result->num_rows() != 1) {
            return false;
        }
        $row = $result->row();
        return $row->fullName;
    }

    function is_loggedin() {
        $session_id = $this->session->userdata('session_id');
        $res = $this->db->get_where('logins', array('session_id' => $session_id));
        if ($res->num_rows() == 1) {
            $row = $res->row_array();
            return $row['name'];
        } else {
            return false;
        }
    }

    function getUserById($userId) {
        $this->db->select('username');
        $this->db->where('userId', $userId);
        $res = $this->db->get('user')->row();
        return $res->username;
    }

    function getUserIdByName($username) {
        $this->db->select('userId');
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res->userId;
    }

    function getUserRoleByName($username) {
        $this->db->select('roleId');
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res->roleId;
    }

    function updatePointsForQuestion($userId, $valueToAdd) {
        $user = $this->db->get_where('user', array('userId' => $userId))->row();
        $loyality = $user->loyality + $valueToAdd;
        $data = array('loyality' => $loyality);
        $this->db->where('userId', $userId);
        $this->db->update('user', $data);
    }

    function updatePointsForAnswer($userId, $valueToAdd) {
        $user = $this->db->get_where('user', array('userId' => $userId))->row();
        $reputation = $user->reputation + $valueToAdd;
        $data = array('reputation' => $reputation);
        $this->db->where('userId', $userId);
        $this->db->update('user', $data);
    }
    
    function updateUserDetails($userId, $details){
        $where = array();
        foreach ($details as $key){
            $where[$key] = $details[$key];
            
        }
    }

    function getUserRoleId($username) {
        $res = $this->db->get_where('user', array('username' => $username))->row();
        return $res->roleId;
    }

    function getUserDetails($username) {
        $this->db->select(array('userId', 'username', 'fullName', 'roleId', 'joinedDate', 'website', 'linkedInUrl', 'sOUrl', 'reputation', 'loyality'));
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res;
    }

    function getFullUserDetails($username, $isTutor) {
        if ($isTutor) {
            $this->db->select(array('userId', 'email', 'profileImagePath' , 'fullName', 'joinedDate', 'website', 'linkedInUrl', 'sOUrl'));
        } else {
            $this->db->select(array('userId', 'email', 'profileImagePath' , 'fullName', 'joinedDate', 'website'));
        }
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res;
    }

}

?>
