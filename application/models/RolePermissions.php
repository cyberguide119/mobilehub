<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RolePermissions
 *
 * @author DRX
 */
class RolePermissions extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Check if the user has permissions
     * @param type $roleId
     * @param type $permId
     * @return boolean
     */
    function checkPermission($roleId, $permId){
        $res = $this->db->get_where('role_permissions',array('roleId' => $roleId, 'permId' => $permId))->row();
        if(count($res) > 0){
            return true;
        }
        return false;
    }
}

?>
