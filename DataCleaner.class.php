 <?php

/**
 * DataCleaner gère les fichiers JSON et ARFF
 *
 * @author Stef
 */
class DataCleaner {

    /**
     * Nom du fichier contenant les mot creux
     */
    const STOP_WORDS_FILE = "stopwords_fr.txt";

    /**
     *
     * @var string Le nom du fichier JSON 
     */
    private $json_file;

    /**
     *
     * @var array Liste des mots creux 
     */
    private $stop_words = array();

    /**
     *
     * @var array Liste des catégories uniques
     */
    private $categories = array();

    /**
     * 
     * @param string $json_file le nom du fichier des commentaires à lire
     */
    public function __construct($json_file) {
        $this->json_file = $json_file;
    }

    /**
     * Permet de lire le fichier des mots creux et les garde en mémoire
     */
    private function readStopWordsFile() {

        $file_handle = fopen(self::STOP_WORDS_FILE, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $this->stop_words[] = trim($line);
        }
        fclose($file_handle);
    }

    /**
     * 
     * @return string JSON du contenu du fichier des commentaires
     */
    private function readJsonFile() {

        $content_file = file_get_contents($this->json_file);
//        var_dump($content_file);exit;
        $content_file = str_replace(array("catégorie", "commentaires", "polarité"), array("categories", "comment", "rating"), $content_file);
        return json_decode($content_file);
    }

    /**
     * Permet de supprimer les mots creux du JSON et réécrit le fichier
     */
    public function removeStopWords() {

        $comments = $this->readJsonFile();

        $this->readStopWordsFile();
        $cleaned_json = array();

        foreach ($comments as $comment) {


            //Ajout de la catégorie si elle n'existe pas
            foreach ($comment->categories as $categorie) {
                $this->addCategorie($categorie);
            }

            $comment_words = explode(" ", $comment->comment);
            $cleaned_comment = array();

            //traitement des stopwords
            foreach ($comment_words as $word) {
                if (!in_array(strtolower(trim($word)), $this->stop_words)) {
                    array_push($cleaned_comment, $word);
                }
            }

            $test = implode(" ", $cleaned_comment);
            $comment->comment = mb_convert_encoding($test, 'UTF-8', 'auto');
            array_push($cleaned_json, $comment);
        }

        $file = fopen($this->json_file, "w");
        fwrite($file, json_encode($cleaned_json, JSON_UNESCAPED_UNICODE));
        fclose($file);
    }

    /**
     * Permet de générer le fichier ARFF à partir du JSON
     */
    public function generateArffFile($arff_path) {

        $arff_content = "@RELATION comment\r";

        $arff_content.= "@ATTRIBUTE commentaires string\r";
        $arff_content.= "@ATTRIBUTE polarite real\r";
        $arff_content.= "@ATTRIBUTE class ";
        $string_categories = "{";
        foreach ($this->categories as $categorie) {
            $string_categories.=$categorie . ",";
        }
        $string_categories = substr($string_categories, 0, -1);
        $string_categories.="}";

        $arff_content = substr($arff_content, 0, -1) . $string_categories . "\r";
        $arff_content.= "@DATA\r";
//       var_dump($this->json_file);exit;
        $comments = $this->readJsonFile();
//        var_dump($comments);exit;
        foreach ($comments as $comment) {
            foreach ($comment->categories as $categorie) {
                $arff_content.= "'" . str_replace("'"," ", $comment->comment) . "'," . $comment->rating . "," . $categorie . "\r";
            }
        }

        $file = fopen($arff_path, "w");
        fwrite($file, $arff_content);
        fclose($file);
    }

    /**
     * Permet de rajouter une catégorie si elle n'éxiste pas
     * @param string $categorie_name
     */
    private function addCategorie($categorie_name) {

        if (!in_array($categorie_name, $this->categories)) {
            array_push($this->categories, $categorie_name);
        }
    }

    public function clearComment($comment) {
        $comment = str_replace("(", "", $comment);
        $comment = str_replace(")", "", $comment);
        $comment = str_replace("\n", " ", $comment);
        $comment = str_replace("\r", " ", $comment);
        $comment = str_replace("  ", " ", $comment);
        $comment = str_replace("'", " ", $comment);
        $comment = str_replace("!", " ", $comment);
        $comment = str_replace("?", " ", $comment);
        $comment = str_replace(".", " ", $comment);
        $comment = str_replace(",", " ", $comment);               
        $comment = str_replace("\"", "'", $comment);
        $comment = str_replace("<", "", $comment);
        $comment = str_replace(">", "", $comment);
//         $comment = htmlentities($comment); 
        $comment = trim($comment);
        return $comment;
//        return mb_convert_encoding($comment, 'UTF-8', 'auto');
    }

}
