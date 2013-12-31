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
class Logins extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
     * 
     */

    function getAllLogins() {
        return $this->db->count_all('logins');
    }

    function getLoginChartDetails() {
        // Get most recent 7 days
        $time = time();
        $formattedDate = date("Y-m-d", $time);

        $date = new DateTime($formattedDate);
        $date->sub(new DateInterval('P7D'));
        $aWeekBack = $date->format('Y-m-d');

        $query = $this->db->query("SELECT loginDate, count(name) AS value FROM logins WHERE loginDate BETWEEN '" . $aWeekBack . "'" .
                " AND '" . $formattedDate . "' GROUP BY loginDate");

        return $query->result();
        //return $this->db->get('logins')->result();
        //var_dump($formattedDate, $aWeekBack);
    }

}

?>
