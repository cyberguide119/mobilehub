<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author DRX
 */
class profile extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User');
        $this->load->library('authlib');
    }

    public function index() {
        $profile = $this->input->get('user');
        $this->showProfile($profile);
    }

    private function showProfile($profile) {
        $this->loadHeaderData();
        $data['user'] = $profile;

        $name = $this->authlib->is_loggedin();
        if ($name === $profile) {
            $data['isOwner'] = true;
        } else {
            $data['isOwner'] = false;
        }
        $this->load->view('user/UserView', $data);
        $this->loadFooterData();
    }

}

?>
