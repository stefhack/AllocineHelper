<?php
ini_set('max_execution_time', 60);
require_once 'AlloConsumer.class.php';

$nb_comment = $_GET['nb_comment'];
$max_character = $_GET['max_character'];

//$alloStats = new AlloStats('json/'.date('dmY_H_i_s').'- final.json');
//$alloStats->displayCategories();
$alloConsumer = new AlloConsumer;
$alloConsumer->consume($nb_comment,20179,null,$max_character);
print_r($alloConsumer->getJSONData());
$alloConsumer->writeJSON();
