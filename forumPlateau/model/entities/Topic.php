<?php

final class Topic extends Entity {

    private $id_topic;
    private $title;
    private $publishDate;
    private $lock;
    private $user;
    private $category;

    //cela permet d'attribuer 
    public function __construct() {
        this->hydrate($data)
    }

}
