<?php

namespace Model\Entities;

use App\Entity;

final class Post extends Entity {
    
    private $id;
    private $publishDate;
    private $text;
    private $user;
    private $topic;

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
     * Get the value of publishDate
     */ 
    public function getPublishDate()
    {
        $formatDate = $this->publishDate->format('d/m/Y à H:i:s');
        return $formatDate;
    }

    /**
     * Set the value of publishDate
     *
     * @return  self
     */ 
    public function setPublishDate($publishDate)
    {
        $this->publishDate =  new \DateTime($publishDate);;

        return $this;
    }

    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

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
     * Get the value of topic
     */ 
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    

    

}
