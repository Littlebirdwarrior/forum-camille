
<div>

<form action="index.php?ctrl=security&action=login" method="post"> 
    <!----------------->
        <h2>Connectez vous</h2>
        <!---------------------->   
        <p>
            <label for="email">Votre email</label>
            <input  type="email" name="email" placeholder="dogfan@yopmail.com" maxlength="100" required/>
        </p>
        <!-- <p>
            <label for="emailConfirm"></label>
            <input type="email"  name="submit" placeholder="dogfan@yopmail.com"/>
        </p> -->
        <p>
            <label for="password">Mot de passe</label>
            <input type="text" name="password" placeholder="198+%DFR" maxlength="225" required/>
        </p>
 
        <p>
            <input class="button" type="submit" value="Connexion" name="submitLogin" />
        </p>
    </form> 

</div>