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
class auth extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib', 'curl'));

        $this->ci = &get_instance();
        $this->ci->load->model('user');
    }

//    private function get()
//    {
//        $args = $this->uri->uri_to_assoc(1);
//        switch (strtolower($args['auth'])) {
//            case 'logout' :
//                $this->logout();
//                break;
//            case 'register':
//                $this->register();
//                break;
//            case 'forgot':
//                $this->forgot();
//                break;
//            default:
//                show_error('Unsupported resource',404);
//                break;
//        }
//    }

    public function index() {
        redirect('/auth/login'); // url helper function
    }

    public function register() {
        $this->load->view('login/RegisterView', array('errmsg' => ''));
    }

    public function createaccount() {
        $name = $this->input->post('name');
        $username = $this->input->post('uname');
        $password = $this->input->post('pword_confirmation');
        $conf_password = $this->input->post('pword');
        $email = $this->input->post('email');
        $website = $this->input->post('website');

        if (!($errmsg = $this->authlib->register($name, $username, $password, $conf_password, $email, $website))) {
            redirect('/homepage/');
        } else {
            $data['errmsg'] = $errmsg;
            $this->load->view('login/RegisterView', $data);
        }
    }

    public function login() {
//        $data['errmsg'] = '';
//        $data['subview'] = 'login/LoginView';
//        $loggedin = $this->authlib->is_loggedin();
//        $this->load->view('common/HeaderView',array('name' => $loggedin));
//
//        $this->load->view('common/PopupView',$data);
//        $this->load->view('common/FooterView');
    }

    public function forgot() {
        $this->loadHeaderData();
        $data['errmsg'] = '';
        $this->load->view('login/ForgotPasswordView', $data);
        $this->loadFooterData();
    }

    private function loadHeaderData() {
        $loggedin = $this->authlib->is_loggedin();
        $this->load->view('common/HeaderView', array('name' => $loggedin));

        $data['errmsg'] = '';
        $data['subview'] = 'login/LoginView';
        $this->load->view('common/PopupView', $data);
    }

    private function loadFooterData() {
        $this->load->view('common/FooterView');
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
        $session_id = $this->session->userdata('session_id');

        $response = $this->curl->simple_post('api/authenticate', $credentials);
        //$this->session->unset_userdata('session_id');
        $this->session->set_userdata('session_id', $session_id);
        echo $response;
    }

    public function logout() {
        // Clear the session and redirect to the homepage
        $this->session->sess_destroy();
        redirect(site_url());
    }

}

?>
