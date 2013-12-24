<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRole
 *
 * @author DRX
 */
class UserRole extends MY_Model {

    const DB_TABLE = 'user_role';
    const DB_TABLE_PK = 'roleId';

    public $roleId;
    public $roleName;

}

?>
