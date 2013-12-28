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
    public $isActive;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 
     * @param type $name
     * @param type $username
     * @param type $pwd
     * @param type $email
     * @param type $website
     * @return string|null
     */
    function registerStudent($name, $username, $pwd, $email, $website) {
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

        $unique_salt = $this->unique_salt();
        $hashpwd = sha1($unique_salt . $pwd);
        $time = time();

        $formattedDate = date("Y-m-d H:i:s", $time);
        $data = array('fullName' => $name, 'username' => $username,
            'password' => $hashpwd, 'email' => $email, 'website' => $website, 'joinedDate' => $formattedDate, 'salt' => $unique_salt, 'roleId' => 3, 'isActive' => true);
        $this->db->insert('user', $data);
        return null;
    }

    /**
     * 
     * @param type $name
     * @param type $username
     * @param type $pwd
     * @param type $email
     * @param type $website
     * @param type $linkedin
     * @param type $sourl
     * @return string|null
     */
    function registerTutor($name, $username, $pwd, $email, $website, $linkedin, $sourl) {
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

        $linkedInExists = $this->db->get_where('user', array('linkedInUrl' => $linkedin));
        if ($linkedInExists->num_rows() > 0) {
            return "LinkedIn address already exists";
        }

        $soExists = $this->db->get_where('user', array('sOUrl' => $sourl));
        if ($soExists->num_rows() > 0) {
            return "Stackoverflow address already exists";
        }

        $unique_salt = $this->unique_salt();
        $hashpwd = sha1($unique_salt . $pwd);
        $time = time();
        $formattedDate = date("Y-m-d H:i:s", $time);
        $data = array('fullName' => $name, 'username' => $username,
            'password' => $hashpwd, 'email' => $email, 'website' => $website, 'joinedDate' => $formattedDate, 'linkedInUrl' => $linkedin, 'sOUrl' => $sourl, 'roleId' => 2, 'isActive' => false, 'salt' => $unique_salt);
        $this->db->insert('user', $data);
        return null;
    }

    /**
     * 
     * @return string
     */
    private function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }

    /**
     * 
     * @param type $salt
     * @param type $pass
     * @param type $userPass
     * @return boolean
     */
    private function validatePassword($salt, $pass, $userPass) {
        if ($pass === sha1($salt . $userPass)) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $username
     * @param type $pwd
     * @param type $rememberLogin
     * @return boolean
     */
    function login($username, $pwd, $rememberLogin) {

        $this->db->where(array('username' => $username));
        $res = $this->db->get('user');
        if ($res->num_rows() != 1) { // should be only ONE matching row!!
            return false;
        }
        $user = $res->result();
        if (!($user[0]->isActive)) {
            return false;
        }
        $salt = $user[0]->salt;
        if (!($this->validatePassword($salt, $user[0]->password, $pwd))) {
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

    /**
     * 
     * @param type $email
     * @return boolean
     */
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

    /**
     * 
     * @return boolean
     */
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

    /**
     * 
     * @param type $userId
     * @return type
     */
    function getUserById($userId) {
        $this->db->select('username');
        $this->db->where('userId', $userId);
        $res = $this->db->get('user')->row();
        return $res->username;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    function getUserIdByName($username) {
        $this->db->select('userId');
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res->userId;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    function getUserRoleByName($username) {
        $this->db->select('roleId');
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res->roleId;
    }

    /**
     * 
     * @param type $userId
     * @param type $valueToAdd
     */
    function updatePointsForQuestion($userId, $valueToAdd) {
        $user = $this->db->get_where('user', array('userId' => $userId))->row();
        $loyality = $user->loyality + $valueToAdd;
        $data = array('loyality' => $loyality);
        $this->db->where('userId', $userId);
        $this->db->update('user', $data);
    }

    /**
     * 
     * @param type $userId
     * @param type $valueToAdd
     */
    function updatePointsForAnswer($userId, $valueToAdd) {
        $user = $this->db->get_where('user', array('userId' => $userId))->row();
        $reputation = $user->reputation + $valueToAdd;
        $data = array('reputation' => $reputation);
        $this->db->where('userId', $userId);
        $this->db->update('user', $data);
    }

    /**
     * 
     * @param type $userId
     * @param type $details
     */
    function updateUserDetails($userId, $details) {
        //$data = array('reputation' => $reputation);
        $this->db->where('userId', $userId);
        $this->db->update('user', $details);
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    function getUserRoleId($username) {
        $res = $this->db->get_where('user', array('username' => $username))->row();
        return $res->roleId;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    function getUserDetails($username) {
        $this->db->select(array('userId', 'username', 'fullName', 'roleId', 'joinedDate', 'website', 'linkedInUrl', 'sOUrl', 'reputation', 'loyality'));
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res;
    }

    /**
     * 
     * @param type $username
     * @param type $isTutor
     * @return type
     */
    function getFullUserDetails($username, $isTutor) {
        if ($isTutor) {
            $this->db->select(array('userId', 'email', 'profileImagePath', 'fullName', 'joinedDate', 'website', 'linkedInUrl', 'sOUrl', 'about'));
        } else {
            $this->db->select(array('userId', 'email', 'profileImagePath', 'fullName', 'joinedDate', 'website', 'about'));
        }
        $this->db->where('username', $username);
        $res = $this->db->get('user')->row();
        return $res;
    }

    /**
     * 
     * @return type
     */
    function getAllUsersCount() {
        return $this->db->count_all('user');
    }

    /**
     * 
     * @return type
     */
    function getAllUsers() {
        $this->db->select(array('user.userId', 'user.username', 'user.email', 'user.fullName', 'user.joinedDate', 'user_role.roleName'));
        $this->db->from('user');
        $this->db->where('user.username !=', 'admin');
        $this->db->join('user_role', 'user_role.roleId = user.roleId');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * 
     * @param type $userId
     */
    function deleteUser($userId) {
        $this->db->delete('user', array('userId' => $userId));
    }

    /**
     * 
     * @param type $userId
     */
    function activateUser($userId) {
        $data = array('isActive' => true);
        $this->db->where('userId', $userId);
        $this->db->update('user', $data);
    }

    /**
     * 
     * @param type $username
     * @param type $pwd
     * @return boolean
     */
    function deactivateUser($username, $pwd) {
        $this->db->where(array('username' => $username));
        $res = $this->db->get('user');
        if ($res->num_rows() != 1) { // should be only ONE matching row!!
            return false;
        } else {
            $user = $res->result();
            $salt = $user[0]->salt;
            if (!($this->validatePassword($salt, $user[0]->password, $pwd))) {
                return false;
            }
            $this->db->where(array('username' => $username));
            $this->db->update('user', array("isActive" => 0));
            return true;
        }
    }

}

?>
