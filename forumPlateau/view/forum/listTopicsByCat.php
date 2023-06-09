<?php
//var_dump($topic = $result["data"]["topics"]->current()); die;

//sinon on continue 
$topics = $result["data"]["topics"];
$category = $result["data"]["category"];
$categoryId = $_GET['id'];


?>
<div>
    <h1><?= $category->getName() ?></h1>
</div>


<div>
    <table>
        <thead>

            <tr>
                <th>Statut</th>
                <th>Sujet</th>
                <th>Posts</th>
                <th>Actions</th>
                <th>Verouiller</th>
            </tr>
        </thead>
        <tbody>


            <?php
            if (isset($topics)) {
                //génére pour chaque topic
                foreach ($topics as $topic) {
                    //je recupère l'object user (auteur)
                    $user = $topic->getUser();

                    //je recupère le lock (1 ou 0) et je gère l'affichage en conséquance
                    $lock = $topic->getLock();
                    //Si lock est true (== 1) ?(if) le a affiche déverouillé :(else) le a affiche verouillé
                    $btnLock = ($lock) ?
                        '<a class="button variant" href="index.php?ctrl=forum&action=unlockTopic&id=' . $topic->getId() . '"> Devrouillé </a>'
                        :
                        '<a class="button variant" href="index.php?ctrl=forum&action=lockTopic&id=' . $topic->getId() . '"> Verouiller </a>';
                    //if($lock == 1){ $msg = "lock"} else {$msg = "lock-open"}
                    $msg = ($lock)  ? 'lock' : 'lock-open';
            ?>
                    <tr>
                        <!-----Statut----->
                        <td>
                            <p>
                                <i class="fa-solid fa-<?= $msg ?>"></i>
                            </p>
                        </td>

                        <td>
                            <!-----titre----->
                            <h3><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic->getTitle(); ?></a></h3>
                            <p class="info-post">
                                <!-----Auteur----->
                                Par <a> <?= $user->getUserName(); ?> </a>
                                <!-----date----->
                                date : <a> <?= $topic->getPublishDate(); ?></a>
                            </p>
                        </td>
                        <td>
                            <p><i class="fa-regular fa-message"></i><?= $topic->getNbPosts() ?> </p>
                        </td>
                        <td>
                            <p> <!-----ici update / create---------->
                                <a href="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>"><i class="fa-solid fa-trash"></i></a>
                            </p>
                        </td>

                        <td>
                            <?php

                            ?>
                            <p> <!-----ici, unlock----------->
                                <?= $btnLock ?>
                            </p>

                        </td>
                    </tr>
            <?php }
            } else {
                echo "<tr><td colspan=\"4\"><h1>Aucun topic</h1></td></tr>";
            }

            ?>

        </tbody>
    </table>
</div>

<?php 
//if (isset($_SESSION["user"])){ ?>

<form action="index.php?ctrl=forum&action=addTopic&id=<?= $categoryId ?>" method="post"><!----ici, id existe pas encore---->
    <h2>Ajouter un sujet</h2>
    <!---------------------->
    <div>
        <label for="labelTopic"> Votre sujet : </label><br />
        <input type="text" id="titleTopic" name="titleTopic" required minlength="1" maxlength="25">
    </div>
    <div>
        <label for="postLabel">Le premier message</label><br />
        <textarea name="textPost" required></textarea>
    </div>
    <div>
        <input class="button variant" type="submit" value="OK" name="submit" />
    </div>
</form>

<?php 
//}
?>

