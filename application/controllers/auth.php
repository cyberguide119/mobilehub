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
        redirect('/auth/login'); // url helper function
    }

    public function register() {
        $this->loadHeaderData();
        $data['errmsg'] = '';
        $this->load->view('login/RegisterView', $data);
        $this->loadFooterData();
    }

    public function login() {
        $this->loadHeaderData();
        $this->load->view('login/LoginPageView');
        $this->loadFooterData();
    }

    public function forgot() {
        $this->loadHeaderData();
        $data['errmsg'] = '';
        $this->load->view('login/ForgotPasswordView', $data);
        $this->loadFooterData();
    }

    public function sendResetLink() {
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $this->load->library('form_validation');

            // Checking if this is a valid email or not
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|min_length[6]|valid_email|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                // Validation failed. Send the error messages back to the forgot password view
                $data['errmsg'] = 'Please enter a valid email address';
                $this->load->view('login/ForgotPasswordView', $data);
            } else {
                $email = trim($this->input->post('email'));
                $fullName = $this->ci->user->emailExists($email);

                if ($fullName) {
                    // Get the first name and send the email to the user

                    $this->sendResetLinkEmail($email, $fullName);

                    //Load the UI
                } else {
                    // Show email address is not found to the user
                }
            }
        } else {
            // Load the reset password view
        }
    }

    private function sendResetLinkEmail($email, $fullName) {
        // Email the reset link to the user
        $this->load->library('email');
        $emailCode = md5($this->config->item('salt') . $fullName);

        $this->email->set_mailtype('html');
        $this->email->from($this->config->item('bot email'), 'Mobile Hub');
        $this->email->to($email);
        $this->email->subject("Please reset your password at MobileHub");

        $message = '<!DOCTYPE html><html><head></head><body>';
        $message .= '<p>Dear ' . $fullName . '</p>';
        $message .= '<p>We want to help you reset your password! Please <strong><a href="' . base_url() . 'auth/updateNewPassword/' . $email . '/' . $emailCode . '">Click here</a></strong> to reset your password.</p>';
        $message .= '<p>Thank you!</p>';
        $message .= '<p>MobileHub Team</p>';

        $this->email->message($message);
        $this->email->send();
    }

    public function authenticate() {
        $credentials = $_POST;
//        $session_id = $this->session->userdata('session_id');
//
//        $response = $this->curl->simple_post('api/authenticate', $credentials);
//        //$this->session->unset_userdata('session_id');
//        $this->session->set_userdata('session_id', $session_id);
//        echo $response;
        
//            $ch =  curl_init();
//
//            $useragent = isset($z['useragent']) ? $z['useragent'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2';
//
//            curl_setopt( $ch, CURLOPT_URL, 'http://localhost/MobileHub/index.php/api/authenticate' );
//            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
//            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
//            curl_setopt( $ch, CURLOPT_POST, $credentials);
//
//            //if( isset($z['post']) )         curl_setopt( $ch, CURLOPT_POSTFIELDS, $z['post'] );
//            //if( isset($z['refer']) )        curl_setopt( $ch, CURLOPT_REFERER, $z['refer'] );
//
//            curl_setopt( $ch, CURLOPT_USERAGENT, $useragent );
//            //curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, ( isset($z['timeout']) ? $z['timeout'] : 5 ) );
//            curl_setopt( $ch, CURLOPT_COOKIEJAR,  dirname(__FILE__)."/cookie.txt");
//            curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/cookie.txt");
//
//            $result = curl_exec( $ch );
//            curl_close( $ch );
//            echo $result;
    }

    public function logout() {
        // Clear the session and redirect to the homepage
        $this->session->sess_destroy();
        redirect(site_url());
    }

}

?>
