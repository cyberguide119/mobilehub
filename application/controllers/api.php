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
        $this->load->library(array('authlib', 'searchlib', 'questionslib', 'voteslib', 'permlib', 'userlib', 'adminlib'));

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
            case 'admin':
                $this->loadAdminLogic($args);
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
            $this->getRecent($args['recent']);
        } else if (array_key_exists('popular', $args)) {
            $this->getPopular($args['popular']);
        } else if (array_key_exists('unanswered', $args)) {
            $this->getUnanswered($args['unanswered']);
        } else if (array_key_exists('all', $args)) {
            $this->getAll($args['all']);
        } else if (array_key_exists('delete', $args)) {
            $this->deleteQuestion();
        } else if (array_key_exists('update', $args)) {
            $this->updateQuestion($args);
        } else if (array_key_exists('close', $args)) {
            $this->closeQuestion();
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
        } else if (array_key_exists('delete', $args)) {
            $this->deleteAnswer();
        } else if (array_key_exists('update', $args)) {
            $this->updateAnswer();
        }
    }

    private function loadProfileLogic($args) {
        if (array_key_exists('details', $args)) {
            $this->getUserDetails($args['details']);
        } else if (array_key_exists('fulldetails', $args)) {
            $this->getFullUserDetails($args['fulldetails']);
        } else if (array_key_exists('post', $args)) {
            $this->updateUserDetails($args['post']);
        } else if (array_key_exists('delete', $args)) {
            $this->deleteUserProfile();
        } else if (array_key_exists('changepassword', $args)) {
            $this->changeUserPassword($args['changepassword']);
        }
    }

    private function loadAdminLogic($args) {
        if (array_key_exists('details', $args)) {
            $this->getDashboardDetails($args['details']);
        } else if (array_key_exists('question', $args)) {
            $this->getAdminQuestions();
        } else if (array_key_exists('answer', $args)) {
            $this->getAdminAnswers();
        } else if (array_key_exists('user', $args)) {
            if ($args['user'] === 'details') {
                $this->getAdminUsers();
            } else if ($args['user'] === 'delete') {
                $this->getAdminDeleteUsers();
            }
        } else if (array_key_exists('requests', $args)) {
            if ($args['requests'] === 'tutor') {
                $this->getAdminTutorRequests();
            } else if ($args['requests'] === 'delete') {
                $this->getAdminDeleteRequests();
            }
        } else if (array_key_exists('tutor', $args)) {
            if ($args['tutor'] === 'accept') {
                $this->updateAdminTutorRequests(true);
            } else if ($args['tutor'] === 'decline') {
                $this->updateAdminTutorRequests(false);
            }
        } else if (array_key_exists('deletion', $args)) {
            $this->getAdminDeleteUserOnRequest();
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
        if ($user) {
            $isAdmin = $this->permlib->isAdmin($user['username']);
            $response['isAdmin'] = $isAdmin;
        }

        if ($user != false) {
            $response['message'] = 'correct';
        } else {
            $response['message'] = 'wrong';
        }
        echo json_encode($response);
    }

    private function createaccount() {
        $name = $this->input->post('name');
        $username = $this->input->post('uname');
        $password = $this->input->post('pword_confirmation');
        $conf_password = $this->input->post('pword');
        $email = $this->input->post('email');
        $website = $this->input->post('website');

        $isTutor = $this->input->post('isTutor');
        if ($isTutor === 'true') {
            // Register as a tutor
            $linkedin = $this->input->post('linkedIn');
            $sourl = $this->input->post('sOProfile');
            if (!($errmsg = $this->authlib->registerTutor($name, $username, $password, $conf_password, $email, $website, $linkedin, $sourl))) {
                $req = new Request();
                $time = time();
                $formattedDate = date("Y-m-d H:i:s", $time);
                $req->rDate = $formattedDate;
                $req->rTypeId = 2;
                $req->userId = $this->ci->User->getUserIdByName($username);
                $req->save();
                $response['message'] = 'Success';
                $response['type'] = 'Your request was sent successfully. You will be emailed when accepted by our admins';
            } else {
                $response['message'] = 'Error';
                $response['type'] = $errmsg;
            }
            echo json_encode($response);
        } else {
            // Register as a student
            if (!($errmsg = $this->authlib->register($name, $username, $password, $conf_password, $email, $website))) {
                $response['message'] = 'Success';
                $response['type'] = 'Your account was created successfully! Please log in.';
            } else {
                $response['message'] = 'Error';
                $response['type'] = $errmsg;
            }
            echo json_encode($response);
        }
    }

    /**
     * All the methods related to index.php/api/search
     */
    private function searchQuestions() {
        $query = $this->input->get('query');
        if (strlen($query) < 3) {
            $response['message'] = "Error";
            $response['type'] = "You need to enter atleast 3 characters to perform a search";
        } else {
            $results = $this->searchlib->search($query);
            if (count($results) > 0) {
                $response['message'] = "Success";
                $response['results'] = $results;
            } else {
                $response['message'] = "Error";
                $response['type'] = "Sorry, your query returned no matches!";
            }
        }
        echo json_encode($response);
    }

    private function advSearchQuestions() {
        $advWords = $this->input->post('Words');
        $advPhrase = $this->input->post('Phrase');
        $advTags = $this->input->post('Tags');
        $advCategory = $this->input->post('Category');

        if (strlen($advPhrase) < 3 && ($advWords === '' && $advTags === '' && $advCategory === '0')) {
            $response['message'] = "Error";
            $response['type'] = "Please enter more than 3 character to search";
        } else {
            $results = $this->searchlib->advSearch($advWords, $advPhrase, $advTags, $advCategory);
            if (count($results) > 0) {
                $response['message'] = "Success";
                $response['results'] = $results;
            } else {
                $response['message'] = "Error";
                $response['type'] = "Sorry, your query returned no matches!";
            }
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

    private function getRecent($offset) {
        ($offset === NULL) ? 0 : $offset;
        $questions = $this->ci->questionslib->getRecentQuestions($offset);
        $response['results'] = $questions;
        $response['totalCount'] = $this->ci->Question->getRecentQuestionsCount();
        echo json_encode($response);
    }

    private function getPopular($offset) {
        ($offset === NULL) ? 0 : $offset;
        $questions = $this->ci->questionslib->getPopularQuestions($offset);
        $response['results'] = $questions;
        $response['totalCount'] = $this->ci->Question->getPopularQuestionsCount();
        echo json_encode($response);
    }

    private function getUnanswered($offset) {
        ($offset === NULL) ? 0 : $offset;
        $questions = $this->ci->questionslib->getUnansweredQuestions($offset);
        $response['results'] = $questions;
        $response['totalCount'] = $this->ci->Question->getUnansweredQuestionsCount();
        echo json_encode($response);
    }

    private function getAll($offset) {
        ($offset === NULL) ? 0 : $offset;
        $questions = $this->ci->questionslib->getAllQuestions($offset);
        $response['results'] = $questions;
        $response['totalCount'] = $this->ci->Question->getAllQuestionsCounts();
        echo json_encode($response);
    }

    private function deleteQuestion() {
        $username = $this->input->post('username');
        $qId = $this->input->post('questionId');

        $name = $this->authlib->is_loggedin();
        if ($name === $username) {
            $status = $this->questionslib->deleteQuestion($username, $qId);
            if ($status) {
                $res = array("message" => "Success", "type" => "Question was deleted successfully!");
                echo json_encode($res);
            } else {
                $res = array("message" => "Error", "type" => "You do not have permissions to delete this question");
                echo json_encode($res);
            }
        } else {
            $res = array("message" => "Error", "type" => "You do not have permissions to delete this question");
            echo json_encode($res);
        }

        if ($name === false) {
            $res = array("message" => "Error", "type" => "You do not have permissions to delete this question");
            echo json_encode($res);
        }
    }

    private function updateQuestion() {
        $qTitle = $this->input->post('Title');
        $qDesc = $this->input->post('Description');
        $qTags = $this->input->post('Tags');
        $qCategory = $this->input->post('Category');
        $qAskerName = $this->input->post('AskerName');
        $qId = $this->input->post('questionId');

        $name = $this->authlib->is_loggedin();
        if ($name === $qAskerName) {
            $this->questionslib->updateQuestion($qTitle, $qDesc, $qTags, $qCategory, $qAskerName, $qId);
            $res = array("message" => "Success", "type" => "Question was updated successfully!");
            echo json_encode($res);
        }

        if ($name === false) {
            $res = array("message" => "Error", "type" => "You do not have permissions to edit the question");
            echo json_encode($res);
        }
    }

    private function closeQuestion() {
        $qId = $this->input->post('questionId');
        $username = $this->input->post('username');
        $closeReason = $this->input->post('reason');

        $name = $this->authlib->is_loggedin();
        if ($name === $username) {
            if ($this->permlib->userHasPermission($username, "ANSWER_QUESTION")) {
                $result = $this->questionslib->closeQuestion($username, $qId, $closeReason);
                if ($result === true) {
                    $res = array("message" => "Success", "type" => "Question was closed successfully!");
                    echo json_encode($res);
                } else {
                    $res = array("message" => "Success", "type" => "Question was closed successfully!");
                    echo json_encode($res);
                }
            } else {
                $res = array("message" => "Error", "type" => "You do not have permissions to close the question");
                echo json_encode($res);
            }
        }

        if ($name === false || $name !== $username) {
            $res = array("message" => "Error", "type" => "You do not have permissions to close the question");
            echo json_encode($res);
        }
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
                if ($this->questionslib->isQuestionClosed($quesId)) {
                    $response["message"] = "Error";
                    $response["type"] = "This question is closed. Therefore you cannot post an answer.";
                } else {
                    if ($this->questionslib->postAnswer($quesId, $tutorName, $description)) {
                        $response["message"] = "Success";
                    } else {
                        $response["message"] = "Error";
                        $response["type"] = "Oops, something went wrong!";
                    }
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

    private function deleteAnswer() {
        $username = $this->input->post('username');
        $ansId = $this->input->post('answerId');

        $name = $this->authlib->is_loggedin();
        if ($name === $username) {
            $status = $this->questionslib->deleteAnswer($username, $ansId);
            if ($status) {
                $res = array("message" => "Success", "type" => "Answer was deleted successfully!");
                echo json_encode($res);
                return;
            } else {
                $res = array("message" => "Error", "type" => "You do not have permissions to delete this answer");
                echo json_encode($res);
                return;
            }
        } else {
            $res = array("message" => "Error", "type" => "You do not have permissions to delete this answer");
            echo json_encode($res);
            return;
        }

        if ($name === false) {
            $res = array("message" => "Error", "type" => "You do not have permissions to delete this answer");
            echo json_encode($res);
            return;
        }
    }

    private function updateAnswer() {
        $quesId = $this->input->post('questionId');
        $tutorName = $this->input->post('username');
        $description = $this->input->post('description');
        $ansId = $this->input->post('answerId');

        $name = $this->authlib->is_loggedin();
        if ($name) {
            if ($this->permlib->userHasPermission($tutorName, "ANSWER_QUESTION")) {
                if ($this->questionslib->updateAnswer($quesId, $tutorName, $description, $ansId)) {
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

        if ($name === false || $name != $username) {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
        }
    }

    private function updateUserDetails($username) {
        $name = $this->authlib->is_loggedin();
        if ($name === $username) {
            $in = $this->input->post(NULL, true);
            $res = $this->userlib->updateUserDetails($username, $in);
            echo json_encode($res);
        }

        if ($name === false || $name !== $username) {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
        }
    }

    private function deleteUserProfile() {
        $name = $this->authlib->is_loggedin();
        $username = $this->input->post('username');
        $hash = $this->input->post('pword');
        if ($name === $username) {
            if ($this->userlib->deactiveUserProfile($username, $hash)) {
                $this->authlib->logout();
                $res = array("message" => "Success", "type" => "User deactivated successfully");
                echo json_encode($res);
                return;
            } else {
                $res = array("message" => "Error", "type" => "Something went wrong");
                echo json_encode($res);
                return;
            }
        } else {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
            return;
        }

        if ($name === false) {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
            return;
        }
    }

    private function changeUserPassword($username) {
        $name = $this->authlib->is_loggedin();
        if ($name === $username) {

            $username = $this->input->post('username');
            $oldPw = $this->input->post('oldPw');
            $newPw = $this->input->post('newPw');
            $res = $this->userlib->updatePassword($username, $oldPw, $newPw);
            if ($res === true) {
                $res = array("message" => "Success", "type" => "Password changed successfully");
                echo json_encode($res);
            } else {
                $res = array("message" => "Error", "type" => $res);
                echo json_encode($res);
            }
        }

        if ($name === false || $name !== $username) {
            $res = array("message" => "Error", "type" => "You do not have permissions");
            echo json_encode($res);
        }
    }

    /**
     * All methods related to admin dashboard
     */
    private function getDashboardDetails($option) {
        if ($option === 'basic') {
            $name = $this->authlib->is_loggedin();
            $username = $this->input->post('username');
            if ($username === $name && $username === 'admin') {
                $reponse['message'] = "Success";
                $reponse['data'] = $this->adminlib->getBasicStats();
                echo json_encode($reponse);
            } else {
                $reponse['message'] = "Error";
                $reponse['type'] = "You are not authorized to view this content";
                echo json_encode($reponse);
            }
        }
    }

    private function getAdminQuestions() {
        $name = $this->authlib->is_loggedin();
        //$username = $this->input->post('username');
        if ($name) {
            $reponse['message'] = "Success";
            $reponse['aaData'] = $this->adminlib->getQuestions();
            echo json_encode($reponse);
        } else {
            $reponse['message'] = "Error";
            $reponse['type'] = "You are not authorized to view this content";
            echo json_encode($reponse);
        }
    }

    private function getAdminAnswers() {
        $name = $this->authlib->is_loggedin();
        //$username = $this->input->post('username');
        if ($name) {
            $reponse['message'] = "Success";
            $reponse['aaData'] = $this->adminlib->getAnswers();
            echo json_encode($reponse);
        } else {
            $reponse['message'] = "Error";
            $reponse['type'] = "You are not authorized to view this content";
            echo json_encode($reponse);
        }
    }

    private function getAdminUsers() {
        $name = $this->authlib->is_loggedin();
        //$username = $this->input->post('username');
        if ($name) {
            $reponse['message'] = "Success";
            $reponse['aaData'] = $this->adminlib->getUsers();
            echo json_encode($reponse);
        } else {
            $reponse['message'] = "Error";
            $reponse['type'] = "You are not authorized to view this content";
            echo json_encode($reponse);
        }
    }

    private function getAdminDeleteUsers() {
        $name = $this->authlib->is_loggedin();
        //$username = $this->input->post('username');
        $userId = $this->input->post('userId');
        if ($name && $userId != null) {
            if ($this->adminlib->deleteUser($userId)) {
                $reponse['message'] = "Success";
                $reponse['type'] = "User deleted successfully";
                echo json_encode($reponse);
            } else {
                $reponse['message'] = "Error";
                $reponse['type'] = "Something went wrong";
                echo json_encode($reponse);
            }
        } else {
            $reponse['message'] = "Error";
            $reponse['type'] = "You are not authorized to view this content";
            echo json_encode($reponse);
        }
    }

    private function getAdminTutorRequests() {
        $name = $this->authlib->is_loggedin();
        //$username = $this->input->post('username');
        if ($name) {
            $reponse['message'] = "Success";
            $reponse['aaData'] = $this->adminlib->getAdminTutorRequests();
            echo json_encode($reponse);
        } else {
            $reponse['message'] = "Error";
            $reponse['type'] = "You are not authorized to view this content";
            echo json_encode($reponse);
        }
    }

    private function getAdminDeleteRequests() {
        $name = $this->authlib->is_loggedin();
        //$username = $this->input->post('username');
        if ($name) {
            $reponse['message'] = "Success";
            $reponse['aaData'] = $this->adminlib->getAdminDeleteRequests();
            echo json_encode($reponse);
        } else {
            $reponse['message'] = "Error";
            $reponse['type'] = "You are not authorized to view this content";
            echo json_encode($reponse);
        }
    }

    private function updateAdminTutorRequests($isAccept) {
        $name = $this->authlib->is_loggedin();
        $userId = $this->input->post('tutorId');
        $rId = $this->input->post('rId');

        if ($isAccept) {
            // Accept logic
            if ($name) {
                $reponse['message'] = "Success";
                $this->adminlib->updateRequest(true, $userId, $rId);
                $reponse['type'] = "Tutor profile activated!";
                echo json_encode($reponse);
            } else {
                $reponse['message'] = "Error";
                $reponse['type'] = "You are not authorized to view this content";
                echo json_encode($reponse);
            }
        } else {
            // Decline logic
            if ($name) {
                $reponse['message'] = "Success";
                $this->adminlib->updateRequest(false, $userId, $rId);
                $reponse['type'] = "Tutor profile deleted!";
                echo json_encode($reponse);
            } else {
                $reponse['message'] = "Error";
                $reponse['type'] = "You are not authorized to view this content";
                echo json_encode($reponse);
            }
        }
    }

    private function getAdminDeleteUserOnRequest() {
        $rId = $this->input->post('rId');
        $req = new Request();
        $req->load($rId);
        $req->delete();
        $this->getAdminDeleteUsers();
    }

}

?>
