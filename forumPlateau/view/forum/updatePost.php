<?php 
$text = $result['data']['text'];
$postId = $_GET['id'];
?>

<div class="update-form">
    <form action="index.php?ctrl=forum&action=updatePost&id=<?=$postId?>" method="post">
        <h2>Modifier un message</h2>
        <!---------------------->
        <div>
            <textarea name="textPost" required><?=$text?></textarea>
        </div>
        <div>
            <input class="button variant" type="submit" value="Modifier" name="submit" />
        </div>
    </form> 
</div>