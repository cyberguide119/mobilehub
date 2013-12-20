<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Question
 *
 * @author DRX
 */
class Question extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Category');
    }

    public function ask() {
        if ($this->authlib->is_loggedin()) {
            $this->loadHeaderData();
            $cat = new Category();
            $categories = $cat->get();
            $this->load->view('question/AskView', array("categories" => $categories));
            $this->loadFooterData();
        } else {
            $this->loadHeaderData();
            $this->load->view('errors/ErrorNotLoggedIn');
            $this->loadFooterData();
        }
    }

    public function show() {
        $qId = $this->input->get('id');
        $data['questionId'] = $qId;
        $this->loadHeaderData();
        $this->load->view('question/QuestionView', $data);
        $this->loadFooterData();
    }
}

?>
