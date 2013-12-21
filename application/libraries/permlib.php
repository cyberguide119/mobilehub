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
        $this->ci->load->model('role_permissions','User');
    }
    
    public function userHasPermission($username, $key){
        $this->ci->User->getUserRoleIdByName($username);
        $this->ci->checkPermission($roleId, $key);
    }
}

?>
