<?php

require_once './api-allocine-helper.php';

/**
 * Description of AlloConsumer
 *
 * @author Mathieu
 */
class AlloConsumer {

    private $_alloHelper;
    private $_data;

    public function __construct() {
        $this->_alloHelper = new AlloHelper;
        $this->_data = array();
    }

    public function consume($count = 100, $code = 27076, $filter = 'public', $strMaxLen = 200) {
        $stop = 0;
        while ($stop < $count) {
            $data = $this->getReviewList($code, $filter);
            
            foreach ($data as $review) {
                if ($count !== ($count + 1) && strlen($review["body"]) < $strMaxLen) {
                    $comment = $this->clearComment($review["body"]);
                    $record = $this->createRecord($stop + 1, array(), $comment, ($review["rating"] * 2) / 10);
                    $this->_data[] = $record;
                    $stop++;
                }
            }
           
            $code++;
        }
    }

    private function createRecord($id, $categories, $comment, $rating) {
        return array('id' => $id, 'categories' => $categories, 'comment' => $comment, 'rating' => (($rating * 2) / 10));
    }

    private function getReviewList(&$code, $filter) {
        $code++;
        $reviewList = $this->_alloHelper->reviewList($code, $filter);
        return isset($reviewList->getArray()['review']) ? $reviewList->getArray()['review'] : $this->getReviewList($code, $filter);
    }

    private function clearComment($comment) {
        $comment = str_replace("\"", "'", $comment);
        $comment = str_replace("\n", " ", $comment);
        $comment = str_replace("  ", " ", $comment);
        $comment = str_replace("'", " ", $comment);
        $comment = str_replace("!", " ", $comment);
        $comment = str_replace("?", " ", $comment);
        $comment = str_replace(".", " ", $comment);
        $comment = str_replace(",", " ", $comment);
        $comment = htmlentities($comment);

        return $comment;
    }

    public function getData() {
        return $this->_data;
    }

    public function getJSONData() {
        return json_encode($this->_data);
    }

}
