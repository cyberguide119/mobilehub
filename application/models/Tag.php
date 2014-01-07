<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tag
 *
 * @author DRX
 */
class Tag extends MY_Model {

    const DB_TABLE = 'tags';
    const DB_TABLE_PK = 'tagId'; //put your code here

    public $tagId;
    public $tagName;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get the tags which needs to saved
     * @param type $tagName
     * @return type
     */
    function getTagIdToSave($tagName) {

        $tagExists = $this->db->get_where('tags', array('tagName' => $tagName));
        if ($tagExists->num_rows() > 0) {
            $tg = $tagExists->result();
            return $tg[0]->tagId;
        } else {
            $data = array('tagName' => $tagName);
            $this->db->insert('tags', $data);
            $tagExists = $this->db->get_where('tags', array('tagName' => $tagName));
            $tg = $tagExists->result();
            return $tg[0]->tagId;
        }
    }

    /**
     * Get ids of the tags
     * @param type $strTags
     * @return type
     */
    function getTagIds($strTags) {
        $strTags = explode(",", $strTags);
        $this->db->select('tagId');
        $this->db->or_where_in('tagName', $strTags);
        return $this->db->get('tags')->result_array();
    }
}
?>
