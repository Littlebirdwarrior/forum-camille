<?php

namespace Model\Managers;
//Dans App/Manager.php sont factorisé toutes les méthodes (requete sql) permettant de charger les données
use App\Manager;
//dans App/DAO est enregister la connextion à PDO (connexion à la BBD, remplace le lien à PDO)
use App\DAO;

//topic manager extends les methodes publique de la classe Manager 
class TopicManager extends Manager
{

    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    //ici, se connecte à la BDD (replace le new PDO, relation avec App/DAO)
    public function __construct()
    {
        parent::connect();
    }

    //recuperer tous les topics d'une categorie
    public function fetchTopicsByCat($id)
    {

        $sql = "SELECT id_topic, title, t.publishDate, t.user_id, t.lock,
                            COUNT(p.topic_id) as nbPosts
                    FROM " . $this->tableName . " t
                    LEFT JOIN post p ON p.topic_id = t.id_" . $this->tableName . "
                    WHERE t.category_id = :id
                    GROUP BY t.id_" . $this->tableName . "
                    ORDER BY t.publishDate DESC";


        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    //Lock et unlock un topic

    // lock un sujet  
    public function lockTopicInDB($id)
    {
        $sql = "UPDATE " . $this->tableName . " t
             SET t.lock = 1 
             WHERE t.id_" . $this->tableName . " = :id";

        return DAO::update($sql, ['id' => $id]);
    }

    // unlock un sujet  
    public function unlockTopicInDB($id)
    {
        $sql = "UPDATE " . $this->tableName . " t
             SET t.lock = 0 
             WHERE t.id_" . $this->tableName . " = :id";

        return DAO::update($sql, ['id' => $id]);
    }



    //Update le titre d'un sujet 
    public function updateTopicInDB($id, $title)
    {
        $sql = "UPDATE " . $this->tableName . " t
            SET t.title = :title 
            WHERE t.id_" . $this->tableName . " = :id";

        DAO::update($sql, ['id' => $id, 'title' => $title]);
    }

    //Delete un topic
    public function deleteTopicInDB($id)
    {
        $sql = "DELETE FROM " . $this->tableName . "
            WHERE id_" . $this->tableName . " = :id";

        DAO::delete($sql, ['id' => $id]);
    }

    //(dans DAO, 'id_topic' s'appelle id pour la methode update et delete dans Manager.php)




}
