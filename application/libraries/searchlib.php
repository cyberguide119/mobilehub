<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of searchlib
 *
 * @author DRX
 */
class searchlib {

    //put your code here

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model('question');
    }

    public function search($query) {
        $res = $this->ci->question->basicSearch($query);
        return $res;
    }

    public function convertQueryToString($query) {
        return str_replace('+', ' ', $query);
    }

}

?>
