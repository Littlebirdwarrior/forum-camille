<?php
//var_dump($result["data"]['posts']->current()); die;
$posts = $result["data"]['posts'];
$topic = $posts->current()->getTopic();
$topicId = $_GET['id']; //ici, la valeur de l'id est récupérée par l'url
?>

<p>Tous les posts sur "<?= $topic->getTitle()?>"<p>
<div>
    <h1> <?= $topic->getTitle()?></h1>
</div>

<?php 

foreach( $posts as $post ) {
    //je l'objet user (auteur) 
    $user = $post->getUser();
?>

    <div class="box-post">
        <ul>
            <li><?= $user-> getUserName()?></li>
            <li><?= $post-> getPublishDate()?></li>
        </ul>
        <div>
            <p>
            <?= $post-> getText()?>
            </p>
        </div>
    </div>
<?php } ?>

<div>
    <a class="button" href="index.php?ctrl=forum&action=addPost&<?= $topic->getId()?>">Ajouter un post</a>
</div>