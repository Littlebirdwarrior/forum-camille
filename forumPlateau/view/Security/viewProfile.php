<?php
$user = $result['data']['user'];
?>

<div>
<?php 
if(isset($user)){
?>
    <h1><?=$user->getUserName()?></h1>

            <table>
                <tr>
                    <th></th>
                    <th>Informations</th>
                </tr>
                <tr>
                    <th>Pseudo:</th>
                    <td><?=$user->getUserName()?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?=$user->getEmail()?></td>
                </tr>
                <tr>
                    <th>Role:</th>
                    <td><?=$user->getRole()?></td>
                </tr>
            </table>

            <?php 
                } else {
                    echo '<h1>Pas d\'utilisateur en scession </h1>';
                }
            ?>

    </div>

    <form method="post" action="index.php?ctrl=security&action=updatePassword">
        <h2>Changer de mot de passe</h2>
        <p>
            <label for="password">Mot de passe :</label>
            <input type="text" name="password" placeholder="198+%DFR" maxlength="225" required/>
        </p>
        <p>
            <label for="password_confirmation">Confirmer votre mot de passe : </label>
            <input  type="text" name="passwordConfirm" placeholder="198+%DFR"  maxlength="225" required/>
        </p>
 
        <p>
            <input class="button variant" type="submit" value="Je change mon mot de passe" name="submitNewPassword" />
        </p>
    </form> 


    
    
