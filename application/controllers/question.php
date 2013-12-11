<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Question
 *
 * @author DRX
 */
class Question extends MY_Controller{
    function __construct()
    {
        parent::__construct();
    }

    public function ask() {
        if ($this->authlib->is_loggedin()) {
            $this->loadHeaderData();
            $this->load->view('question/AskView');
            $this->loadFooterData();
        } else {

        }
    }
    
}

?>
