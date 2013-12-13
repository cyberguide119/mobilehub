<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author DRX
 */
class Search extends MY_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $results = $this->input->get('query');
        $this->results($results);
        //var_dump($results);
    }
    
    private function results($results){
        $this->loadHeaderData();
        $data["results"] = $results;
        $this->load->view('search/SearchResultsView',$data);
        $this->loadFooterData();        
    }
    
    // do the advanced search pagge..that's all
}

?>
