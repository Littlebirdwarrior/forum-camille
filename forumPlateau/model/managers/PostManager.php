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
        public function updatePostInDB($text, $id){
            $sql = "UPDATE ".$this->tableName." p
            SET text = :text 
            WHERE p.id_".$this->tableName." = :id";

            DAO::update($sql, ['text' => $text, 'id_post' => $id]);
        }

        //Detete un post
        public function deletePostInBD($id){            
            $sql = "DELETE FROM ".$this->tableName." 
                    WHERE id_".$this->tableName." = :id";
    
            DAO::delete($sql, ['id' => $id]);
                    
        }
    }