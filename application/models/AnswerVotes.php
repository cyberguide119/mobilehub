<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnswerVotes
 *
 * @author DRX
 */
class AnswerVotes extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
//    function checkUserVote($userId, $qId){
//        //$this->db->select('votedUserId','questId');
//        $this->db->where(array('votedUserId' => $userId, 'questId' => $qId));
//        $result = $this->db->get('questions_votes');
//        
//        return $result->result();
//    }
}

?>
