<?php
//var_dump($topic = $result["data"]["topics"]->current()); die;

$topics = $result["data"]["topics"];
$category = $topics->current()->getCategory();
$categoryId = $_GET['id'];

?>
<div>
    <h1><?= $category->getName()?></h1>
</div>

<div>
    <table>
        <thead>

           <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
           </tr> 
        </thead>
        <tbody>
        
        
        <?php
        //génére pour chaque topic
        foreach($topics as $topic) {
            //je recupère l'object user (auteur)
            $user = $topic ->getUser();
            ?>
                <tr>
                    <!-----titre----->
                    <td><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?=$topic->getTitle();?></a></td>
                    <!-----Auteur----->
                    <td><?= $user->getUserName();?></td>
                    <!-----date----->
                    <td><?= $topic->getPublishDate();?></td>
                </tr>
        <?php } ?>
        
        </tbody>
    </table>
</div>


<h2>Ajouter un sujet</h2>

<form method="post"><!----ici, id existe pas encore---->
<!--------- action="index.php?ctrl=forum&action=addTopic&id=<?=$categoryId?>" ------------->
   <div>
      <label for="user">Utilisateur: <?=$user-> getUserName()?> </label><br />
      <label for="labelTopic"> Votre sujet : </label><br />
      <input type="text" id="titleTopic" name="titleTopic" required
       minlength="1" maxlength="25">
   </div>
   <div>
      <label for="postLabel">Le premier message</label><br />
      <textarea name="textPost" required></textarea>
   </div>
   <div>
      <input type="submit" value="OK" name="submit" />
   </div>
</form> 

