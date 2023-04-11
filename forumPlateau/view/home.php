<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p>
    <a href="index.php?ctrl=forum&action=listCategories">List Categories</a>
</p>


<?php
//var_dump($result["data"]['topics']);
$topics = $result["data"]['topics'];
?>

<h1>Derniers topics en date</h1>

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
                <tr>
                    <!-----categorie----->
                    <td><a href="index.php?ctrl=forum&action=listTopicsByCat&id=<?=$category->getId()?>"><?= $category->getName();?></a></td>
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