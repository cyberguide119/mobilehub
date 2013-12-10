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
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('authlib');
        
        $this->ci = &get_instance();
        $this->load->model(array('Question', 'User', 'QuestionsTags', 'Tag'));
    }
    
    public function index()
    {
        $this->loadHeaderData();
        $this->loadQuestions();
        $this->loadFooterData();
    }
    
    private function loadHeaderData()
    {
        $loggedin = $this->authlib->is_loggedin();
        $this->load->view('common/HeaderView',array('name' => $loggedin));
        
        $data['errmsg'] = '';
        $data['subview'] = 'login/LoginView';
        $this->load->view('common/PopupView',$data);
    }
    
    private function loadFooterData()
    {
        $this->load->view('common/FooterView');
    }
    
    private function loadQuestions(){
        $questions = array();
        
        $questionsList = $this->Question->get();
        
        foreach ($questionsList as $question) {
            $user = new User();
            $user->load($question->questionId);
            $tagsArr = array();
            
            $questionsTags = $this->QuestionsTags->getTagIDsForQuestion($question->questionId);
            foreach ($questionsTags as $questTagRow){
                $tag = new Tag();
                $tag->load($questTagRow->tagId);
                $tagsArr[] = $tag->tagName;
            }
          
            // Creating the array which is to be pased on to the HomepageView
            $questions[] = array(
                "questionTitle" => $question->questionTitle,
                "questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $user->username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }
        
        $this->load->view('home/HomepageView', array(
            'questions' => $questions,
        ));
    }
    
    public function about()
    {
        $this->loadHeaderData();
        $this->load->view('home/AboutView');
        $this->loadFooterData();
    }
}

?>
