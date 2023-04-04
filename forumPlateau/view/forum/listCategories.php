<?php

$categories = $result["data"]['categories'];

?>

<h1>Liste des categories</h1>

<div class="boxes-content">
    
    <?php
    //génére topics pour chaque topic
    foreach($categories as $categorie) { ?>
        <div class="box-categories">
        <?= $categorie->getName();?>
        </div>
    <?php } ?>
</div> 
