<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author DRX
 */
class Request extends MY_Model{
    const DB_TABLE = 'requests';
    const DB_TABLE_PK = 'requestId'; //put your code here

    public $requestId;
    public $rTypeId;
    public $userId;
    public $rDate;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
}

?>
