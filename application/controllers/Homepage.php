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
        $this->loadQuestions();
        
        //$this->load->view('home/HomepageView',array('errmsg' => NULL));
        $this->load->view('common/FooterView');
    }
    
    private function loadQuestions(){
         //$this->load->view('bootstrap/header');
        $this->load->library('table');
        $questions = array();
        $this->load->model(array('Question', 'User'));
        $questionsList = $this->Question->get();
        foreach ($questionsList as $question) {
            $user = new User();
            $user->load($question->questionId);            
            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionTitle" => $question->questionTitle,
                "questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $user->username,
            );
        }
//        $this->load->view('home/HomepageView',$questions);
        $this->load->view('home/HomepageView', array(
            'questions' => $questions,
        ));
        //$this->load->view('bootstrap/footer');
    }
}

?>
