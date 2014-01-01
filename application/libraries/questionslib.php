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
        $this->ci->load->library(array('searchlib', 'permlib'));
    }

    public function postQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName) {
        $question = new Question();
        $user = new User();

        $time = time();
        $formattedDate = date("Y-m-d H:i:s", $time);

        $userId = $user->getUserIdByName($qAskerName);

        $question->questionTitle = $qTitle;
        $question->questionDescription = nl2br($qDesc);
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

        $time = time();
        $formattedDate = date("Y-m-d H:i:s", $time);

        $userId = $user->getUserIdByName($qAskerName);

        $question->questionTitle = $qTitle;
        $question->questionDescription = nl2br($qDesc);
        $question->categoryId = $qCategory;
        $question->isEdited = true;
        $question->editedDate = $formattedDate;
        $question->editedByUserId = $userId;

        $question->updateQuestion($qId, $question);
        $this->saveTags($qTags, $qTitle);
        return true;
    }

    public function closeQuestion($username, $qId, $closeReason) {
        $question = new Question();
        $question->load($qId);
        $user = new User();

        if ($question->isClosed) {
            return "This question is already closed";
        }

        $time = time();
        $formattedDate = date("Y-m-d H:i:s", $time);

        $userId = $user->getUserIdByName($username);

        $question->isClosed = true;
        $question->closedDate = $formattedDate;
        $question->closeReason = $closeReason;
        $question->closedByUserId = $userId;

        $question->updateQuestion($qId, $question);
        return true;
    }

    public function deleteQuestion($username, $qId) {
        $userId = $this->ci->Question->getAskerUserId($qId);
        $user = new User();
        $user->load($userId);

        if ($user->username === $username || $this->ci->permlib->isAdmin($username)) {
            $this->ci->db->delete('questions_tags', array('questionId' => $qId));
            $this->ci->db->delete('question_votes', array('questId' => $qId));

            $ans = $this->ci->Answer->getAnswersForQuestionId($qId);
            if ($ans != null || count($ans) > 0) {
                foreach ($ans as $a) {
                    $this->ci->db->delete('answer_votes', array('ansId' => $a->answerId));
                }
            }
            $this->ci->db->delete('answers', array('questionId' => $qId));
            $this->ci->db->delete('questions', array('questionId' => $qId));
            return true;
        } else {
            return false;
        }
    }

    public function deleteAnswer($username, $ansId) {
        $userId = $this->ci->Answer->getAnsweredUserId($ansId);
        $user = new User();
        $user->load($userId);

        if ($user->username === $username || $this->ci->permlib->isAdmin($username)) {
            $qId = $this->ci->Answer->getQuestionId($ansId);
            $ansCount = $this->ci->Question->getAnsCount($qId);
            $this->ci->Question->updateAnsCount($qId, $ansCount - 1);

            $this->ci->db->delete('answer_votes', array('ansId' => $ansId));
            $this->ci->db->delete('answers', array('answerId' => $ansId));
            return true;
        } else {
            return false;
        }
    }

    public function updateAnswer($quesId, $tutorName, $description, $ansId) {
        $answer = new Answer();
        $answer->load($ansId);

        $time = time();
        $formattedDate = date("Y-m-d H:i:s", $time);
        $answer->answeredOn = $formattedDate;
        $answer->description = $description;

        $answer->updateAnswer($ansId, $answer, $quesId);
        return true;
    }

    public function promoteAnswer($quesId, $ansId) {
        $answer = new Answer();
        $answer->load($ansId);

        $question = new Question();
        $question->load($quesId);

        if ($question->bestAnswerId !== NULL || $question->bestAnswerId === 0) {
            return false;
        }

        $answer->promoteAnswer($quesId, $ansId);
        $question->updateQuestion($quesId, array("bestAnswerId" => $ansId));
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

    public function getRecentQuestions($offset) {
        $questions = array();
        $questionsList = $this->ci->Question->getRecentQuestions($offset);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getPopularQuestions($offset) {
        $questions = array();
        $questionsList = $this->ci->Question->getPopularQuestions($offset);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getUnansweredQuestions($offset) {
        $questions = array();
        $questionsList = $this->ci->Question->getUnansweredQuestions($offset);
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

    public function getAllQuestions($offset) {
        $questions = array();
        $questionsList = $this->ci->Question->getAllQuestions($offset);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getRecentQuestionsWithTag($offset, $tagname) {
        $questions = array();
        $questionsList = $this->ci->Question->getRecentQuestionsWithTag($offset, $tagname);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);
            if (in_array($tagname, $tagsArr)) {
                $questions[] = array(
                    "questionId" => $question->questionId,
                    "questionTitle" => $question->questionTitle,
                    "askedOn" => $question->askedOn,
                    "askerName" => $username,
                    "answerCount" => $question->answerCount,
                    "votes" => $question->netVotes,
                    "tags" => $tagsArr,
                );
            }
        }
        return $questions;
    }

    public function getPopularQuestionsWithTag($offset, $tagname) {
        $questions = array();
        $questionsList = $this->ci->Question->getPopularQuestionsWithTag($offset, $tagname);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getUnansweredQuestionsWithTag($offset, $tagname) {
        $questions = array();
        $questionsList = $this->ci->Question->getUnansweredQuestionsWithTag($offset, $tagname);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getAllQuestionsWithTag($offset, $tagname) {
        $questions = array();
        $questionsList = $this->ci->Question->getAllQuestionsWithTag($offset, $tagname);
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }

    public function getAllAdminQuestions() {
        $questions = array();
        $questionsList = $this->ci->Question->getAllAdminQuestions();
        foreach ($questionsList as $question) {
            $username = $this->ci->User->getUserById($question->askerUserId);
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);

            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionId" => $question->questionId,
                "questionTitle" => $question->questionTitle,
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
        $user = $this->ci->User->getThumbUserDetails($username);
        $ansArray = $this->ci->Answer->getAnswersForQuestionId($qId);

        $user->loyality = ($user->loyality === null) ? 0 : $user->loyality;
        $user->reputation = ($user->reputation === null) ? 0 : $user->reputation;
        $user->netVotes = $user->loyality + $user->reputation;

        if ($ansArray != NULL) {
            foreach ($ansArray as $ans) {
                $answeredBy = $this->ci->User->getUserById($ans->answeredUserId);

                $answers[] = array(
                    "answerId" => $ans->answerId,
                    "isBestAnswer" => $ans->isBestAnswer,
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
            "questionId" => $question->questionId,
            "questionTitle" => $question->questionTitle,
            "questionDescription" => $question->questionDescription,
            "askedOn" => $question->askedOn,
            "asker" => $user,
            "answerCount" => $question->answerCount,
            "votes" => $question->netVotes,
            "tags" => $tagsArr,
            "answers" => $answers,
            "category" => $cat->categoryName,
            "bestAnswerId" => $question->bestAnswerId
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

        $time = time();
        $formattedDate = date("Y-m-d H:i:s", $time);
        $answer->answeredOn = $formattedDate;
        $answer->description = $description;
        $answer->netVotes = 0;

        $answer->save();
        return true;
    }

    public function isQuestionClosed($qId) {
        return $this->ci->Question->isQuestionClosed($qId);
    }

    public function getQuestionClosedData($qId) {
        return $this->ci->Question->getQuestionClosedData($qId);
    }

    public function isQuestionEdited($qId) {
        return $this->ci->Question->isQuestionEdited($qId);
    }

    public function getQuestionEditedData($qId) {
        return $this->ci->Question->getQuestionEditedData($qId);
    }

}

?>
