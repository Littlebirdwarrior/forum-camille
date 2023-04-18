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
                    <form class="updateRoleForm" action="index.php?ctrl=security&action=updateRole&id=<?=$userId?>" method="post">
                        <select  name="changeRole">
                            <option value="user"> Utilisateur</option>
                            <option value="admin"> Administrateur</option> 
                            <option value="ban"> Bloquer </option> 
                        </select>
                        <input class="button variant" type="submit" name="submitRole" value="Mettre à jour"/>
                    </form>
                </td>
            </tr>
            <?php }?>

            </tbody>
    </table>


</div>
