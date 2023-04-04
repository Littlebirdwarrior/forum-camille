<?php
var_dump($result["data"]['topics']);
$topics = $result["data"]['topics'];

?>

<h1>Liste des topics</h1>

<div>
    <table>
        <thead>
            <th>Catégorie</th>
            <th>Titre</th>
            <th>Date</th>
        </thead>
        <tbody>

        <?php
        //génére pour chaque topic
        foreach($topics as $topic) {
            //je recupère l'id de ma catégorie
            $categoryId = $topic ->getCategory();?>
            <td><?=$category = $categoryId ->getName();?></td>
            <!-----titre----->
            <td><?=$title = $topic->getTitle();?></td>
            <!-----date----->
            <td><?=$date = $topic -> getPublishDate();?></td>
            
        <?php } ?>

        </tbody>
</table>

</div>

  
