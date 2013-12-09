<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rest
 *
 * @author DRX
 */
class api extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('authlib','curl'));
        
        $this->ci = &get_instance();
        $this->ci->load->model('user');
    }
    
    public function _remap()
    {
        $request_method = $this->input->server('REQUEST_METHOD');
        switch (strtolower($request_method)) 
        {
            case 'post'  : $this->post();
                break;
            case 'get' : $this->get();
                break;
            default:
                show_error('Unsupported method',404); // CI function for 404 errors
                break;
        }
    }
    
    private function post()
    {
        $args = $this->uri->uri_to_assoc(1);

        switch ($args['api']) {
            case 'authenticate' :
                $res = $this->authenticate();
                // assume we get back an array of data - now echo it as JSON
                break;
            case 'create':
                break;
            default:
                show_error('Unsupported resource',404);
                break;
        }
    }
    
    public function authenticate()
    {
        $username = $this->input->post('uname');
        $password = $this->input->post('pword');
        $rememberLogin = $this->input->post('remember');
        $user = $this->authlib->login($username,$password,$rememberLogin);
        if ($user != false) {
            $response['message'] = 'correct';
        }
        else {
            $response['message'] = 'wrong';
        }
        echo json_encode($response);    
        return json_encode($response);
    }
    
    private function get()
    {
        $args = $this->uri->uri_to_assoc(1);
        switch (strtolower($args['auth'])) {
            case 'logout' :
                $this->logout();
                break;
            case 'register':
                $this->register();
                break;
            case 'forgot':
                $this->forgot();
                break;
            default:
                show_error('Unsupported resource',404);
                break;
        }
    }
}
?>
