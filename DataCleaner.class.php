<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataCleaner
 *
 * @author Stef
 */
class DataCleaner {

    const STOP_WORDS_FILE = "stopwords_fr.txt";

    private $json_file;
    private $stop_words = array();

    public function __construct($json_file) {
        $this->json_file = $json_file;
    }

    private function readStopWordsFile() {

        $file_handle = fopen(self::STOP_WORDS_FILE, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $this->stop_words[] = trim($line);
        }
        fclose($file_handle);
    }

    public function removeStopWords() {

        $comments = json_decode(file_get_contents($this->json_file));

        $this->readStopWordsFile();
        $cleaned_json = array();

        foreach ($comments as $comment) {
            $comment_words = explode(" ", $comment->comment);
            $cleaned_comment = array();

            foreach ($comment_words as $word) {
                if (!in_array(strtolower(trim($word)), $this->stop_words)) {
                  
                    array_push($cleaned_comment, $word);
                }
            }

            $test = implode(" ", $cleaned_comment);
            $comment->comment = mb_convert_encoding($test, 'UTF-8', 'auto');
            array_push($cleaned_json, $comment);
        }

//        file_put_contents('json/test.json', json_encode($cleaned_json));
//        $file = fopen("json/test.json","w");
//        fwrite($file,  json_encode($cleaned_json));
//        fclose($file);
        var_dump($cleaned_json);
    }

}
