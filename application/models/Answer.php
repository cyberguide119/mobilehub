<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Answer
 *
 * @author DRX
 */
class Answer extends MY_Model {

    const DB_TABLE = 'answers';
    const DB_TABLE_PK = 'answerId';

    public $answerId;
    public $questionId;
    public $answeredUserId;
    public $answeredOn;
    public $description;
    public $netVotes;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAnswersForQuestionId($qId) {
        $answer = $this->db->get_where('answers', array('questionId' => $qId));
        $res = $answer->result();
        if (count($res) == 0) {
            return NULL;
        }
        return $res;
    }

    public function getAnsweredUserId($ansId) {
        $this->db->select("answeredUserId");
        $this->db->where("answerId", $ansId);
        $answer = $this->db->get("answers")->row();
        if($answer === null || count($answer) === 0){
            return false;
        }
        return $answer->answeredUserId;
    }

    public function getNetVotes($ansId) {
        $answer = $this->db->get_where('answers', array('answerId' => $ansId))->row();
        return $answer->netVotes;
    }

    function updateVote($qId, $isUpVote) {
        $answer = $this->db->get_where('answers', array('answerId' => $qId))->row();
        if ($isUpVote) {
            $newVal = $answer->netVotes + 1;
            $newVal2 = $answer->upVotes + 1;
            $data = array('netVotes' => $newVal, 'upVotes' => $newVal2);
        } else {
            $newVal = $answer->netVotes - 1;
            $newVal2 = $answer->downVotes + 1;
            $data = array('netVotes' => $newVal, 'downVotes' => $newVal2);
        }
        $this->db->where('answerId', $qId);
        $this->db->update('answers', $data);
    }

    function getAllAnswersForUser($userId) {
        $this->db->select(array('answerId', 'questionId', 'answeredOn', 'description', 'netVotes'));
        $answers = $this->db->get_where('answers', array('answeredUserId' => $userId));
        return $answers->result();
    }

    function getQuestionId($ansId) {
        $this->db->select('questionId');
        $answers = $this->db->get_where('answers', array('answerId' => $ansId))->row();
        return $answers->questionId;
    }

    function updateAnswer($ansId, $data, $qId) {
        $this->db->where(array('answerId' => $ansId, 'questionId' => $qId));
        $this->db->update('answers', $data);
    }

    function getAllAnswerCount() {
        return $this->db->count_all('answers');
    }

    function getAllAnswers() {
        //$this->db->select(array('answerId', 'answeredUserId', 'answeredOn', 'description', 'netVotes'));
        return $this->db->get('answers')->result();
    }

}

?>
