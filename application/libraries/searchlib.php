<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of searchlib
 *
 * @author DRX
 */
class searchlib {

    //put your code here

    function __construct() {
        // get a reference to the CI super-object, so we can
        // access models etc. (because we don't extend a core
        // CI class)
        $this->ci = &get_instance();
        $this->ci->load->model(array('Question', 'Tag', 'QuestionsTags', 'User'));
        $this->ci->load->helper('utility');
    }

    public function search($query) {
        $questions = array();
        $query = convertQueryToString($query);
        $res = $this->ci->Question->basicSearch($query);

        foreach ($res as $question) {
            $tagsArr = $this->getTagsArrayForQuestionId($question->questionId);
            $user = new User();
            $username = $user->getUserById($question->askerUserId);
            $questions[] = array(
                "questionTitle" => $question->questionTitle,
                "questionDescription" => $question->questionDescription,
                "askedOn" => $question->askedOn,
                "askerName" => $username,
                "answerCount" => $question->answerCount,
                "votes" => $question->netVotes,
                "tags" => $tagsArr,
            );
        }

        return $questions;
    }

    public function getTagsArrayForQuestionId($questionId) {
        $tagsArr = array();
        $questionsTags = $this->ci->QuestionsTags->getTagIDsForQuestion($questionId);
        foreach ($questionsTags as $questTagRow) {
            $tag = new Tag();
            $tag->load($questTagRow->tagId);
            $tagsArr[] = $tag->tagName;
        }
        return $tagsArr;
    }

}

?>
