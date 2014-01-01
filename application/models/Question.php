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
    public $isEdited;
    public $editedDate;
    public $editedByUserId;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 
     * @param type $query
     * @return array
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
     * @return array
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
    function getRecentQuestions($offset) {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("askedOn", "desc");
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getRecentQuestionsWithTag($offset, $tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("questions.askedOn", "desc");
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getRecentQuestionsWithTagCount($tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("questions.askedOn", "desc");
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $query = $this->db->get("questions");
        return ceil($query->num_rows() / 10);
    }

    function getRecentQuestionsCount() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("askedOn", "desc");
        $query = $this->db->get('questions');
        return ceil($query->num_rows() / 10);
    }

    /**
     * 
     * @return type
     */
    function getPopularQuestions($offset) {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("netVotes", "desc");
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getPopularQuestionsCount() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("netVotes", "desc");
        $query = $this->db->get('questions');
        return ceil($query->num_rows() / 10);
    }

    function getPopularQuestionsWithTag($offset, $tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("questions.netVotes", "desc");
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getPopularQuestionsWithTagCount($tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->order_by("questions.netVotes", "desc");
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $query = $this->db->get("questions");
        return ceil($query->num_rows() / 10);
    }

    /**
     * 
     * @return type
     */
    function getUnansweredQuestions($offset) {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where("answerCount", 0);
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getUnansweredQuestionsWithTag($offset, $tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where("questions.answerCount", 0);
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getUnansweredQuestionsWithTagCount($tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where("questions.answerCount", 0);
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $query = $this->db->get("questions");
        return ceil($query->num_rows() / 10);
    }

    function getUnansweredQuestionsCount() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where("answerCount", 0);
        $query = $this->db->get('questions');
        return ceil($query->num_rows() / 10);
    }

    /**
     * 
     * @return type
     */
    function getAllQuestions($offset) {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getAllQuestionsWithTag($offset, $tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $questions = $this->db->get("questions", 10, $offset);
        return $questions->result();
    }

    function getAllQuestionsWithTagCount($tagname) {
        $this->db->select("questions.questionId, questions.questionTitle, questions.questionDescription, questions.askerUserId, answerCount, askedOn, netVotes,categoryId");
        $this->db->where('tags.tagName', $tagname);
        $this->db->join('questions_tags', 'questions_tags.questionId = questions.questionId');
        $this->db->join('tags', 'tags.tagId = questions_tags.tagId');
        $query = $this->db->get("questions");
        return ceil($query->num_rows() / 10);
    }

    function getAllAdminQuestions() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $questions = $this->db->get("questions");
        return $questions->result();
    }

    function getAllQuestionsCounts() {
        $this->db->select("questionId, questionTitle, questionDescription, askerUserId, answerCount, askedOn, netVotes,categoryId");
        $query = $this->db->get("questions");
        return ceil($query->num_rows() / 10);
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

    /**
     * 
     * @param type $qId
     * @param type $newCount
     */
    function updateAnsCount($qId, $newCount) {
        $data = array('answerCount' => $newCount);
        $this->db->where('questionId', $qId);
        $this->db->update('questions', $data);
    }

    /**
     * 
     * @param type $qId
     * @return int
     */
    function getAnsCount($qId) {
        $question = $this->db->get_where('questions', array('questionId' => $qId))->row();
        return $question->answerCount;
    }

    /**
     * 
     * @param type $qId
     * @param type boolean
     */
    function updateQuestion($qId, $qData) {
        $this->db->where('questionId', $qId);
        $this->db->update('questions', $qData);
    }

    /**
     * 
     * @return array
     */
    function getAllQuestionsCount() {
        return $this->db->count_all('questions');
    }

    /**
     * 
     * @param type $qId
     * @return boolean
     */
    function isQuestionClosed($qId) {
        $this->db->select("isClosed");
        $this->db->where("questionId", $qId);
        $question = $this->db->get("questions")->row();
        return $question->isClosed;
    }

    /**
     * 
     * @param type $qId
     * @return array
     */
    function getQuestionClosedData($qId) {
        $this->db->select(array('questions.closeReason', 'questions.closedDate', 'questions.closedByUserId', 'user.username'));
        $this->db->where(array("questionId" => $qId, "isClosed" => true));
        $this->db->join('user', 'user.userId = questions.closedByUserId');
        $question = $this->db->get("questions")->row();
        return $question;
    }

    function isQuestionEdited($qId) {
        $this->db->select("isEdited");
        $this->db->where("questionId", $qId);
        $question = $this->db->get("questions")->row();
        return $question->isEdited;
    }

    /**
     * 
     * @param type $qId
     * @return array
     */
    function getQuestionEditedData($qId) {
        $this->db->select(array('questions.editedDate', 'questions.editedByUserId', 'user.username', 'user.loyality', 'user.reputation'));
        $this->db->where(array("questionId" => $qId, "isEdited" => true));
        $this->db->join('user', 'user.userId = questions.editedByUserId');
        $question = $this->db->get("questions")->row();
        return $question;
    }

    /**
     * 
     * @return type array
     */
    function getQueChartDetails() {
        // Get most recent 7 days
        $time = time();
        $formattedDate = date("Y-m-d", $time);

        $date = new DateTime($formattedDate);
        $date->sub(new DateInterval('P7D'));
        $aWeekBack = $date->format('Y-m-d');

        $query = $this->db->query("SELECT DATE(askedOn) AS queDate, count(questionId) AS value FROM questions WHERE askedOn BETWEEN '" . $aWeekBack . "'" .
                " AND '" . $formattedDate . "' GROUP BY queDate");

        return $query->result();
    }

}

?>
