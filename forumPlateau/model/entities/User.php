<?php

namespace Model\Entities;

use App\Entity;

final class User extends Entity {

    private $id;
    private $role;
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

    //* role

    public function getRole() {
        return $this ->role;
    }

    public function setRole($role) {
         $this -> role = $role;
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

    //*ici, verifie que le role appellé et le role demandé (voir dans App/Session)
    //le == sert ici d'opérateur de comparaison
    public function hasRole($role) {
        if($role == $this -> role){
            return true;
        }
        return false;
    }


    //*To_string

    public function __toString(){
        return $this-> userName;
    }


}
