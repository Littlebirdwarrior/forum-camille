<?php

namespace Model\Entities;

use App\Entity;

//Hydratation (permet à l'instance de classe de remplir ses attribut par le construct)
//class Entity non crée
use App\Entity;

final class Topic extends Entity {
    //je definis mes identifiants 
    private $id;
    private $title;
    private $publishDate;
    private $lock;
    private $user;
    private $category;

    //cela permet d'attribuer 
    public function __construct($data) {
        $this -> hydrate($data);
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of publishDate
     */ 
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set the value of publishDate
     *
     * @return  self
     */ 
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get the value of lock
     */ 
    public function getLock()
    {
        return $this->lock;
    }

    /**
     * Set the value of lock
     *
     * @return  self
     */ 
    public function setLock($lock)
    {
        $this->lock = $lock;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}
