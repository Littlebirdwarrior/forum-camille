<h1>BIENVENUE SUR LE FORUM</h1>

<p>Bienvenue à tous sur notre forum pour chiens ! Nous sommes ravis de vous accueillir parmi notre communauté passionnée de nos amis à quatre pattes. Que vous soyez propriétaire d'un chien ou simplement un amoureux des animaux, 
    vous trouverez ici un espace convivial et chaleureux pour discuter de tout ce qui concerne nos compagnons canins.<br>
    
</p>
<p>
    Nous encourageons tous les membres à se respecter les uns les autres et à garder une attitude positive envers nos amis à fourrure. 
</p>

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