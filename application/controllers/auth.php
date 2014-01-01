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
        $this->loadHeaderData('register');
        $data['errmsg'] = '';
        $this->load->view('login/RegisterView', $data);
        $this->loadFooterData();
    }
    
    public function forgot() {
        $this->loadHeaderData('forgot');
        $data['errmsg'] = '';
        $this->load->view('login/ForgotPasswordView', $data);
        $this->loadFooterData();
    }

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
            //return $this->sendResetLinkEmail($email, $fullName);
        } else {
            redirect('custom404');
            // return "Your email does not exist in our database.";
        }
    }

    public function logout() {
        // Clear the session and redirect to the homepage
        $this->authlib->logout();
        redirect(site_url());
    }

}

?>
