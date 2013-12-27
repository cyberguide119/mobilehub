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
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminView");
        }
    }

    public function questions() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminQuestionsView");
        }
    }
    
    public function answers() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminAnswersView");
        }
    }
    
    public function users() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminUsersView");
        }
    }
    
    public function requests() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminRequestsView");
        }
    }

    private function checkPermissions() {
        $profile = $this->input->get('user');

        if ($profile === false) {
            redirect('custom404');
            return false;
        }
        return $profile;
    }
    
    private function loadPage($profile, $page ){
        $data['user'] = $profile;

        $name = $this->authlib->is_loggedin();
        $userHasPerm = $this->permlib->userHasPermission($name, "VIEW_ADMINVIEW");
        if (!(strtolower($profile) === "admin" && $userHasPerm)) {
            redirect('custom403');
            return;
        } else {
            $data['name'] = $name;
            $this->loadAdminHeader($data);
            $this->load->view('admin/'.$page);
            $this->loadAdminFooter();
        }
    }
    
    private function loadAdminHeader($data){
        $this->load->view('admin/AdminHeaderView', $data);
    }
    
    private function loadAdminFooter(){
        $this->load->view('admin/AdminFooterView');
    }

}

?>
