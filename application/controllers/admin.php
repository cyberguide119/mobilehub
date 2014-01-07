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

    /**
     * Check permissions when first loaded and load the admin view if, OK
     */
    public function index() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminView", 'index');
        }
    }

    /**
     * Load admin questions page
     */
    public function questions() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminQuestionsView", 'questions');
        }
    }

    /**
     * Load admin answers page
     */
    public function answers() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminAnswersView", 'answers');
        }
    }

    /**
     * Load admin users page
     */
    public function users() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminUsersView", 'users');
        }
    }

    /**
     * Load admin requests page
     */
    public function requests() {
        $res = $this->checkPermissions();
        if ($res) {
            $this->loadPage($res, "AdminRequestsView", 'requests');
        }
    }

    /**
     * Check for permissions
     * @return boolean
     */
    private function checkPermissions() {
        $profile = $this->input->get('user');

        if ($profile === false || $profile === null) {
            redirect('custom404');
            return false;
        }
        return $profile;
    }

    /**
     * Generic method to load a view
     * @param type $profile
     * @param type $page
     * @param type $url
     * @return type
     */
    private function loadPage($profile, $page, $url) {
        $data['user'] = $profile;

        $name = $this->authlib->is_loggedin();
        $userHasPerm = $this->permlib->userHasPermission($name, "VIEW_ADMINVIEW");
        if (!(strtolower($profile) === "admin" && $userHasPerm)) {
            redirect('custom403');
            return;
        } else {
            $data['name'] = $name;
            $this->loadAdminHeader($data, $url);
            $this->load->view('admin/' . $page);
            $this->loadAdminFooter();
        }
    }

    /**
     * Load the admin panel header
     * @param array $data
     * @param type $url
     */
    private function loadAdminHeader($data, $url) {
        $activeLink = array(
            "index" => "#",
            "questions" => "#",
            "answers" => "#",
            "users" => "#",
            "requests" => "#",
        );
        $activeLink[$url] = "active";
        $data['activeLink'] = $activeLink;
        $this->load->view('admin/AdminHeaderView', $data);
    }

    /**
     * Load the admin panel footer
     */
    private function loadAdminFooter() {
        $this->load->view('admin/AdminFooterView');
    }

}

?>
