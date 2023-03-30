<?php

//Hydratation (permet à l'instance de classe de remplir ses attribut par le construct)
final class User extends Entity {

    private $id;
    private $userName;
    private $email;
    private $password;
    private $firstLoginDate;

    public function __construct() {
        $this -> hydrate($data);
    }

}
