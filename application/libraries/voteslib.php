<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of voteslib
 *
 * @author DRX
 */
class voteslib {
    
    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('Question', 'User', 'AnswerVotes', 'QuestionVotes'));
    }
    
    public function voteUp($isQuestion, $pId, $username){
        $userId = $this->ci->User->getUserIdByName($username);
        
        if($isQuestion){
            $output = $this->ci->QuestionVotes->checkUserVote($userId, $pId);
            return $output;
        }else{
            
        }
    }
    
    public function voteDown($isQuestion, $id, $userId){
        if($isQuestion){
            
        }else{
            
        }
    }
}

?>
