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
class Categories extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Category');
    }

    /**
     * Show the category according to the given url
     */
    public function index() {
        $this->show();
    }

    /**
     * Method tol load the Category view
     */
    public function show() {
        $results = $this->uri->segment(3);
        if ($results === false) {
            redirect('custom404');
        }
        $this->loadHeaderData('tags');
        $data["results"] = $results;
        $cat = new Category();
        $categories = $cat->get();
        $data["categories"] = $categories;
        $data["categoryName"] = $results;
        $this->load->view('home/CategoryView', $data);
        $this->loadFooterData();
    }

}
?>
