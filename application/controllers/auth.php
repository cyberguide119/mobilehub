<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//header('Content-Type: application/json');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth
 *
 * @author DRX
 */
class auth extends MY_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib'));

        $this->ci = &get_instance();
        $this->ci->load->model('user');
    }

    public function index() {
        redirect('/Custom404/');
    }

    public function register() {
        $this->loadHeaderData();
        $data['errmsg'] = '';
        $this->load->view('login/RegisterView', $data);
        $this->loadFooterData();
    }

//    public function login() {
//        $this->loadHeaderData();
//        $this->load->view('login/LoginView');
//        $this->loadFooterData();
//    }

    public function forgot() {
        $this->loadHeaderData();
        $data['errmsg'] = '';
        $this->load->view('login/ForgotPasswordView', $data);
        $this->loadFooterData();
    }

    

    public function authenticate() {
        //$credentials = $_POST;
//        $session_id = $this->session->userdata('session_id');
//
//        $response = $this->curl->simple_post('api/authenticate', $credentials);
//        //$this->session->unset_userdata('session_id');
//        $this->session->set_userdata('session_id', $session_id);
//        echo $response;
    }

    public function logout() {
        // Clear the session and redirect to the homepage
        $this->authlib->logout();
        redirect(site_url());
    }

}

?>
