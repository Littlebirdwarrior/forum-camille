<?php
//Hydratation (permet à l'instance de classe de remplir ses attribut par le construct)

final class Category extends Entity {

    private $id;
    private $name;

    public function __construct() {
        $this -> hydrate($data);
    }

}
