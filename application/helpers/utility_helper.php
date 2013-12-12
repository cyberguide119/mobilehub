<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utility
 *
 * @author DRX
 */

    function convertQueryToString($query) {
        return str_replace('+', ' ', $query);
    }

?>
