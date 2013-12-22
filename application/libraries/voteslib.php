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
                return $this->ci->Question->getNetVotes($pId);
            } else {
                return false;
            }
        } else {
            // Handle answer voteup logic
        }
    }

    public function voteDown($isQuestion, $pId, $username) {
        $userId = $this->ci->User->getUserIdByName($username);

        if ($isQuestion) {
            if (!($this->ci->QuestionVotes->hasUserVoted($userId, $pId, FALSE))) {

                // Put the vote to the question and remove rep from the respective user
                $this->ci->QuestionVotes->addVote($userId, $pId, FALSE);
                $this->ci->Question->updateVote($pId, FALSE);
                return $this->ci->Question->getNetVotes($pId);
            } else {
                return false;
            }
        } else {
            // Handle answer voteup logic
        }
    }

}

?>
