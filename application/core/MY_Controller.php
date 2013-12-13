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
    
    public $search_data;

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib'));
    }

    public function loadHeaderData() {
        $loggedin = $this->authlib->is_loggedin();
        $this->load->view('common/HeaderView', array('name' => $loggedin));

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
