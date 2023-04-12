<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        //recuperer tous les post d'un topic
        public function fetchPostsByTopic($id)
        {
            $sql = "SELECT *
                FROM ".$this->tableName." p
                WHERE p.topic_id = :id
                ORDER BY publishDate";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );
        }

        //Update le texte d'un post
        public function updatePostInDB($text, $id)
        {
            $sql = "UPDATE ".$this->tableName."
            SET text = :text 
            WHERE id_".$this->tableName." = :id";
            
            DAO::update($sql, ['text' => $text, 'id' => $id]);
        }

        //Delete un post
        public function deletePostInDB($id)
        {            
            $sql = "DELETE FROM ".$this->tableName."
                    WHERE id_".$this->tableName." = :id";
    
            DAO::delete($sql, ['id' => $id]);
                    
        }


    }