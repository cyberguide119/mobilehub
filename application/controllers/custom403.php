<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of custom403
 *
 * @author DRX
 */
class Custom403 extends MY_Controller 
{
    public function __construct()   {
            parent::__construct();  
    }
    
    /**
     * A custom forbidden access page 
     */
    public function index() 
    {
        $this->output->set_status_header('403');
        $data['content'] = 'errors/Error403'; // View name
        $this->load->view('errors/Error403',$data);//loading in my template
    }
}


?>
