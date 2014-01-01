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
        $this->load->library(array('authlib', 'permlib', 'userlib'));
    }

    public function index() {
        $profile = $this->input->get('user');

        if ($profile === false) {
            redirect('custom404');
        }
        $this->showProfile($profile);
    }

    private function showProfile($profile) {
        $this->loadHeaderData('profile');
        $data['user'] = $profile;

        $name = $this->authlib->is_loggedin();

        if (!($this->userlib->isProfileActive($name)) && $name !== 'admin') {
            redirect('custom404');
            return;
        }

        $userHasPerm = $this->permlib->userHasPermission($name, "VIEW_ADMINPROFILE");
        if ($profile === strtolower("Admin")) {
            if (!$userHasPerm) {
                redirect('custom403');
                return;
            }
        }

        if ($name === $profile) {
            $data['isOwner'] = true;
        } else {
            $data['isOwner'] = false;
        }
        $this->load->view('user/UserView', $data);
        $this->loadFooterData();
    }

    public function edit() {
        $profile = $this->input->get('user');
        $name = $this->authlib->is_loggedin();
        if ($name === $profile) {
            $this->loadHeaderData('editProfile');
            $data['user'] = $profile;
            $this->load->view('user/EditUserView', $data);
            $this->loadFooterData();
        } else {
            redirect('custom403');
        }
    }

    public function delete() {
        $profile = $this->input->get('user');
        $name = $this->authlib->is_loggedin();
        if ($name === $profile) {
            $this->loadHeaderData('deleteProfile');
            $data['user'] = $profile;
            $this->load->view('user/DeleteUserView', $data);
            $this->loadFooterData();
        } else {
            redirect('custom403');
        }
    }

}

?>
