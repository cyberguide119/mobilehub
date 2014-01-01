<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author DRX
 */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib', 'permlib'));
    }

    public function loadHeaderData($page) {
        $activeLink = array(
            "tutorials" => "#",
            "categories" => "#",
            "about" => "#"
        );
        $activeLink[$page] = "active";
        
        $loggedin = $this->authlib->is_loggedin();
        if ($loggedin) {
            $isAdmin = $this->permlib->isAdmin($loggedin);
            $authData['isAdmin'] = $isAdmin;
        }
        $authData['name'] = $loggedin;
        $authData['activeLink'] = $activeLink;
        $this->load->view('common/HeaderView', $authData);

        $data['errmsg'] = '';
        $data['subview'] = 'login/LoginView';
        $data['notLoggedInSubview'] = 'errors/ErrorNotLoggedIn';
        
        $this->load->view('common/PopupView', $data);
    }

    public function loadFooterData() {
        $this->load->view('common/FooterView');
    }

}

?>
