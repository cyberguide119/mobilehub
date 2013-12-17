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
        $this->ci->load->model(array('Question','User','Tag','QuestionsTags','Category'));
        $this->ci->load->library('searchlib');
    }
    
    public function postQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName){
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
    
    private function saveTags($tags, $qTitle){
        $splittedTags = explode(",", $tags);
        for($i = 0; $i<count($splittedTags); $i++)
        {
            $tmpTrim = trim($splittedTags[$i]);
            $splittedTags[$i] = strtolower($tmpTrim);
            
            $tagToSave = new Tag();
            $tagId = $tagToSave->getTagIdToSave($splittedTags[$i]);
            
            $qTemp = new Question();
            $qTemp->getQuestionWithTitle($qTitle);
            
            $this->ci->QuestionsTags->save($qTemp->getQuestionWithTitle($qTitle),$tagId);
        }
    }
    
    public function getRecentQuestions(){
        $questions = array();
        $questionsList = $this->ci->Question->getRecentQuestions();
        foreach ($questionsList as $question) {
            //$user = new User();
            $username = $this->ci->User->getUserById($question->askerUserId);
            //$tagsArr = array();
            $tagsArr = $this->ci->searchlib->getTagsArrayForQuestionId($question->questionId);
            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionTitle" => $question->questionTitle,
                "questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        return $questions;
    }
}

?>
