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
        $this->load->library(array('authlib','searchlib'));

        $this->ci = &get_instance();
        $this->load->model(array('Question', 'User', 'QuestionsTags', 'Tag'));
    }

    public function index() {
        $this->loadHeaderData();
        $this->loadQuestions();
        $this->loadFooterData();
    }

    private function loadQuestions() {
        $questions = array();

        $questionsList = $this->Question->get();

        foreach ($questionsList as $question) {
            $user = new User();
            $user->load($question->questionId);
            //$tagsArr = array();

            $tagsArr = $this->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionTitle" => $question->questionTitle,
                "questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $user->username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }

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
