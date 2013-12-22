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
class Permissions extends MY_Model{
    const DB_TABLE = 'permissions';
    const DB_TABLE_PK = 'permId';
    
    public $permId;
    public $permKey;
}

?>
