<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tag
 *
 * @author DRX
 */
class Tag extends MY_Model{
    const DB_TABLE = 'tags';
    const DB_TABLE_PK = 'tagId';//put your code here
    
    public $tagId;
    public $tagName;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
}

?>
