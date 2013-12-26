<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of questionslib
 *
 * @author DRX
 */
class questionslib {

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('Question', 'User', 'Tag', 'QuestionsTags', 'QuestionVotes', 'Category', 'Answer'));
        $this->ci->load->library('searchlib');
    }

    public function postQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName) {
        $question = new Question();
        $user = new User();

        $this->ci->load->helper('date');
        $datestring = "%Y-%m-%d %h-%i-%a";
        $time = time();
        $formattedDate = mdate($datestring, $time);

        $userId = $user->getUserIdByName($qAskerName);

        $question->questionTitle = $qTitle;
        $question->questionDescription = $qDesc;
        $question->categoryId = $qCategory;
        $question->askedOn = $formattedDate;
        $question->askerUserId = $userId;
        $question->answerCount = 0;
        $question->netVotes = 0;
        $question->downVotes = 0;
        $question->upVotes = 0;

        $question->save();
        $this->saveTags($qTags, $qTitle);
        return true;
    }
    
    public function updateQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName, $qId) {
        $question = new Question();
        $question->load($qId);
        $user = new User();

        $this->ci->load->helper('date');
        $datestring = "%Y-%m-%d %h-%i-%a";
        $time = time();
        $formattedDate = mdate($datestring, $time);

        $userId = $user->getUserIdByName($qAskerName);

        $question->questionTitle = $qTitle;
        $question->questionDescription = $qDesc;
        $question->categoryId = $qCategory;
        $question->askedOn = $formattedDate;
        $question->askerUserId = $userId;
//        $question->answerCount = 0;
//        $question->netVotes = 0;
//        $question->downVotes = 0;
//        $question->upVotes = 0;

        $question->updateQuestion($qId,$question);
        //$this->saveTags($qTags, $qTitle);
        return true;
    }

    public function deleteQuestion($username, $qId) {
        $this->ci->db->delete('questions_tags', array('questionId' => $qId)); 
        $this->ci->db->delete('question_votes', array('questId' => $qId));
        $this->ci->db->delete('answers', array('questionId' => $qId)); 
        $this->ci->db->delete('questions', array('questionId' => $qId)); 
        return true;
    }

    private function saveTags($tags, $qTitle) {
        $splittedTags = explode(",", $tags);
        for ($i = 0; $i < count($splittedTags); $i++) {
            $tmpTrim = trim($splittedTags[$i]);
            $splittedTags[$i] = strtolower($tmpTrim);

            $tagToSave = new Tag();
            $tagId = $tagToSave->getTagIdToSave($splittedTags[$i]);

            $qTemp = new Question();
            $qTemp->getQuestionWithTitle($qTitle);

            $this->ci->QuestionsTags->save($qTemp->getQuestionWithTitle($qTitle), $tagId);
        }
    }

    public function getRecentQuestions() {
        $questions = array();
        $questionsList = $this->ci->Question->getRecentQuestions();
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                //"questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getPopularQuestions() {
        $questions = array();
        $questionsList = $this->ci->Question->getPopularQuestions();
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                //"questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getUnansweredQuestions() {
        $questions = array();
        $questionsList = $this->ci->Question->getUnansweredQuestions();
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                //"questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getAllQuestions() {
        $questions = array();
        $questionsList = $this->ci->Question->getAllQuestions();
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                //"questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getAllQuestionsForUser($userId) {
        $questions = array();
        $questionsList = $this->ci->Question->getAllQuestionsForUser($userId);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);
            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                //"questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getAllAnswersForUser($userId) {
        $answers = $this->ci->Answer->getAllAnswersForUser($userId);
        return $answers;
    }

    public function getQuestionDetails($qId) {
        $answers = Array();
        $question = new Question();
        $question->load($qId);
        if ($question->questionId == NULL) {
            return NULL;
        }

        $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($qId);
        $username = $this->ci->User->getUserById($question->askerUserId);
        $ansArray = $this->ci->Answer->getAnswersForQuestionId($qId);

        if ($ansArray != NULL) {
            foreach ($ansArray as $ans) {
                $answeredBy = $this->ci->User->getUserById($ans->answeredUserId);

                $answers[] = array(
                    "answerId" => $ans->answerId,
                    "description" => $ans->description,
                    "answerdUsername" => $answeredBy,
                    "votes" => $ans->netVotes,
                    "answeredOn" => $ans->answeredOn
                );
            }
        }
        
        $cat = new Category();
        $cat->load($question->categoryId);

        $questionResult = array(
            "questionTitle" => $question->questionTitle,
            "questionDescription" => $question->questionDescription,
            "askedOn" => $question->askedOn,
            "askerName" => $username,
            "answerCount" => $question->answerCount,
            "votes" => $question->netVotes,
            "tags" => $tagsArr,
            "answers" => $answers,
            "category" => $cat->categoryName
        );
        return $questionResult;
    }

    public function postAnswer($quesId, $tutorName, $description) {
        $answer = new Answer();
        $user = new User();
        $question = new Question();

        $userId = $user->getUserIdByName($tutorName);
        $question->load($quesId);
        $ansCnt = $question->answerCount + 1;

        $this->ci->Question->updateAnsCount($quesId, $ansCnt);

        $answer->questionId = $quesId;
        $answer->answeredUserId = $userId;

        $this->ci->load->helper('date');
        $datestring = "%Y-%m-%d %h-%i-%a";
        $time = time();
        $formattedDate = mdate($datestring, $time);

        $answer->answeredOn = $formattedDate;
        $answer->description = $description;
        $answer->netVotes = 0;

        $answer->save();
        return true;
    }

}

?>
