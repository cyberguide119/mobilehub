<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
     
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function register($name,$username,$pwd,$email,$website)
    {
        // is username unique?
        $res = $this->db->get_where('user',array('username' => $username));
        if ($res->num_rows() > 0) {
            return 'Username already exists';
        }
        // username is unique
        $hashpwd = sha1($pwd);
        $this->load->helper('date');
        $datestring = "%Y-%m-%d %h-%i-%a";
        $time = time();

        $formattedDate = mdate($datestring, $time);
        $data = array('fullName' => $name,'username' => $username,
                      'password' => $hashpwd, 'email' => $email, 'website' => $website, 'joinedDate' => $formattedDate);
        $this->db->insert('user',$data);
        return null; // no error message because all is ok
    }

    function login($username,$pwd,$rememberLogin)
    {
        $this->db->where(array('username' => $username,'password' => sha1($pwd)));
        $res = $this->db->get('user',array('name'));
        if ($res->num_rows() != 1) { // should be only ONE matching row!!
            return false;
        }

        // remember login
        if($rememberLogin == false){
            // User does not want to remember his session
            $this->session->sess_expiration = 7200;
            $this->session->sess_expire_on_close = TRUE;
        }
        $session_id = $this->session->userdata('session_id');
        $this->session->set_userdata(array('session_id' => $session_id)); 
        // remember current login
        $row = $res->row_array();
        $this->db->insert('logins',array('name' => $row['username'],'session_id' => $session_id));
        return $row;
    }

    function emailExists($email)
    {
        $this->db->select('fullName');
        $this->db->where('email',$email);
        $result = $this->db->get('user');
        if($result->num_rows() != 1){
            return false;
        }
        $row = $result->row();
        return $row->fullName;
    }

    function is_loggedin()
    {
        $session_id = $this->session->userdata('session_id');
        $res = $this->db->get_where('logins',array('session_id' => $session_id));
        var_dump($session_id);
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
