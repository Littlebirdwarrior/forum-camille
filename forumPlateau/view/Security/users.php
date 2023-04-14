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
            </thead>
            <?php foreach($users as $user){ 
                $userId = $user->getId();;
                ?>
            
        
            <tr>
                <td><a href="index.php?ctrl=security&action=viewProfile&id=<?=$userId?>"><?=$user->getUserName()?></a></td>
                <td><?=$user->getEmail()?></td>
                <td><a><?=$user->getRole()?></td>
                <td>
                    <select name="changeStatut">
                        <option disabled selected value>Changer le statut</option>
                        <option value="user"> Utilisateur </option>
                        <option value="admin"> Administrateur</option> 
                        <option value="ban"> Bloquer </option> 
                    </select>
                </td>
            </tr>
        </table>

    <?php
    }?>

</div>
