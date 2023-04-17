<?php
$users = $result["data"]["users"];

?>

<div>

    <h1>Mes utilisateurs</h1>
    <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Changer le statut</th>
                </tr>
            </thead>
            </tbody>
            <!---------------->
            <?php foreach($users as $user){ 
                $userId = $user->getId();
                $statut = $user->getRole();

                //afficher correctement les status
                    if($statut == 'ban'){
                        $frenchStatut = 'Bannis';
                    } elseif($statut == 'admin'){
                        $frenchStatut = 'Administrateur';
                    }elseif($statut == 'user'){
                        $frenchStatut = 'Utilisateur';
                    }
                ?>
            
            <tr>
                <td>
                    <h3><a href="index.php?ctrl=security&action=viewProfile&id=<?=$userId?>"><?=$user->getUserName()?></a></h3>
                    <span><?=$frenchStatut?></span>
                </td>
                <td><?=$user->getEmail()?></td>
                <td>
                    <form class="updateRoleForm" action="index.php?ctrl=forum&action=updateRole&id=<?=$userId?>" method="post">
                        <select name="changeRole">
                            <option disabled selected value>Changer le statut</option>
                            <option value="<?=$statut?>"> Utilisateur </option>
                            <option value="<?=$statut?>"> Administrateur</option> 
                            <option value="<?=$statut?>"> Bloquer </option> 
                        </select>
                        <input class="button variant" type="submitRole" name="submitRole" value="Mettre à jour"/>
                    </form>
                </td>
            </tr>
            <?php }?>

            </tbody>
    </table>


</div>
