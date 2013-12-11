<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Custom404
 *
 * @author DRX
 */
class Custom404 extends MY_Controller 
{
    public function __construct()   {
            parent::__construct();  
    }
    public function index() 
    {
        $this->output->set_status_header('404');
        $data['content'] = 'errors/Error404'; // View name
        $this->load->view('errors/Error404',$data);//loading in my template
    }
}

?>
