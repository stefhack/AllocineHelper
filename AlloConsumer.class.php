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

    public function consume($count = 100, $code = 27066, $filter = 'public') {
        $stop = 0;
        while ($stop < $count) {
            $data = $this->getReviewList($code, $filter);
            foreach ($data["review"] as $review) {
                if ($count !== ($count + 1) && strlen($review["body"] < 200)) {
                    $comment = $this->clearComment($review["body"]);
                    $record = $this->createRecord($count, array(), $comment, ($review["rating"] * 2) / 10);
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

    private function getReviewList($code, $filter) {
        $reviewList = $this->_alloHelper->reviewList($code, $filter);
        return $reviewList->getArray();
    }

    private function clearComment($comment) {
        $c1 = str_replace("\"", "'", $comment);
        $c2 = str_replace("\n", " ", $c1);
        $c3 = str_replace("  ", " ", $c2);
        $c4 = htmlentities($c3);
        return $c4;
    }

    public function getData() {
        return $this->_data;
    }

    public function getJSONData() {
        return json_encode($this->_data);
    }

}
