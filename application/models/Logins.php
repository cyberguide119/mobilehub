<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logins
 *
 * @author DRX
 */
class Logins extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /*
     * 
     */
    function getAllLogins(){
        return $this->db->count_all('logins');
    }
}

?>
