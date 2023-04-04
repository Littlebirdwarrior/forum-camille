<?php

namespace Model\Entities;

use App\Entity;

final class User extends Entity {

    private $id;
    private $userName;
    private $email;
    private $password;
    private $firstLoginDate;

    public function __construct($data) {
        $this -> hydrate($data);
    }

    //* id

    public function getId() {
        return $this ->id;
    }

    public function setId($id) {
         $this -> id = $id;
    }

    //* userName

    public function getUserName() {
        return $this -> userName;
    }

    public function setUserName($userName) {
        $this -> userName = $userName;
    }

    //*email

    public function getEmail() {
        return $this-> email;
    }

    public function setEmail($email) {
        $this -> email = $email;
    }

    //*password

    public function getPassword() {
        return $this -> password;
    }

    public function setPassword($password) {
        $this -> password = $password;
    }

    //*firstLoginDate

    public function getFirstLoginDate() {
        return $this -> firstLoginDate;
    }

    public function setFirstLoginDate($firstLoginDate) {
        $this -> firstLoginDate = $firstLoginDate;
    }


}
