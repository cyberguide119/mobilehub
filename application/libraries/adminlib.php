<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminlib
 *
 * @author DRX
 */
class adminlib {

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('User', 'Question', 'Answer', 'Logins'));
        $this->ci->load->library(array('questionslib'));
    }

    public function getBasicStats() {
        $stats['totalQuestions'] = $this->ci->Question->getAllQuestionsCount();
        $stats['totalAnswers'] = $this->ci->Answer->getAllAnswerCount();
        $stats['totalUsers'] = $this->ci->User->getAllUsersCount();
        $stats['totalLogins'] = $this->ci->Logins->getAllLogins();
        
        return $stats;
    }
    
    public function getQuestions(){
        $allQuestions = $this->ci->questionslib->getAllQuestions();
        return $allQuestions;
//        $refinedQuestions = array();
//        foreach ($allQuestions as $quest){
//            var_dump($quest);
//            
//        }
    }

}

?>
