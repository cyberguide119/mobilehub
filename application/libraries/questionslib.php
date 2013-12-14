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
    }
    
    public function postQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName){
        $question = new Question();
        $user = new User();
        $questionsTag = new QuestionsTags();
        
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
        return true;
    }
    
}

?>
