<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homepage_controller
 *
 * @author DRX
 */
class Homepage extends CI_Controller {
    //put your code here
    
    public function index()
    {
        $this->load->library('authlib');
        $loggedin = $this->authlib->is_loggedin();

        if ($loggedin === false) {
            $this->load->helper('url');
            redirect('/auth/login');

        }
        $this->load->view('home/HomepageView',array('name' => $loggedin));
    }
}

?>
