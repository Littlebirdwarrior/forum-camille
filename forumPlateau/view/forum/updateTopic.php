<?php 
$title = $result['data']['title'];
$topicId = $_GET['id'];
?>

<div class="update-form">
    <form action="index.php?ctrl=forum&action=updateTopic&id=<?=$topicId?>" method="post">
        <h2>Modifier un message</h2>
        <!---------------------->
        <div>
            <input name="topicTitle" required><?=$title?></input>
        </div>
        <div>
            <input class="button variant" type="submit" value="Modifier" name="submit" />
        </div>
    </form> 
</div>