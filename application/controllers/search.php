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
class Search extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Category');
    }

    public function index() {
        $results = $this->input->get('query');
        $this->results($results);
    }

    /**
     * load the results page in which we load the results of the search query
     * @param type $results
     */
    private function results($results) {
        $this->loadHeaderData('search');
        $data["results"] = $results;
        $cat = new Category();
        $categories = $cat->get();
        $data["categories"] = $categories;
        $this->load->view('search/SearchResultsView', $data);
        $this->loadFooterData();
    }

}

?>
