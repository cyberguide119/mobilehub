<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author DRX
 */
class Admin extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib', 'searchlib', 'questionslib'));

        $this->ci = &get_instance();
        $this->load->model(array('Question', 'User', 'QuestionsTags', 'Tag'));
    }

    public function index() {
        $profile = $this->input->get('user');

        if ($profile === false) {
            redirect('custom404');
        }
        $this->loadDashboard($profile);
    }

    private function loadDashboard($profile) {
        //$this->loadHeaderData();
        $data['user'] = $profile;

        $name = $this->authlib->is_loggedin();
        $userHasPerm = $this->permlib->userHasPermission($name, "VIEW_ADMINVIEW");
        if (!($profile === strtolower("Admin") && $userHasPerm)) {
            redirect('custom403');
            return;
        }else{
            $data['name'] = $name;
            $this->load->view('admin/AdminView', $data);
        }
    }

}

?>
