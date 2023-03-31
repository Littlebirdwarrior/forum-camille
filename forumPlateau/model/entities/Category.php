<?php

namespace Model\Entities;

use App\Entity;

final class Category extends Entity {

    private $id;
    private $name;

    public function __construct() {
        $this -> hydrate($data);
    }

}
