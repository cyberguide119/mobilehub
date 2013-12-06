<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Answer
 *
 * @author DRX
 */
class Answer extends MY_Model{
    const DB_TABLE = 'answers';
    const DB_TABLE_PK = 'AnswerId';
    
    public $AnswerId;
    public $QuestionId;
    public $AnsweredUserId;
    public $AnsweredOn;
    public $Description;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
}

?>
