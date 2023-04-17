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
                    <th>Role</th>
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
                <td><a href="index.php?ctrl=security&action=viewProfile&id=<?=$userId?>"><?=$user->getUserName()?></a></td>
                <td><?=$user->getEmail()?></td>
                <td><a><?=$frenchStatut?></a></td>
                <td>
                    <select name="changeStatut">
                        <option disabled selected value>Changer le statut</option>
                        <option value="<?=$statut?>"> Utilisateur </option>
                        <option value="<?=$statut?>"> Administrateur</option> 
                        <option value="<?=$statut?>"> Bloquer </option> 
                    </select>
                </td>
            </tr>
            <?php }?>

            </tbody>
    </table>


</div>
