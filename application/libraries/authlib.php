<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Authlib {
 
    function __construct()
    {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model('user');
    }
 
    public function register($name,$user,$pwd,$conf_pwd,$email,$website)
    {
        if ($user == '' || $pwd == '' || $conf_pwd == '' || $email == '') {
            return 'Missing field';
        }
        if ($pwd != $conf_pwd) {
            return "Passwords do not match";
        }
        return $this->ci->user->register($name,$user,$pwd,$email,$website);
    }
    
    public function login($user,$pwd,$rememberLogin)
    {
        if ($user == '' || $pwd == '') {
            return false;
        }
        return $this->ci->user->login($user,$pwd,$rememberLogin);
    }
    
    public function is_loggedin()
    {
        return $this->ci->user->is_loggedin();
    }
}
?>
