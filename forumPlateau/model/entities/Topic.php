<?php


//Hydratation (permet à l'instance de classe de remplir ses attribut par le construct)
//class Entity non crée

final class Topic extends Entity {

    private $id;
    private $title;
    private $publishDate;
    private $lock;
    private $user;
    private $category;

    //cela permet d'attribuer 
    public function __construct() {
        $this -> hydrate($data);
    }

}
