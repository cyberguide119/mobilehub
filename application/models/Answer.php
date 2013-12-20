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
    public $votes;
                function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAnswersForQuestionId($qId) {
        $answer = $this->db->get_where('answers', array('questionId' => $qId));
        $res = $answer->result();
        if(count($res) == 0){
            return NULL;
        }
        return $res;
    }
}

?>
