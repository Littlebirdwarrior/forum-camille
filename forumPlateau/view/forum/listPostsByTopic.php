<?php
//var_dump($result["data"]['posts']->current()); die;
$posts = $result["data"]['posts'];
$topicId = $_GET['id']; //ici, la valeur de l'id est récupérée par l'url
?>


<?php 
foreach( $posts as $post ) {
    //je recupere l'objet topic
    $topic = $post->getTopic();
    
?>

<div>
    <h1>Tous les posts de <?= $topic->getTitle()?></h1>
</div>

<ul>
    <li></li>
    <li></li>
</ul>

<?php } ?>
</div>
