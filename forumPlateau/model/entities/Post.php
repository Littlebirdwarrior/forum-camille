<?php


//Hydratation (permet à l'instance de classe de remplir ses attribut par le construct)

final class Post extends Entity {

    private $id;
    private $publishDate;
    private $text;
    private $user;
    private $topic;

    public function __construct() {
        $this -> hydrate($data);
    }

}
