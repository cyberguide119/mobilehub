<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionModel
 *
 * @author DRX
 */
class Question extends MY_Model{
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
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function basicSearch($query)
    {
        $this->db->like(array('questionTitle' => $query));
        //$this->db->select('title, content, date');
        $res = $this->db->get('questions');
        return $res->result();
    }        
}

?>
