<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;


    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        //lister les user-> find All

        //fetch un utilisateur par son id -> findOneById($id)


        //trouver un utilisateur par son email
        
        public function fetchUserByEmail($email){
            $sql = "SELECT u.userName, u.email, u.password
            FROM ".$this->tableName." u
            WHERE u.email = :email
            ";
        
        return $this -> getMultipleResults(
            DAO::select($sql, ['email' => $email]),
            $this->className
            );
        }

    }