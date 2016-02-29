<!DOCTYPE html>
<html>
    <head>
        <title>AllocineHelper</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <h2>Bienvenue sur l'application TextMining</h2>
        <fieldset>
            <legend><h3>Génération du fichier JSON </h3></legend>
        <form action="generate_json.php">
          Nombre de commentaires : <input type="number" name="nb_comment">
          Nombre max de caractères par commentaire :<input type="number" min="50"  max="1000" name="max_character">
        <input type="submit" value="Générer">
        </form>  
            
        </fieldset>
                            
                
        <fieldset>                
            <legend><h3>Traitement du fichier JSON </h3></legend>
        <form action="process_json_file.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="json_file"/>
            <input type="submit" value="Obtenir le ARFF">
        </form> 
             <?php 
        
        if(isset($_GET['download_file'])){?>
        <a href="<?php echo $_GET['download_file'] ?>" download="">Fichier Arff</a>
        <?php }
        ?>
        </fieldset>
       
        
       
        
        <fieldset>
            <legend><h3>Traitement du fichier ARFF</h3></legend>
        <form action="process_arff_file.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="arff_file"/>
            <br>
            <label>Regression : </label>
            <input type="checkbox" name="regression">
            <br>
            <label>IDF : </label>
            <input type="checkbox" name="IDF">
            <br>
            <label>TF: </label>
            <input type="checkbox" name="TF">
            <br>
            <label>Nb Folds Cross-Validation : </label>
            <input type="number" min="1" max="10" name="folds">
            <br>
            <label>Tokenizer : </label>
            <select name="tokenizer">
                <option value="Alphabetical">Alphabetical</option>
                <option value="NGram">NGram</option>
                <option value="Word" selected>Word</option>
            </select>
            <br>
            <label>Stemmer : </label>
            <select name="stemmer">
                <option value="NullStemmer">NullStemmer</option>
                 <option value="LovinsStemmer">LovinsStemmer</option>    
               <option value="IteratedLovinsStemmer">IteratedLovinsStemmer</option>
            </select>
            <input type="submit" value="Traiter le fichier avec Weka">
        </form>
        </fieldset>
            
                 
        <?php
        session_start();
        if(isset($_SESSION['result_classification'])){?>
        <div >
            <h1>Résultats du traitement WEKA : </h1>
            <?php 
//            var_dump($_SESSION['result_classification']);
            foreach($_SESSION['result_classification'] as $response_row){
                echo $response_row."<br>";
            } ?>
        </div>
       
        <?php }
        ?>
        
        
        <?php
       
        // ---------
//        include_once 'AlloStats.class.php';
//        $alloStats = new AlloStats('json/152311 - final.json');
//        $alloStats->displayCategories();
//         $alloConsumer = new AlloConsumer;
//        $alloConsumer->consume();
//        print_r($alloConsumer->getJSONData());
//        $alloConsumer->writeJSON();
        
//        $data_cleaner = new DataCleaner("json/data.json");
//        $data_cleaner->removeStopWords();
//        $data_cleaner->generateArffFile();
        // ---------
//        $alloConsumer = new AlloConsumer;
//        $alloConsumer->consume();
//        print_r($alloConsumer->getJSONData());
//        $alloConsumer->writeJSON();
//        ?>
    </body>
</html>