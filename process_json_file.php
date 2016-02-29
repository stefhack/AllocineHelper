<?php

require_once './DataCleaner.class.php';


$file_name = $_FILES['json_file']['name'];
$json_folder = "json/";
$path_folder = $json_folder."uploaded/";

$arff_folder = "arff/";
$arff_file= $arff_folder.$file_name.date('H_i_s').".arff";

if(move_uploaded_file($_FILES['json_file']['tmp_name'],$path_folder.$file_name)){
    $data_cleaner = new DataCleaner($path_folder.$file_name);
$data_cleaner->removeStopWords();
$data_cleaner->generateArffFile($arff_folder.$file_name.date('H_i_s').".arff");
echo utf8_encode('Le fichier :' .$arff_folder.$file_name.date('H_i_s').".arff a bien été généré ! ");
}
else{
    echo utf8_encode('Déplacement du ficher impossible vers '.$path_folder.$file_name.' ! ');
}


header("refreash:5;url=index.php?download_file=".$arff_file);

