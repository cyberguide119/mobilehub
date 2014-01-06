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
class QuestionVotes extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function hasUserFlaggedQuestId($qId, $userId) {
        //$this->db->select("isClosed");
        $this->db->where(array("questionId" => $qId, "userId" => $userId));
        $question = $this->db->get("questions")->row_array();
        return (count($question) > 0);
    }

}

?>
