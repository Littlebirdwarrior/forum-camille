<?php

namespace Model\Entities;

use Controller\ForumController;
use App\Entity;

final class Category extends Entity {

    private $id;
    private $name;

    public function __construct($data) {
        $this -> hydrate($data);
    }

    public function getId() {
        return $this -> id;
    }

    public function getName() {
        return $this -> name;
    }

    public function setName($name) {
        $this -> name = $name;
    }
}
