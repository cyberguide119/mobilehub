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
    public $questionId;
    public $tagId;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function save($questionId, $tagId){
        $tagExists = $this->db->get_where('questions_tags', array('questionId' => $questionId, 'tagId' => $tagId));
        if ($tagExists->num_rows() === 0) {
            $this->db->insert('questions_tags',array('questionId' => $questionId, 'tagId' => $tagId));
        }
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
