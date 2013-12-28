<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminlib
 *
 * @author DRX
 */
class adminlib {

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('User', 'Question', 'Answer', 'Logins', 'Request'));
        $this->ci->load->library(array('questionslib', 'userlib'));
    }

    public function getBasicStats() {
        $stats['totalQuestions'] = $this->ci->Question->getAllQuestionsCount();
        $stats['totalAnswers'] = $this->ci->Answer->getAllAnswerCount();
        $stats['totalUsers'] = $this->ci->User->getAllUsersCount();
        $stats['totalLogins'] = $this->ci->Logins->getAllLogins();

        return $stats;
    }

    public function getQuestions() {
        $allQuestions = $this->ci->questionslib->getAllQuestions();
        return $allQuestions;
    }

    public function getAnswers() {

        $allAns = $this->ci->Answer->getAllAnswers();
        $resultArr = array();
        foreach ($allAns as $ans) {
            $username = $this->ci->User->getUserById($ans->answeredUserId);
            $resultArr[] = array(
                "answerId" => $ans->answerId,
                "questionId" => $ans->questionId,
                "description" => $ans->description,
                "answeredOn" => $ans->answeredOn,
                "answeredUserName" => $username,
                "votes" => $ans->netVotes,
            );
        }
        return $resultArr;
    }

    public function getUsers() {
        $allQuestions = $this->ci->userlib->getAllUsers();
        return $allQuestions;
    }

    public function deleteUser($userId) {
        if ($userId === null) {
            return false;
        }

        $username = $this->ci->User->getUserById($userId);
        $user = $this->ci->userlib->getFullUserDetails($username);
        $adminLoggedIn = $this->ci->authlib->is_loggedin();

        if (count($user['answers']) != 0) {
            foreach ($user['answers'] as $ans) {
                $this->ci->Answer->deleteAnswer($ans->answerId);
            }
        }

        if (count($user['questions']) != 0) {
            foreach ($user['questions'] as $question) {
                $this->ci->questionslib->deleteQuestion($adminLoggedIn, $question['questionId']);
            }
        }

        $this->ci->userlib->deleteUserProfile($user['user']->userId);
        return true;
    }

    public function getAdminTutorRequests() {
        $req = $this->ci->Request->getAllTutorRequests();
        return $req;
    }

    public function getAdminDeleteRequests() {
        $req = $this->ci->Request->getAllDeleteRequests();
        return $req;
    }

    public function updateRequest($isAccept, $userId, $rId) {
        $re = new Request();
        $re->load($rId);
        $re->delete();

        if ($isAccept) {
            $this->ci->userlib->makeUserActive($userId);
        } else {
            $user = new User();
            $user->load($userId);
            $user->delete();
        }
    }

}

?>
