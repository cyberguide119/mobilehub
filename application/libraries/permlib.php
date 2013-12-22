<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permlib
 *
 * @author DRX
 */
class permlib {
    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('User','RolePermissions'));
    }
    
    public function userHasPermission($username, $key){
        $roleId = $this->ci->User->getUserRoleId($username);
        return $this->ci->RolePermissions->checkPermission($roleId, $key);
    }
}

?>
