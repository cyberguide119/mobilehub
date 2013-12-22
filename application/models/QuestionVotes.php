<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionVotes
 *
 * @author DRX
 */
class QuestionVotes extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function hasUserVoted($userId, $qId) {
        //$this->db->select('votedUserId','questId');
        $this->db->where(array('votedUserId' => $userId, 'questId' => $qId));
        $result = $this->db->get('question_votes');

        if (count($result->result()) === 0) {
           return false;
        }
        return true;
    }
    
    function addVote($votedUserId, $loyalityGainedUserId, $qId) {
        $this->db->insert('question_votes',array('votedUserId' => $votedUserId, 'loyalityGainedUserId' => $loyalityGainedUserId, 'questId' => $qId));
    }

}

?>
