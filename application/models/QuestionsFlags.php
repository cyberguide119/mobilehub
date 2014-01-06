<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionsFlags
 *
 * @author DRX
 */
class QuestionsFlags extends MY_Model {

    const DB_TABLE = 'questions_flags';
    const DB_TABLE_PK = 'flagId';

    public $flagId;
    public $questionId;
    public $userId;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function hasUserFlaggedQuestId($qId, $userId) {
        //$this->db->select("isClosed");
        $this->db->where(array("questionId" => $qId, "userId" => $userId));
        $question = $this->db->get("questions_flags")->row_array();
        return (count($question) > 0);
    }

}

?>
