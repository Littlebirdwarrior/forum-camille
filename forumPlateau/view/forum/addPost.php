
<?php
$post = $result['data']['topic'];

var_dump($_POST);
?>
<!-- ... -->
<h2>Ajouter un post sur le sujet " "</h2>

<form action="index.php?ctrl=forum&action=addPost&id=21>" method="post" required><!----ici, id existe pas encore--->
   <div>
  	<label for="user">Utilisateur "" </label><br />
  	<label for="topic">Topic ""</label><br />
   </div>
   <div>
  	<label for="post">Votre post</label><br />
  	<textarea name="textPost"></textarea>
   </div>
   <div>
  	<input type="submit" />
   </div>
</form>
<!-- ... -->