<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homepage_controller
 *
 * @author DRX
 */
class Homepage extends MY_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib', 'searchlib', 'questionslib'));

        $this->ci = &get_instance();
        $this->load->model(array('Question', 'User', 'QuestionsTags', 'Tag'));
    }

    /**
     * load the homepage
     */
    public function index() {
        $this->loadHeaderData('homepage');
        $this->loadQuestions();
        $this->loadFooterData();
    }

    /**
     * load the questions
     */
    private function loadQuestions() {
        $this->load->view('home/HomepageView');
    }

    /**
     * load the about page
     */
    public function about() {
        $this->loadHeaderData('about');
        $this->load->view('home/AboutView');
        $this->loadFooterData();
    }

}

?>
