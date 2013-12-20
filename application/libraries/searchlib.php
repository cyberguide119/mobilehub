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
                "questionId" => $question->questionId,
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

    public function advSearch($advWords, $advPhrase, $advTags, $advCategory) {
        $questions = array();
        $questionsArr = $this->ci->Question->advancedSearch($this->splitWords($advWords), $advPhrase);
        $tagsArr = $this->splitTags($advTags);
        
        if($advTags !== ''){
            $res = $this->filterQuestionsByTag($questionsArr, $tagsArr);
        }else{
            $res = $questionsArr;
        }

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

    private function filterQuestionsByTag($questionsArr, $tagsArr) {
        foreach ($questionsArr as $question) {
            $tagsNameArr = $this->getTagsArrayForQuestionId($question->questionId);
            foreach ($tagsArr as $tagName) {
                if (!(in_array($tagName, $tagsNameArr))) {
                    if (($key = array_search($question, $questionsArr)) !== false) {
                        unset($questionsArr[$key]);
                    }
                }
            }
        }
        return $questionsArr;
    }

    private function splitWords($wordsStr) {
        if($wordsStr === '')
            return $wordsStr;
        $splittedWords = explode(" ", $wordsStr);
        for ($i = 0; $i < count($splittedWords); $i++) {
            $splittedWords[$i] = trim($splittedWords[$i]);
        }
        return $splittedWords;
    }

    private function splitTags($advTags) {
        $splittedTags = explode(",", $advTags);
        for ($i = 0; $i < count($splittedTags); $i++) {
            $tmpTrim = trim($splittedTags[$i]);
            $splittedTags[$i] = strtolower($tmpTrim);
        }
        return $splittedTags;
    }
}

?>
