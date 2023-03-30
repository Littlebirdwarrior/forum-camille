<?php

final class Post extends Entity {

    private $id_post;
    private $publishDate;
    private $text;
    private $user;
    private $topic;

    public function __construct() {
        this->hydrate($data)
    }

}
