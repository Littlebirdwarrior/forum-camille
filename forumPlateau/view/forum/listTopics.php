<?php
//test : var_dump($result["data"]['topics']);
$topics = $result["data"]['topics'];

?>

<h1>Tous les topics</h1>

<div>
    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        
        
        <?php
        //génére pour chaque topic
        foreach($topics as $topic) {
            //je recupère l'objet catégorie
            $category = $topic ->getCategory();
            //je recupère l'object user (auteur)
            $user = $topic ->getUser();
            ?>
            <a href="index.php?ctrl=forum&action=listCategories">
                <tr>
                    <!-----categorie----->
                    <td><a href="index.php?ctrl=forum&action=listTopicsByCat&id=<?=$topic->getId()?>"><?= $category->getName();?></a></td>
                    <!-----titre----->
                    <td><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?=$topic->getTitle();?></a></td>
                    <!-----Auteur----->
                    <td><?= $user->getUserName();?></td>
                    <!-----date----->
                    <td><?= $topic->getPublishDate();?></td>
                </tr>
            </a>
        <?php } ?>
        
        </tbody>
    </table>
</div>

  
