<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tutorials
 *
 * @author DRX
 */
class tutorials extends MY_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('Category');
    }

    public function index() {
        $this->loadHeaderData('tutorials');
        $cat = new Category();
        $categories = $cat->get();
        $data["categories"] = $categories;
        $this->load->view('home/TutorialsView', $data);
        $this->loadFooterData();
    }

}

?>
