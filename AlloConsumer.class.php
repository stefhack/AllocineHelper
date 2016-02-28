<?php

require_once './api-allocine-helper.php';
require_once './DataCleaner.class.php';
/**
 * Description of AlloConsumer
 *
 * @author Mathieu
 */
class AlloConsumer {

    private $_alloHelper;
    private $_data;
    private $_dataCleaner;

    public function __construct() {
        $this->_alloHelper = new AlloHelper;
        $this->_data = array();
        $this->_dataCleaner = new DataCleaner(null);
    }

    public function consume($count = 100, $code = 25276, $filter = 'public', $strMaxLen = 200) {
        $stop = 0;
        while ($stop < $count) {
            $data = $this->getReviewList($code, $filter);
            
            foreach ($data as $review) {
                if ($count !== ($count + 1) && strlen($review["body"]) < $strMaxLen) {
                    $comment = $this->_dataCleaner->clearComment($review["body"]);
                    $record = $this->createRecord($stop + 1, array("Put categories here ;)"), $comment, ($review["rating"] * 2) / 10);
                    $this->_data[] = $record;
                    $stop++;
                    break;
                }
            }
           
            $code++;
        }
    }

    private function createRecord($id, $categories, $comment, $rating) {
        return array('id' => $id, 'catégorie' => $categories, 'commentaires' => $comment, 'polarité' => $rating);
    }

    private function getReviewList(&$code, $filter) {
        $code++;
        $reviewList = $this->_alloHelper->reviewList($code, $filter);
        return isset($reviewList->getArray()['review']) ? $reviewList->getArray()['review'] : $this->getReviewList($code, $filter);
    }


    public function getData() {
        return $this->_data;
    }

    public function getJSONData() {
        return json_encode($this->_data);
    }
    
    public function writeJSON(){

        $file = fopen("json/".date('Ymd_H_i_s').".json","w");
        fwrite($file, json_encode($this->_data));
        fclose($file);
    }
}
