<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionModel
 *
 * @author DRX
 */
class Question extends MY_Model {

    const DB_TABLE = 'questions';
    const DB_TABLE_PK = 'questionId';

    public $questionId;
    public $questionTitle;
    public $questionDescription;
    public $askerUserId;
    public $answerCount;
    public $askedOn;
    public $netVotes;
    public $upVotes;
    public $downVotes;
    public $categoryId;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function basicSearch($query) {
        $this->db->like(array('questionTitle' => $query));
        $this->db->or_like(array('questionDescription' => $query));
        $res = $this->db->get('questions');
        return $res->result();
    }

    function advancedSearch($advWords, $advPhrase) {
        $this->db->like(array('questionTitle' => $advPhrase));
        $this->db->or_like(array('questionDescription' => $advPhrase));

        if (!($advWords === '')) {
            foreach ($advWords as $term) {
                $this->db->or_like('questionTitle', $term);
                $this->db->or_like('questionDescription', $term);
            }
        }

        $res = $this->db->get('questions');
        return $res->result();
    }

    function getQuestionWithTitle($qTitle) {
        $question = $this->db->get_where('questions', array('questionTitle' => $qTitle));
        $res = $question->result();
        return $res[0]->questionId;
    }

    function getRecentQuestions() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("askedOn", "desc");
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    function getAskerUserId($qId) {
        $this->db->select("askerUserId");
        $this->db->where("questionId", $qId);
        $question = $this->db->get("questions")->row();
        return $question->askerUserId;
    }

    function updateVote($qId, $isUpVote) {
        $question = $this->db->get_where('questions', array('questionId' => $qId))->row();
        if ($isUpVote) {
            $newVal = $question->netVotes + 1;
            $newVal2 = $question->upVotes + 1;
            $data = array('netVotes' => $newVal, 'upVotes' => $newVal2);
        } else {
            $newVal = $question->netVotes - 1;
            $newVal2 = $question->downVotes + 1;
            $data = array('netVotes' => $newVal, 'downVotes' => $newVal2);
        }
        $this->db->where('questionId', $qId);
        $this->db->update('questions', $data);
    }

    function getNetVotes($qId) {
        $question = $this->db->get_where('questions', array('questionId' => $qId))->row();
        return $question->netVotes;
    }

}

?>
