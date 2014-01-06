<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userlib
 *
 * @author DRX
 */
class userlib {

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('Question', 'User', 'UserRole', 'Answer'));
        $this->ci->load->library('questionslib');
        $this->ci->load->helper('utility');
    }

    /**
     * 
     * @param type $username
     * @return boolean
     */
    function getUserDetails($username) {
        $userDetails = $this->ci->User->getUserDetails($username);

        if (count($userDetails) < 1) {
            return false;
        }

        $role = new UserRole();
        $role->load($userDetails->roleId);
        $userDetails->userRole = $role->roleName;

        $questionsList = $this->ci->questionslib->getAllQuestionsForUser($userDetails->userId);
        $answersList = $this->ci->questionslib->getAllAnswersForUser($userDetails->userId);

        $data['user'] = $userDetails;
        $data['questions'] = $questionsList;
        $data['answers'] = $answersList;
        return $data;
    }

    /**
     * 
     * @param type $username
     * @return boolean
     */
    function getFullUserDetails($username) {
        $role = new UserRole();
        $user = $this->ci->User->getUserDetails($username);
        $role->load($user->roleId);
        $userDetails = $this->ci->User->getFullUserDetails($username, $role->roleName);
        $userDetails->userRole = $role->roleName;
        if (count($userDetails) < 1) {
            return false;
        }
        $questionsList = $this->ci->questionslib->getAllQuestionsForUser($userDetails->userId);
        $answersList = $this->ci->questionslib->getAllAnswersForUser($userDetails->userId);

        $data['user'] = $userDetails;
        $data['questions'] = $questionsList;
        $data['answers'] = $answersList;
        return $data;
    }

    /**
     * 
     * @param type $username
     * @param type $dataArr
     * @return string
     */
    function updateUserDetails($username, $dataArr) {
        $userId = $this->ci->User->getUserIdByName($username);
        $this->ci->User->updateUserDetails($userId, $dataArr);
        $response['message'] = 'Success';
        $response['type'] = 'User profile updated successfully!';
        return $response;
    }

    /**
     * 
     * @param type $username
     * @param type $oldPw
     * @param type $newPw
     * @return boolean
     */
    function updatePassword($username, $oldPw, $newPw) {
        $res = $this->ci->User->updatePassword($username, $oldPw, $newPw);
        if ($res === true) {
            return true;
        } else {
            return $res;
        }
    }

    /**
     * 
     * @return array
     */
    function getAllUsers() {
        return $this->ci->User->getAllUsers();
    }

    /**
     * 
     * @param type $userId
     * @return type
     */
    function deleteUserProfile($userId) {
        return $this->ci->User->deleteUser($userId);
    }

    /**
     * 
     * @param type $userId
     */
    function makeUserActive($userId) {
        $this->ci->User->activateUser($userId);
    }

    /**
     * 
     * @param type $username
     * @param type $hash
     * @return boolean
     */
    function deactiveUserProfile($username, $hash) {
        if ($this->ci->User->deactivateUser($username, $hash)) {
            $req = new Request();
            $time = time();
            $formattedDate = date("Y-m-d H:i:s", $time);
            $req->rDate = $formattedDate;
            $req->rTypeId = 1;
            $req->userId = $this->ci->User->getUserIdByName($username);
            $req->save();
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param type $username
     * @return boolean
     */
    function isProfileActive($username){
        return $this->ci->User->isProfileActive($this->ci->User->getUserIdByName($username));
    }
    
    function getUserPoints($username){
        $res = $this->ci->User->getUserPoints($this->ci->User->getUserIdByName($username));
        ($res->reputation === NULL) ? $res->reputation = 0 : $res->reputation = $res->reputation;
        ($res->loyality === NULL) ? $res->loyality = 0 : $res->loyality = $res->loyality;
        return $res->reputation + $res->loyality;
    }

}

?>
