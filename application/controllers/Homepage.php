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
        $this->load->view('common/HeaderView',array('name' => $loggedin));
        
        $data['errmsg'] = '';
        $data['subview'] = 'login/LoginView';
        $this->load->view('common/PopupView',$data);
        
        //$this->load->view('home/HomepageView',array('errmsg' => NULL));
        $this->load->view('common/FooterView');
    }
}

?>
