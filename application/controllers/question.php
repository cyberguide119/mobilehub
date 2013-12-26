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
        $this->ci = &get_instance();
        $this->ci->load->model(array('Category', 'User', 'Answer'));
        $this->load->library('permlib');
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
        $username = $this->authlib->is_loggedin();
        if ($username) {
            if ($this->permlib->userHasPermission($username, "ANSWER_QUESTION")) {
                $this->load->view('question/AnswerSubView');
            }
        }
        $this->loadFooterData();
    }

    public function edit() {
        if ($this->authlib->is_loggedin()) {
            $this->loadHeaderData();
            $cat = new Category();
            $categories = $cat->get();

            $qId = $this->input->get('id');

            $data['questionId'] = $qId;
            $data['categories'] = $categories;
            $this->load->view('question/EditQuestionView', $data);
            $this->loadFooterData();
        } else {
            $this->loadHeaderData();
            $this->load->view('errors/ErrorNotLoggedIn');
            $this->loadFooterData();
        }
    }

    public function editanswer() {

        $username = $this->authlib->is_loggedin();
        $qId = $this->input->get('id');
        $ansId = $this->input->get('ans');
        $userId = $this->ci->User->getUserIdByName($username);
        $answeredUser = $this->ci->Answer->getAnsweredUserId($ansId);
        $votes = $this->ci->Answer->getNetVotes($ansId);
        
        if ($username && $userId === $answeredUser && $votes < 1) {

            $data['questionId'] = $qId;
            $data['answerId'] = $ansId;

            $this->loadHeaderData();
            $this->load->view('question/EditAnswerView', $data);
            if ($this->permlib->userHasPermission($username, "EDIT_ANSWER")) {
                $this->load->view('question/AnswerEditSubView');
                $this->loadFooterData();
            } else {
                $this->load->view('errors/Error403');
            }
        } else {
            $this->load->view('errors/Error403');
        }
    }

}

?>
