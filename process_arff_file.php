<?php


session_start();
unset($_SESSION['result_classification']);
$file_name = $_FILES['arff_file']['name'];



$is_regression_on = isset($_POST['regression']) ? 'true' : 'false';
$is_IDF_on = isset($_POST['IDF']) ? 'true' : 'false';
$is_TF_on = isset($_POST['TF'])  ? 'true' : 'false';
$nb_folds = $_POST['folds'];
$stemmer = $_POST['stemmer'];
$tokenizer = $_POST['tokenizer'];
$arff_folder = "arff/";
$path_file= $arff_folder.$file_name;



if(move_uploaded_file($_FILES['arff_file']['tmp_name'],$path_file)){
            
  exec("java -jar C:\Users\Stef\Documents\TextMining\dist\TextMining.jar "
          . "C:/wamp/www/AllocineHelper/arff/".$file_name." "//arg[0] Path ARFF file
          . $is_regression_on." "//args[1] Regression : true/ false
          . $nb_folds." "//args[2] Nb folds for Cross validation
          . $is_IDF_on." "//args[3] IDF Transform: true/ false
          . $is_TF_on." "//args[4] TF Transform : true/ false
          . $stemmer." "//args[5] Le type de stemmer sous forme de string
          . $tokenizer,//args[6] Le type de tokenizer sous forme de string
          $output, $return_var);

    $_SESSION['result_classification']=$output; 
    
    echo utf8_encode("Fichier ARFF traité avec succés ! Vous allez être redirigé vers les résultats ");
}
else{
    echo utf8_encode('Problème dans le déplacement du fichier : '.$path_file);
}



header("refresh:5;url=index.php");