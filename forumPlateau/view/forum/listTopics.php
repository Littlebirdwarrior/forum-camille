<?php
//test : var_dump($result["data"]['topics']);
$topics = $result["data"]['topics'];

?>

<h1>Tous les topics</h1>

<div>
    <table>
        <thead>
            <th>Catégorie</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date</th>
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
            <!-----categorie----->
            <td><?= $category->getName();?></td>
            <!-----titre----->
            <td><?=$topic->getTitle();?></td>
            <!-----Auteur----->
            <td><?= $user->getUserName();?></td>
            <!-----date----->
            <td><?= $topic->getPublishDate();?></td>
            
        <?php } ?>

        </tbody>
</table>

</div>

  
