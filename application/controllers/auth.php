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

    /**
     * Show a page not found error
     */
    public function index() {
        redirect('/Custom404/');
    }

    /**
     * Show the register user view
     */
    public function register() {
        $this->loadHeaderData('register');
        $data['errmsg'] = '';
        $this->load->view('login/RegisterView', $data);
        $this->loadFooterData();
    }
    
    /**
     * Show the forgot password view
     */
    public function forgot() {
        $this->loadHeaderData('forgot');
        $data['errmsg'] = '';
        $this->load->view('login/ForgotPasswordView', $data);
        $this->loadFooterData();
    }
    /**
     * Show the reset PW screen
     */
    public function reset() {
        $email = $this->uri->segment(3);
        $hash = $this->uri->segment(4);

        $fullName = $this->ci->user->emailExists($email);
        $hashExists = $this->ci->user->hashExists($email, $hash);
        if ($fullName && $hashExists) {
            // Get the first name and send the email to the user
            $this->loadHeaderData('reset');
            $data['errmsg'] = '';
            $data['email'] = $email;
            $data['hash'] = $hash;
            $this->load->view('login/ResetPasswordView', $data);
            $this->loadFooterData();
        } else {
            redirect('custom404');
        }
    }

    /**
     * Logout the current user
     */
    public function logout() {
        // Clear the session and redirect to the homepage
        $this->authlib->logout();
        redirect(site_url());
    }

}

?>
