<?php

namespace Model\Entities;

use App\Entity;

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
