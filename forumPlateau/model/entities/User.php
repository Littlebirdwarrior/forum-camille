<?php

final class User extends Entity {

    private $id_user;
    private $userName;
    private $email;
    private $password;
    private $firstLoginDate;

    public function __construct() {
        this->hydrate($data)
    }

}
