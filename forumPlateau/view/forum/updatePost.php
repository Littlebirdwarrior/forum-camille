<?php 
$text = $result['data']['text'];
$postId = $_GET['id'];
?>

<div class="update-post">
    <form action="index.php?ctrl=forum&action=updatePost&id=<?=$postId?>" method="post"><!----ici,action="index.php?ctrl=forum&action=updatePost&id=<?=$categoryId?>"  id existe pas encore---->
        <h2>Modifier un message</h2>
        <!---------------------->
        <div>
            <textarea name="textPost" required></textarea>
        </div>
        <div>
            <input class="button variant" type="submit" value="Modifier" name="submit" />
        </div>
    </form> 
</div>