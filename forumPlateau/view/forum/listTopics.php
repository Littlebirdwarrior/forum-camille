<?php
var_dump($result["data"]['topics']);
$topics = $result["data"]['topics'];

?>

<h1>liste topics</h1>

<?php
//génére topics pour chaque topic
foreach($topics as $topic) {
    echo $topic->getTitle();
}



  
