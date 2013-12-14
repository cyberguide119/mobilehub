<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author DRX
 */
class Category extends MY_Model {

    const DB_TABLE = 'category';
    const DB_TABLE_PK = 'categoryId'; //put your code here

    public $categoryId;
    public $categoryName;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

}

?>
