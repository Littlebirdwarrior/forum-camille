//comment récupérer les données envoyées par le controller
<?php
// comment les données envoyées par le controller
$topics = $result["data"]['topics'];
    
?>

<h1>liste topics</h1>

<?php
//génére topics pour chaque topic
foreach($topics as $topic ){

    ?>
    <p><?=$topic->getTitle()?></p>
    <?php
}


  
