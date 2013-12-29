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
    public $bestAnswerId;
    public $isClosed;
    public $closeReason;
    public $closedDate;
    public $closedByUserId;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 
     * @param type $query
     * @return type
     */
    function basicSearch($query) {
        $this->db->like(array('questionTitle' => $query));
        $this->db->order_by("netVotes", "desc");
        $res = $this->db->get('questions');
        return $res->result();
    }

    /**
     * 
     * @param type $advWords
     * @param type $advPhrase
     * @return type
     */
    function advancedSearch($advWords, $advPhrase) {
        if ($advPhrase !== '') {
            $this->db->like(array('questionTitle' => $advPhrase));
        }

        if (!($advWords === '')) {
            foreach ($advWords as $term) {
                $this->db->or_like('questionTitle', $term);
                $this->db->or_like('questionDescription', $term);
            }
        }
        $this->db->order_by("netVotes", "desc");
        $res = $this->db->get('questions');
        return $res->result();
    }

    /**
     * 
     * @param type $qTitle
     * @return type
     */
    function getQuestionWithTitle($qTitle) {
        $question = $this->db->get_where('questions', array('questionTitle' => $qTitle));
        $res = $question->result();
        return $res[0]->questionId;
    }

    /**
     * 
     * @return type
     */
    function getRecentQuestions() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("askedOn", "desc");
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    /**
     * 
     * @return type
     */
    function getPopularQuestions() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("netVotes", "desc");
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    /**
     * 
     * @return type
     */
    function getUnansweredQuestions() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where("answerCount", 0);
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    /**
     * 
     * @return type
     */
    function getAllQuestions() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        //$this->db->where("answerCount", 0);
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    /**
     * 
     * @param type $userId
     * @return type
     */
    function getAllQuestionsForUser($userId) {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where("askerUserId", $userId);
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    /**
     * 
     * @param type $qId
     * @return type
     */
    function getAskerUserId($qId) {
        $this->db->select("askerUserId");
        $this->db->where("questionId", $qId);
        $question = $this->db->get("questions")->row();
        return $question->askerUserId;
    }

    /**
     * 
     * @param type $qId
     * @param type $isUpVote
     */
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

    /**
     * 
     * @param type $qId
     * @return type
     */
    function getNetVotes($qId) {
        $question = $this->db->get_where('questions', array('questionId' => $qId))->row();
        return $question->netVotes;
    }

    function updateAnsCount($qId, $newCount) {
        $data = array('answerCount' => $newCount);
        $this->db->where('questionId', $qId);
        $this->db->update('questions', $data);
    }

    function getAnsCount($qId) {
        $question = $this->db->get_where('questions', array('questionId' => $qId))->row();
        return $question->answerCount;
    }

    function updateQuestion($qId, $qData) {
        $this->db->where('questionId', $qId);
        $this->db->update('questions', $qData);
    }

    function getAllQuestionsCount() {
        return $this->db->count_all('questions');
    }

    function isQuestionClosed($qId) {
        $this->db->select("isClosed");
        $this->db->where("questionId", $qId);
        $question = $this->db->get("questions")->row();
        return $question->isClosed;
    }

    function getQuestionClosedData($qId) {
        $this->db->select(array('questions.closeReason', 'questions.closedDate', 'questions.closedByUserId', 'user.username'));
        $this->db->where(array("questionId" => $qId, "isClosed" => true));
        $this->db->join('user', 'user.userId = questions.closedByUserId');
        $question = $this->db->get("questions")->row();
        return $question;
    }

}

?>
