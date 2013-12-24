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
        $this->ci->load->model(array('Question', 'Tag', 'QuestionsTags', 'User', 'UserRole'));
        $this->ci->load->library('questionslib');
        $this->ci->load->helper('utility');
    }
    
    function getUserDetails($username){
        $userDetails = $this->ci->User->getUserDetails($username);
        
        if(count($userDetails) < 1){
            return false;
        }
        $role = new UserRole();
        $role->load($userDetails->roleId);
        $userDetails->userRole = $role->roleName;
        $questionsList = $this->ci->questionslib->getAllQuestionsForUser($userDetails->userId);
        $data['user'] = $userDetails;
        $data['questions'] = $questionsList;
        return $data;
    }

}

?>
