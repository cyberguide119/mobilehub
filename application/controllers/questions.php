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
class Questions extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->ci = &get_instance();
        $this->ci->load->model(array('Category', 'User', 'Answer'));
        $this->load->library(array('permlib', 'questionslib'));
    }

    /**
     * Method to show the ask question page
     */
    public function ask() {
        if ($this->authlib->is_loggedin()) {
            $this->loadHeaderData('ask');
            $cat = new Category();
            $categories = $cat->get();
            $this->load->view('question/AskView', array("categories" => $categories));
            $this->loadFooterData();
        } else {
            $this->loadHeaderData('error');
            $this->load->view('errors/ErrorNotLoggedIn');
            $this->loadFooterData();
        }
    }

    /**
     * Show question page
     */
    public function show() {
        $qId = $this->input->get('id');
        $data['questionId'] = $qId;

        $this->loadHeaderData('showQuestion');
        $showAnswerBox = false;
        $username = $this->authlib->is_loggedin();

        if ($this->questionslib->isQuestionEdited($qId)) {
            $question = $this->questionslib->getQuestionEditedData($qId);
            $data['isQuestionEdited'] = true;
            $dateClosed = explode(" ", $question->editedDate);
            $data['editedDate'] = $dateClosed[0];
            $data['editedByUserName'] = $question->username;
            $netPoints = (($question->loyality === NULL) ? 0 : $question->loyality) + (($question->reputation === NULL) ? 0 : $question->reputation);
            $data['editedUserPoints'] = $netPoints;
        } else {
            $showAnswerBox = true;
            $data['isQuestionEdited'] = false;
        }

        if ($username) {
            if ($this->permlib->userHasPermission($username, "ANSWER_QUESTION")) {

                if ($this->questionslib->isQuestionClosed($qId)) {
                    $showAnswerBox = false;
                    $question = $this->questionslib->getQuestionClosedData($qId);
                    $data['isQuestionClosed'] = true;
                    $data['closeReason'] = $question->closeReason;
                    $dateClosed = explode(" ", $question->closedDate);
                    $data['closedDate'] = $dateClosed[0];
                    $data['closedByUserName'] = $question->username;
                } else {
                    $showAnswerBox = true;
                    $data['isQuestionClosed'] = false;
                }
                $data['isTutor'] = true;
            } else {
                $data['isTutor'] = false;
                if ($this->questionslib->isQuestionClosed($qId)) {
                    $question = $this->questionslib->getQuestionClosedData($qId);
                    $data['isQuestionClosed'] = true;
                    $data['closeReason'] = $question->closeReason;
                    $dateClosed = explode(" ", $question->closedDate);
                    $data['closedDate'] = $dateClosed[0];
                    $data['closedByUserName'] = $question->username;
                } else {
                    $data['isQuestionClosed'] = false;
                }
            }
        } else {
            if ($this->questionslib->isQuestionClosed($qId)) {
                $question = $this->questionslib->getQuestionClosedData($qId);
                $data['isQuestionClosed'] = true;
                $data['closeReason'] = $question->closeReason;
                $dateClosed = explode(" ", $question->closedDate);
                $data['closedDate'] = $dateClosed[0];
                $data['closedByUserName'] = $question->username;
            } else {
                $data['isQuestionClosed'] = false;
            }
            $showAnswerBox = false;
            $data['isTutor'] = false;
        }
        $this->load->view('question/QuestionView', $data);
        if ($showAnswerBox)
            $this->load->view('question/AnswerSubView');
        $this->loadFooterData();
    }

    /**
     * Edit question page
     */
    public function edit() {
        if (($username = $this->authlib->is_loggedin())) {
            if ($this->permlib->userHasPermission($username, "ANSWER_QUESTION")) {
                $data['isTutor'] = true;
            } else {
                $data['isTutor'] = false;
            }
            $this->loadHeaderData('editQuestion');
            $cat = new Category();
            $categories = $cat->get();

            $qId = $this->input->get('id');

            $data['questionId'] = $qId;
            $data['categories'] = $categories;
            $this->load->view('question/EditQuestionView', $data);
            $this->loadFooterData();
        } else {
            $this->loadHeaderData('error');
            $this->load->view('errors/ErrorNotLoggedIn');
            $this->loadFooterData();
        }
    }

    /**
     * Edit answer page
     */
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

            $this->loadHeaderData('editAnswer');
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
