<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlloStats
 *
 * @author Mathieu
 */
class AlloStats {

    private $_filePath;
    private $_data;

    public function __construct($filePath) {
        $this->_filePath = $filePath;
        $this->_data = json_decode(file_get_contents($this->_filePath));
    }

    
    public function displayCategories() {

        $allCategories = $this->getCategories();
        $categoriesCounter = 0;
        $totalRecords = sizeof($this->_data);

        echo '<fieldset>';
        echo '<legend>Categories du fichier : '.$this->_filePath.'</legend>';

        foreach ($allCategories as $key => $value) {
            echo '<p>' . $key . ' : <b>' . $value . '</b></p>';
            $categoriesCounter = $categoriesCounter + $value;
        }

        echo '<p>Total categories : <b>' . $categoriesCounter . '</b></p>';
        echo '<p>Total records : <b>' . $totalRecords . '</b></p>';

        echo '</fieldset>';
    }

    private function getCategories() {
        $categories = array();
        foreach ($this->_data as $record) {
            $categoriesFromRecord = $record->categories;
            foreach ($categoriesFromRecord as $categorie) {
                if (!array_key_exists($categorie, $categories)) {
                    $categories[$categorie] = 1;
                } else {
                    $categories[$categorie] = $categories[$categorie] + 1;
                }
            }
        }
        return $categories;
    }

}
