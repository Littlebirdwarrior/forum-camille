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

<!-- ... -->

<form action="index.php?ctrl=forum&action=addPost&id=<?=$topicId?>" method="post"><!----ici, id existe pas encore--->
    <h2>Ajouter un post</h2>
    <div>
      <label for="user">Utilisateur : <?=$user-> getUserName()?> </label><br />
      <label for="topic">Sujet : <?=$topic-> getTitle()?></label>
   </div>
   <div>
      <label for="post">Votre post</label><br />
      <textarea name="textPost" required></textarea>
   </div>
   <div>
      <input class="button variant" type="submit" value="OK" name="submit" />
   </div>
</form>
<!-- ... -->