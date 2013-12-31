<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author DRX
 */
class Tags extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Category');
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $results = $this->uri->segment(3);
        if ($results === false) {
            redirect('custom404');
        }
        $this->loadHeaderData();
        $data["results"] = $results;
        $cat = new Category();
        $categories = $cat->get();
        $data["categories"] = $categories;
        $data["tagname"] = $results;
        $this->load->view('home/TagsView', $data);
        $this->loadFooterData();
    }

}
?>
