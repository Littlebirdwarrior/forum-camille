<?php

namespace Model\Entities;

use App\Entity;

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
