<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth
 *
 * @author DRX
 */
class auth extends CI_Controller{
    //put your code here
    
     function __construct()
    {
        parent::__construct();
        $this->load->library('authlib');
        
        $this->ci = &get_instance();
        $this->ci->load->model('user');
    }
    
    public function index()
    {
        redirect('/auth/login'); // url helper function
    }

    public function register()
    {
        $this->load->view('login/RegisterView',array('errmsg' => ''));
    }

    public function createaccount()
    {
        $name = $this->input->post('name');
        $username = $this->input->post('uname');
        $password = $this->input->post('pword_confirmation');
        $conf_password = $this->input->post('pword');
        $email = $this->input->post('email');
        $website = $this->input->post('website');

        if (!($errmsg = $this->authlib->register($name,$username,$password,$conf_password,$email,$website))) {
            redirect('/auth/login');
        }
        else {
            $data['errmsg'] = $errmsg;
            $this->load->view('login/RegisterView',$data);
        }
    }
    
    public function login()
    {
        $data['errmsg'] = '';
        $data['subview'] = 'login/LoginView';
        $this->load->view('common/PopupView',$data);
    }
    
    public function forgot()
    {
        $data['errmsg'] = '';
        $this->load->view('login/ForgotPasswordView',$data);
    }
    
    public function sendResetLink()
    {
        if(isset($_POST['email']) && !empty($_POST['email']))
        {
            $this->load->library('form_validation');
            
            // Checking if this is a valid email or not
            $this->form_validation->set_rules('email','Email Address', 'trim|required|min_length[6]|valid_email|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                // Validation failed. Send the error messages back to the forgot password view
                $data['errmsg']= 'Please enter a valid email address';
                $this->load->view('login/ForgotPasswordView', $data);
            }else{
                $email = trim($this->input->post('email'));
                $fullName = $this->ci->user->emailExists($email);
                
                if($fullName){
                    // Get the first name and send the email to the user
                    
                    $this->sendResetLinkEmail($email,$fullName);
                    
                    //Load the UI
                }else{
                    // Show email address is not found to the user
                }
            }
        }else{
            // Load the reset password view
        }
    }
    
    private function sendResetLinkEmail($email, $fullName)
    {
        // Email the reset link to the user
        $this->load->library('email');
        $emailCode = md5($this->config->item('salt') . $fullName);
        
        $this->email->set_mailtype('html');
        $this->email->from($this->config->item('bot email'), 'Mobile Hub');
        $this->email->to($email);
        $this->email->subject("Please reset your password at MobileHub");
        
        $message = '<!DOCTYPE html><html><head></head><body>';
        $message .= '<p>Dear ' . $fullName . '</p>';
        $message .= '<p>We want to help you reset your password! Please <strong><a href="' . base_url() .'auth/updateNewPassword/' . $email . '/' . $emailCode . '">Click here</a></strong> to reset your password.</p>';
        $message .= '<p>Thank you!</p>';
        $message .= '<p>MobileHub Team</p>';
        
        $this->email->message($message);
        $this->email->send();
    }

    public function authenticate()
    {
        $username = $this->input->post('uname');
        $password = $this->input->post('pword');
        $rememberLogin = $this->input->post('remember');
        $user = $this->authlib->login($username,$password,$rememberLogin);

        if ($user != false) {
            $this->load->view('home/HomepageView', array('name' => $user['Username']));
        }
        else {
            $data['errmsg'] = 'Unable to login - please try again';
            $this->load->view('login/LoginView',$data);
        }
    }
    
    public function logout()
    {
        // Clear the session and redirect to the homepage
        $this->session->sess_destroy();
        redirect(site_url());
    }
}

?>
