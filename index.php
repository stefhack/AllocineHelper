<!DOCTYPE>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

$file = '152311 - final.json';

$content = json_decode(file_get_contents($file));

$total = sizeof($content);
$categories = array();

for($i = 0; $i < $total; $i++) {

	$cat = $content[$i]->categories;

	for($j = 0; $j < sizeof($cat); $j++) {

		if(!array_key_exists($cat[$j], $categories)) {
			$categories[$cat[$j]] = 1;
		} else {
			$categories[$cat[$j]] = $categories[$cat[$j]] + 1;
		}
	}
}

$add = 0;

foreach($categories as $k => $v) {
	echo '<p>'.$k.' : <b>'.$v.'</b>/'.$total.'</p>';
	$add = $add + $v;
}

echo '<p>Total : <b>'.$add.'</b></p>';

/*require_once "./api-allocine-helper.php";

$helper = new AlloHelper;

$code = 27066;
$filter = 'public';
$count = 1;

try
{
    $content = array();

	while($count < 100) {
		$code++;
	    $reviewList = $helper->reviewList( $code, $filter );
		$data = $reviewList->getArray();

		for($i = 0; $i < sizeof($data["review"]); $i++) {
			$comment = $data["review"][$i]["body"];

			if(strlen($comment) < 200) {

				$comment = str_replace("\"", "'", $comment);
				$comment = str_replace("\n", " ", $comment);
				$comment = str_replace("  ", " ", $comment);
				$comment = htmlentities($comment);
				
				$record = array("id" => ($count), "categories" => array(), "comment" => $comment, "rating" => (($data["review"][$i]["rating"] * 2) / 10));
				$content[] = $record;

				$count++;

				if($count === 101) {
					break;
				}
			}
		}
	}

	$json = json_encode($content);
	echo $json;
}
catch( ErrorException $error )
{
    echo "Erreur n°", $error->getCode(), ": ", $error->getMessage(), PHP_EOL;
}*/
?>
</body>
</html>