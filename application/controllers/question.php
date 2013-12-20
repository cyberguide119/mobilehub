<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Question
 *
 * @author DRX
 */
class Question extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Category');
    }

    public function ask() {
        if ($this->authlib->is_loggedin()) {
            $this->loadHeaderData();
            $cat = new Category();
            $categories = $cat->get();
            $this->load->view('question/AskView', array("categories" => $categories));
            $this->loadFooterData();
        } else {
            $this->loadHeaderData();
            $this->load->view('errors/ErrorNotLoggedIn');
            $this->loadFooterData();
        }
    }

    public function show() {
        $qId = $this->input->get('id');
        $data['questionId'] = $qId;
        $this->loadHeaderData();
        $this->load->view('question/QuestionView', $data);
        $this->loadFooterData();
    }

//    public function search() {
//        $query = $this->input->get('query');
//        $ch = curl_init();
//        //$useragent = isset($z['useragent']) ? $z['useragent'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2';
//        $cookie = (isset($_COOKIE['ci_session'])) ? 'ci_session=' . urlencode($_COOKIE['ci_session']) : '';
//        $httpua = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
//        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
//        curl_setopt($ch, CURLOPT_USERAGENT, $httpua);
//        curl_setopt($ch, CURLOPT_URL, 'http://localhost/MobileHub/index.php/api/search/questions?query='.$query);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        //curl_setopt($ch, CURLOPT_AUTOREFERER, true);
//        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//        //curl_setopt($ch, CURLOPT_, $query);
//        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//
//        //if( isset($z['post']) )         curl_setopt( $ch, CURLOPT_POSTFIELDS, $z['post'] );
//        //if( isset($z['refer']) )        curl_setopt( $ch, CURLOPT_REFERER, $z['refer'] );
//
//        //curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
//        //curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, ( isset($z['timeout']) ? $z['timeout'] : 5 ) );
//        //curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
//        //curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
//
//        $result = curl_exec($ch);
//        curl_close($ch);
//        echo $result;
//    }
}

?>
