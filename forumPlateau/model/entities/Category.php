<?php

final class Category extends Entity {

    private $id_category;
    private $name;

    public function __construct() {
        this->hydrate($data)
    }

}
