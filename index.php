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

        // ---------

        $alloStats = new AlloStats('json/152311 - final.json');
        $alloStats->displayCategories();

        // ---------
        //$alloConsumer = new AlloConsumer;
        //$alloConsumer->consume();
        //var_dump($alloConsumer->getJSONData());
        ?>
    </body>
</html>