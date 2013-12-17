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
        $this->load->library(array('authlib','searchlib', 'questionslib'));

        $this->ci = &get_instance();
        $this->load->model(array('Question', 'User', 'QuestionsTags', 'Tag'));
    }

    public function index() {
        $this->loadHeaderData();
        $this->loadQuestions();
        $this->loadFooterData();
    }

    private function loadQuestions() {
        $questions = $this->ci->questionslib->getRecentQuestions();
        $this->load->view('home/HomepageView', array(
            'questions' => $questions,
        ));
    }

    public function about() {
        $this->loadHeaderData();
        $this->load->view('home/AboutView');
        $this->loadFooterData();
    }

}

?>
