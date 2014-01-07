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
class AnswerVotes extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Check whether the user has voted
     * @param type $userId
     * @param type $ansId
     * @param type $isUpVote
     * @return boolean
     */
    function hasUserVoted($userId, $ansId, $isUpVote) {
        //$this->db->select('votedUserId','questId');
        $this->db->where(array('votedUserId' => $userId, 'ansId' => $ansId, 'isUpVote' => $isUpVote));
        $result = $this->db->get('answer_votes');

        if (count($result->result()) === 0) {
            return false;
        }
        return true;
    }
    
    /**
     * Add a vote to an answer
     * @param type $votedUserId
     * @param type $ansId
     * @param type $isUpVote
     */
    function addVote($votedUserId, $ansId, $isUpVote) {
        $this->db->where(array('votedUserId' => $votedUserId, 'ansId' => $ansId));
        $result = $this->db->get('answer_votes');
        
        if (count($result->result()) === 0) {
           $this->db->insert('answer_votes', array('votedUserId' => $votedUserId, 'ansId' => $ansId, 'isUpVote' => $isUpVote));
        }else{
            $data = array('isUpVote' => $isUpVote);
            $this->db->where(array('votedUserId' => $votedUserId, 'ansId' => $ansId));
            $this->db->update('answer_votes', $data);
        }
    }
}

?>
