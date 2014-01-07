<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissions
 *
 * @author DRX
 */
class Permissions extends MY_Model {

    const DB_TABLE = 'permissions';
    const DB_TABLE_PK = 'permId';

    public $permId;
    public $permKey;

    /**
     * Get permission id by the key
     * @param type $key
     * @return type
     */
    function getPermIdByKey($key) {
        $res = $this->db->get_where('permissions', array('permKey' => $key))->row();
        return $res->permId;
    }

}

?>
