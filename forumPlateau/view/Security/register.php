
<div>

<form action="index.php?ctrl=security&action=register" method="post">
    <!----------------->
        <h2>Inscrivez-vous</h2>
        <!---------------------->
        <p>
            <label for="userName">Votre pseudo</label>
            <input type="text" name="userName"  placeholder="Dogfan" maxlength="15" required/>
        </p>        
        <p>
            <label for="email">Votre email</label>
            <input  type="email" name="email" placeholder="dogfan@yopmail.com" maxlength="100" required/>
        </p>
        <!-- <p>
            <label for="emailConfirm"></label>
            <input type="email"  name="emailConfirm" placeholder="dogfan@yopmail.com"/>
        </p> -->
        <p>
            <label for="password">Mot de passe</label>
            <input type="text" name="password" placeholder="198+%DFR" maxlength="225" required/>
        </p>
        <p>
            <label for="password_confirmation">Confirmer votre mot de passe</label>
            <input  type="text" name="passwordConfirm" placeholder="198+%DFR"  maxlength="225" required/>
        </p>
 
        <p>
            <input class="button" type="submit" value="Je m'inscris" name="submitRegister" />
        </p>
    </form> 

</div>