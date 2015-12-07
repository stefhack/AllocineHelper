<!DOCTYPE html>
<html>
    <head>
        <title>AllocineHelper</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php
        require_once './AlloConsumer.class.php';
        require_once './AlloStats.class.php';
        require_once './DataCleaner.class.php';
        // ---------

//        $alloStats = new AlloStats('json/152311 - final.json');
//        $alloStats->displayCategories();
        
        $data_cleaner = new DataCleaner("json/151207.json");
        $data_cleaner->removeStopWords();
        // ---------
//        $alloConsumer = new AlloConsumer;
//        $alloConsumer->consume();
//        print_r($alloConsumer->getJSONData());
        ?>
    </body>
</html>