<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionsTags
 *
 * @author DRX
 */
class QuestionsTags extends CI_Model{
//    const DB_TABLE = 'questions_tags';
//    const DB_TABLE_PK = '$questionId';//put your code here
//    
    public $questionId;
    public $tagId;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function save($questionId, $tagId){
        $this->db->insert('questions_tags',array('questionId' => $questionId, 'tagId' => $tagId));
    }
    
    function getTagIDsForQuestion($questionId)
    {
        $this->db->select('tagId');
        $this->db->where('questionId',$questionId);
        $result = $this->db->get('questions_tags');
        
        return $result->result();
    }
}

?>
