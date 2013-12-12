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
        $this->ci->load->model(array('Question','Tag','QuestionsTags'));
        $this->ci->load->helper('utility');
    }

    public function search($query) {
        $query = convertQueryToString($query);
        $res = $this->ci->question->basicSearch($query);
        return $res;
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
