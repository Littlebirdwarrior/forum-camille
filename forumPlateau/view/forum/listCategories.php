<?php

$categories = $result["data"]['categories'];

?>

<h1>liste categories</h1>

<?php
//génére topics pour chaque topic
foreach($categories as $categorie) {
    echo $categorie->getName();
}