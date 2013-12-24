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
class Api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('authlib', 'searchlib', 'questionslib', 'voteslib', 'permlib', 'userlib'));

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
            case 'tags':
                $this->loadTagsLogic($args);
                break;
            case 'question':
                $this->loadQuestionLogic($args);
                break;
            case 'user':
                $this->loadProfileLogic($args);
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
            case 'question':
                $this->loadQuestionLogic($args);
                break;
            case 'vote':
                $this->loadVoteLogic($args);
                break;
            case 'answer':
                $this->loadAnswerLogic($args);
                break;
            case 'user':
                $this->loadProfileLogic($args);
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
        } else if (array_key_exists('logout', $args)) {
            // not sure yet
        }
    }

    private function loadSearchLogic($args) {
        if (in_array('advanced', $args)) {
            $this->advSearchQuestions();
        } else if (array_key_exists('questions', $args)) {
            $this->searchQuestions(); //Won't be needing this
        }// Check the spec
    }

    private function loadQuestionLogic($args) {
        if (array_key_exists('post', $args)) {
            $this->postQuestion();
        } else if (array_key_exists('details', $args)) {
            $this->getDetails($args);
        } else if (array_key_exists('recent', $args)) {
            $this->getRecent($args);
        } else if (array_key_exists('popular', $args)) {
            $this->getPopular($args);
        } else if (array_key_exists('unanswered', $args)) {
            $this->getUnanswered($args);
        } else if (array_key_exists('all', $args)) {
            $this->getAll($args);
        }
    }

    private function loadTagsLogic($args) {
        if (array_key_exists('all', $args)) {
            $this->getAllTags();
        }
    }

    private function loadVoteLogic($args) {
        if (array_key_exists('voteup', $args)) {
            $this->voteUp($args['voteup']);
        } else if (array_key_exists('votedown', $args)) {
            $this->voteDown($args['votedown']);
        } else {
            $response['message'] = 'Error';
            return $response;
        }
    }

    private function loadAnswerLogic($args) {
        if (array_key_exists('post', $args)) {
            $this->postAnswer();
        }
    }

    private function loadProfileLogic($args) {
        if (array_key_exists('details', $args)) {
            $this->getUserDetails($args['details']);
        } else if (array_key_exists('fulldetails', $args)) {
            $this->getFullUserDetails($args['fulldetails']);
        } else if (array_key_exists('post', $args)) {
            $this->updateUserDetails($args['post']);
        }
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

    private function advSearchQuestions() {
        $advWords = $this->input->post('Words');
        $advPhrase = $this->input->post('Phrase');
        $advTags = $this->input->post('Tags');
        $advCategory = $this->input->post('Category');

        $results = $this->searchlib->advSearch($advWords, $advPhrase, $advTags, $advCategory);
        if (count($results) > 0) {
            $response['message'] = "Success";
            $response['results'] = $results;
        } else {
            $response['results'] = "No results found";
        }

        echo json_encode($response);
    }

    /**
     * All the methods related to questions
     */
    private function postQuestion() {
        $qTitle = $this->input->post('Title');
        $qDesc = $this->input->post('Description');
        $qTags = $this->input->post('Tags');
        $qCategory = $this->input->post('Category');
        $qAskerName = $this->input->post('AskerName');

        if ($this->questionslib->postQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName)) {
            $response["message"] = "Success";
        } else {
            $response["message"] = "Error";
        }

        echo json_encode($response);
    }

    private function getDetails($args) {
        $questionId = $args['details'];
        $questionDetails = $this->questionslib->getQuestionDetails($questionId);

        if ($questionDetails != NULL) {
            $response["message"] = "Success";
            $response['questionDetails'] = $questionDetails;
        } else {
            $response["message"] = "Error";
        }

        echo json_encode($response);
    }

    private function getRecent() {
        $questions = $this->ci->questionslib->getRecentQuestions();
        $response['results'] = $questions;
        echo json_encode($response);
    }

    private function getPopular() {
        $questions = $this->ci->questionslib->getPopularQuestions();
        $response['results'] = $questions;
        echo json_encode($response);
    }

    private function getUnanswered() {
        $questions = $this->ci->questionslib->getUnansweredQuestions();
        $response['results'] = $questions;
        echo json_encode($response);
    }

    private function getAll() {
        $questions = $this->ci->questionslib->getAllQuestions();
        $response['results'] = $questions;
        echo json_encode($response);
    }

    /**
     * All methods related to tags
     */
    private function getAllTags() {
        $allTags = $this->Tag->get();
        echo json_encode($allTags);
    }

    /**
     * All methods related to voting
     */
    private function voteUp($arg) {
        if (strtolower($arg) === "question") {
            $qId = $this->input->post('questionId');
            $username = $this->input->post('username');

            if (!($this->authlib->is_loggedin() === $username)) {
                $response['message'] = 'Error';
                $response['type'] = 'You need to login before voting!';
                echo json_encode($response);
                return;
            } else if ($username === $this->User->getUserById($this->Question->getAskerUserId($qId))) {
                $response['message'] = 'Error';
                $response['type'] = 'You cannot vote on your own question!';
                echo json_encode($response);
                return;
            } else {
                $votes = $this->voteslib->voteUp(TRUE, $qId, $username);
                if ($votes == TRUE) {
                    $response['message'] = 'Success';
                    $response['votes'] = $this->ci->Question->getNetVotes($qId);
                    echo json_encode($response);
                } else {
                    $response['message'] = 'Error';
                    $response['type'] = 'You have already voted on this question!';
                    echo json_encode($response);
                    return;
                }
            }
        } else if (strtolower($arg) === "answer") {
            $ansId = $this->input->post('answerId');
            $username = $this->input->post('username');

            if (!($this->authlib->is_loggedin() === $username)) {
                $response['message'] = 'Error';
                $response['type'] = 'You need to login before voting!';
                echo json_encode($response);
                return;
            } else if ($username === $this->User->getUserById($this->Answer->getAnsweredUserId($ansId))) {
                $response['message'] = 'Error';
                $response['type'] = 'You cannot vote on your own answer!';
                echo json_encode($response);
                return;
            } else {
                $votes = $this->voteslib->voteUp(FALSE, $ansId, $username);
                if ($votes == TRUE) {
                    $response['message'] = 'Success';
                    $response['votes'] = $this->ci->Answer->getNetVotes($ansId);
                    echo json_encode($response);
                } else {
                    $response['message'] = 'Error';
                    $response['type'] = 'You have already voted on this question!';
                    echo json_encode($response);
                    return;
                }
            }
        } else {
            $response['message'] = 'Error';
            $response['type'] = 'Malformed URL!';
            echo json_encode($response);
        }
    }

    private function voteDown($arg) {
        if (strtolower($arg) === "question") {
            $qId = $this->input->post('questionId');
            $username = $this->input->post('username');

            if (!($this->authlib->is_loggedin() === $username)) {
                $response['message'] = 'Error';
                $response['type'] = 'You need to login before voting!';
                echo json_encode($response);
                return;
            } else if ($username === $this->User->getUserById($this->Question->getAskerUserId($qId))) {
                $response['message'] = 'Error';
                $response['type'] = 'You cannot vote on your own question!';
                echo json_encode($response);
                return;
            } else {
                $votes = $this->voteslib->voteDown(TRUE, $qId, $username);
                if ($votes != FALSE) {
                    $response['message'] = 'Success';
                    $response['votes'] = $this->ci->Question->getNetVotes($qId);
                    echo json_encode($response);
                } else {
                    $response['message'] = 'Error';
                    $response['type'] = 'You have already voted on this question!';
                    echo json_encode($response);
                    return;
                }
            }
        } else if (strtolower($arg) === "answer") {
            $ansId = $this->input->post('answerId');
            $username = $this->input->post('username');

            if (!($this->authlib->is_loggedin() === $username)) {
                $response['message'] = 'Error';
                $response['type'] = 'You need to login before voting!';
                echo json_encode($response);
                return;
            } else if ($username === $this->User->getUserById($this->Answer->getAnsweredUserId($ansId))) {
                $response['message'] = 'Error';
                $response['type'] = 'You cannot vote on your own answer!';
                echo json_encode($response);
                return;
            } else {
                $votes = $this->voteslib->voteDown(FALSE, $ansId, $username);
                if ($votes == TRUE) {
                    $response['message'] = 'Success';
                    $response['votes'] = $this->ci->Answer->getNetVotes($ansId);
                    echo json_encode($response);
                } else {
                    $response['message'] = 'Error';
                    $response['type'] = 'You have already voted on this question!';
                    echo json_encode($response);
                    return;
                }
            }
        } else {
            $response['message'] = 'Error';
            $response['type'] = 'Malformed URL!';
            echo json_encode($response);
        }
    }

    /**
     * All methods related to Answers
     */
    private function postAnswer() {
        $quesId = $this->input->post('questionId');
        $tutorName = $this->input->post('username');
        $description = $this->input->post('description');

        if ($tutorName) {
            if ($this->permlib->userHasPermission($tutorName, "ANSWER_QUESTION")) {
                if ($this->questionslib->postAnswer($quesId, $tutorName, $description)) {
                    $response["message"] = "Success";
                } else {
                    $response["message"] = "Error";
                    $response["type"] = "Oops, something went wrong!";
                }
            } else {
                $response["message"] = "Error";
                $response["type"] = "Sorry, you need to have permissions to post an answer. You may want to request for a tutor account.";
            }
        } else {
            $response["message"] = "Error";
            $response["type"] = "You need to log in before posting an answer";
        }

        echo json_encode($response);
    }

    /**
     * All methods related to user profiles
     */
    private function getUserDetails($username) {
        $res = $this->userlib->getUserDetails($username);

        if ($res === false) {
            $res = array("message" => "Error", "type" => "User not found");
        }
        echo json_encode($res);
    }

    private function getFullUserDetails($username) {
        $name = $this->authlib->is_loggedin();
        if ($name === $username) {
            $res = $this->userlib->getFullUserDetails($username);
            echo json_encode($res);
        }

        if ($name === false) {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
        }
    }
    
    private function updateUserDetails($username) {
        $name = $this->authlib->is_loggedin();
        if ($name === $username) {
            $in = $this->input->post(NULL,true);
            $res = $this->userlib->updateUserDetails($username,$in);
            echo json_encode($res);
        }

        if ($name === false) {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
        }
    }

}

?>
