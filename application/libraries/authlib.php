<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class authlib {

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model('user');
        $this->ci->load->library('session');
    }

    public function register($name, $user, $pwd, $conf_pwd, $email, $website) {
        if ($user == '' || $pwd == '' || $conf_pwd == '' || $email == '') {
            return 'Missing field';
        }
        if ($pwd != $conf_pwd) {
            return "Passwords do not match";
        }
        return $this->ci->user->registerStudent($name, $user, $pwd, $email, $website);
    }

    public function registerTutor($name, $user, $pwd, $conf_pwd, $email, $website, $linkedin, $sourl) {
        if ($user === '' || $pwd === '' || $conf_pwd === '' || $email === '' || $linkedin === '' || $sourl === '') {
            return 'Missing field';
        }
        if ($pwd != $conf_pwd) {
            return "Passwords do not match";
        }
        return $this->ci->user->registerTutor($name, $user, $pwd, $email, $website, $linkedin, $sourl);
    }

    public function login($user, $pwd, $rememberLogin) {
        if ($user == '' || $pwd == '') {
            return false;
        }
        return $this->ci->user->login($user, $pwd, $rememberLogin);
    }

    public function is_loggedin() {
        return $this->ci->user->is_loggedin();
    }

    public function logout() {
        $this->ci->session->sess_destroy();
    }

    public function sendResetLink($email) {
        $email = trim($email);
        $fullName = $this->ci->user->emailExists($email);
        if ($fullName) {
            // Get the first name and send the email to the user
            return $this->sendResetLinkEmail($email, $fullName);
        } else {
            return "Your email does not exist in our database.";
        }
    }

    public function resetPass($email, $hash, $pass) {
        return $this->ci->User->updateViaHash($email, $hash, $pass);
    }

    private function sendResetLinkEmail($email, $fullName) {
        // Email the reset link to the user
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'localhost',
            'smtp_port' => 25,
            'smtp_user' => 'info.mobilehub@gmail.com',
            'smtp_pass' => '123456Sa',
            'mailtype' => 'text',
            'multipart' => false,
            'wordwrap' => true,
            'crlf' => "\r\n",
            'wrapchars' => 0,
            'charset' => 'iso-8859-1',
            'newline' => "\r\n"
        );
        $this->ci->load->library('email', $config);
        $this->ci->load->model('user');

        $this->ci->email->set_crlf("\r\n");
        $emailCode = md5($this->ci->config->item('salt') . $fullName);
        $this->ci->user->updatePassResetLink($email, $emailCode);

        //$this->email->set_mailtype('html');
        $this->ci->email->from('info.mobilehub@gmail.com', 'MobileHub');
        $this->ci->email->to($email);
        $this->ci->email->subject("Please reset your password at MobileHub");
        $data = Array(
            'email' => $email,
            'emailCode' => $emailCode,
            'fullName' => $fullName
        );

        $message = "Hi " . $fullName . ","
                . "\r\n\r\nForgot your password, huh? No big deal! Please visit the following link to reset your password/:"
                . "\r\n\r\nhttp://localhost/MobileHub/index.php/auth/reset/" . $email . "/" . $emailCode
                . "\r\n\r\nThank you!\r\n\r\nMobileHub Team";
        
        $this->ci->email->message($message);
        if ($this->ci->email->send()) {
            return true;
        } else {
            return false;
        }    
    }
}

?>
