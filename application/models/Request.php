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
class Request extends MY_Model {

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

    function getAllTutorRequests() {
        $this->db->select(array('requests.requestId', 'requests.userId', 'user.username', 'user.email', 'requests.rDate', 'request_types.rName'));
        $this->db->from('requests');
        $this->db->where('requests.rTypeId', 2); 
        $this->db->join('request_types', 'request_types.rTypeId = requests.rTypeId');
        $this->db->join('user', 'user.userId = requests.userId');

        $query = $this->db->get();
        return $query->result();
    }
    
    function getAllDeleteRequests() {
        $this->db->select(array('requests.requestId', 'requests.userId', 'user.username', 'user.email', 'requests.rDate', 'request_types.rName'));
        $this->db->from('requests');
        $this->db->where('requests.rTypeId', 1); 
        $this->db->join('request_types', 'request_types.rTypeId = requests.rTypeId');
        $this->db->join('user', 'user.userId = requests.userId');

        $query = $this->db->get();
        return $query->result();
    }

}

?>
