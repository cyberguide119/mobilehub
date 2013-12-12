<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rest
 *
 * @author DRX
 */
class api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib', 'searchlib'));

        $this->ci = &get_instance();
        $this->ci->load->model('user');
    }

    public function _remap() {
        $request_method = $this->input->server('REQUEST_METHOD');
        switch (strtolower($request_method)) {
            case 'post' : $this->post();
                break;
            case 'get' : $this->get();
                break;
            default:
                show_error('Unsupported method', 404); // CI function for 404 errors
                break;
        }
    }

    private function get() {
        $args = $this->uri->uri_to_assoc(1);
        switch (strtolower($args['api'])) {
            case 'logout' :
                $this->logout();
                break;
            case 'search':
                $this->loadSearchLogic($args);
                break;
            case 'forgot':
                $this->forgot();
                break;
            default:
                show_error('Unsupported resource', 404);
                break;
        }
    }

    private function post() {
        $args = $this->uri->uri_to_assoc(1);
        switch ($args['api']) {
            case 'auth' :
                $this->loadAuthLogic($args);
                // assume we get back an array of data - now echo it as JSON
                break;
            case 'search':
                $this->loadSearchLogic($args);
                break;
            default:
                show_error('Unsupported resource', 404);
                break;
        }
    }

    private function loadAuthLogic($args) {
        if (array_key_exists('login', $args)) {
            $this->authenticate();
        } else if (array_key_exists('create', $args)) {
            $this->createaccount();
        } else if (array_key_exists('test', $args)) {
            // not sure yet
        }
    }

    private function loadSearchLogic($args) {
        if (array_key_exists('questions', $args)) {
            $this->searchQuestions();
        } // Check the spec
    }

    /**
     * All the methods related to index.php/api/auth
     */
    private function authenticate() {
        $username = $this->input->post('uname');
        $password = $this->input->post('pword');
        $rememberLogin = $this->input->post('remember');
        $user = $this->authlib->login($username, $password, $rememberLogin);
        if ($user != false) {
            $response['message'] = 'correct';
        } else {
            $response['message'] = 'wrong';
        }
        echo json_encode($response);
        //return json_encode($response);
    }

    private function createaccount() {
        $name = $this->input->post('name');
        $username = $this->input->post('uname');
        $password = $this->input->post('pword_confirmation');
        $conf_password = $this->input->post('pword');
        $email = $this->input->post('email');
        $website = $this->input->post('website');

        if (!($errmsg = $this->authlib->register($name, $username, $password, $conf_password, $email, $website))) {
            $response['message'] = 'success';
        } else {
            $response['message'] = $errmsg;
        }

        echo json_encode($response);
    }

    /**
     * All the methods related to index.php/api/search
     */
    private function searchQuestions() {
        $query = $this->input->get('query');
        $results = $this->searchlib->search($query);

        if (count($results) > 0) {
            $response['results'] = $results;
        } else {
            $response['results'] = "No results found";
        }

        echo json_encode($response);
    }

}

?>
