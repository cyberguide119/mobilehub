<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestType
 *
 * @author DRX
 */
class RequestType extends MY_Model {

    const DB_TABLE = 'request_type';
    const DB_TABLE_PK = 'rTypeId'; //put your code here

    public $rTypeId;
    public $rName;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

}

?>
