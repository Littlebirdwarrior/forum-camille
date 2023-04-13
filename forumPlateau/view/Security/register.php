
<div>

<form method="post">
    <!--------action="index.php?ctrl=forum&action=updatePost&id=<?=$postId?>"--------->
        <h2>Inscrivez vius</h2>
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
            <input type="email"  name="submit" placeholder="dogfan@yopmail.com"/>
        </p> -->
        <p>
            <label for="password">Mot de passe</label>
            <input type="text" name="submit" placeholder="198+%DFR" maxlength="225" required/>
        </p>
        <p>
            <label for="passwordConfirm">Confirmer votre mot de passe</label>
            <input  type="text" name="passwordConfirm" placeholder="198+%DFR"  maxlength="225" required/>
        </p>
 
        <p>
            <input class="button" type="submit" value="Je m'inscris" name="submit" />
        </p>
    </form> 

</div>