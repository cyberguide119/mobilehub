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

    private function sendResetLinkEmail($email, $fullName) {
        // Email the reset link to the user
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'localhost',
            'smtp_port' => 25,
            'smtp_user' => 'info.mobilehub@gmail.com',
            'smtp_pass' => '123456Sa',
            'mailtype' => 'html',
            'multipart' => false,
            //'wordwrap' => true,
            //'crlf' => "\r\n",
            //'wrapchars' => 0,
            //'charset' => 'iso-8859-1',
            //'newline' => "\r\n"
        );
        $this->ci->load->library('email', $config);
        //$this->ci->email->set_crlf("\r\n");
        $emailCode = md5($this->ci->config->item('salt') . $fullName);

        //$this->email->set_mailtype('html');
        $this->ci->email->from('info.mobilehub@gmail.com', 'MobileHub');
        $this->ci->email->to($email);
        $this->ci->email->subject("Please reset your password at MobileHub");
        $data = Array(
            'email' => $email,
            'emailCode' => $emailCode,
            'fullName' => $fullName
        );

        $message = '<!DOCTYPE html>'
                . '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'
                . '<head>'
                . '<meta charset="utf-8"></meta>'
                . '<title>Create a new password on MobileHub</title>'
                . '</head>'
                . '<body>'
                . '<p>Hi ' . $fullName . ',</p>'
                . '<p>Thank you!</p><p>MobileHub Team</p>'
                . '</body>'
                . '</html>';

        //$this->email->message($this->ci->load->view('email/passResetHTML', $data, TRUE));
        $this->ci->email->message($message);
        $this->ci->email->send();
        if (!$this->ci->email->send())
            return "Sorry, something went wrong when sending the email";
        else
            return true;
    }

}

?>
