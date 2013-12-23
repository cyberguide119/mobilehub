<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of voteslib
 *
 * @author DRX
 */
class voteslib {

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('Question', 'User', 'AnswerVotes', 'QuestionVotes'));
    }

    public function voteUp($isQuestion, $pId, $username) {
        $userId = $this->ci->User->getUserIdByName($username);

        if ($isQuestion) {
            if (!($this->ci->QuestionVotes->hasUserVoted($userId, $pId, TRUE))) {

                // Put the vote to the question and add rep to the respective user
                $this->ci->QuestionVotes->addVote($userId, $pId, TRUE);
                $this->ci->Question->updateVote($pId, TRUE);
                $this->ci->User->updatePointsForQuestion($this->ci->Question->getAskerUserId($pId), 1);
                return true;
            } else {
                return false;
            }
        } else {
            // Handle answer voteup logic
            if (!($this->ci->AnswerVotes->hasUserVoted($userId, $pId, TRUE))) {

                // Put the vote to the question and add rep to the respective user
                $this->ci->AnswerVotes->addVote($userId, $pId, TRUE);
                $this->ci->Answer->updateVote($pId, TRUE);
                $this->ci->User->updatePointsForAnswer($this->ci->Answer->getAnsweredUserId($pId), 1);
                return true;
            } else {
                return false;
            }
        }
    }

    public function voteDown($isQuestion, $pId, $username) {
        $userId = $this->ci->User->getUserIdByName($username);

        if ($isQuestion) {
            if (!($this->ci->QuestionVotes->hasUserVoted($userId, $pId, FALSE))) {

                // Put the vote to the question and remove rep from the respective user
                $this->ci->QuestionVotes->addVote($userId, $pId, FALSE);
                $this->ci->Question->updateVote($pId, FALSE);
                $this->ci->User->updatePointsForQuestion($this->ci->Question->getAskerUserId($pId), -1);
                return true;
            } else {
                return false;
            }
        } else {
            // Handle answer voteup logic
        }
    }

}

?>
