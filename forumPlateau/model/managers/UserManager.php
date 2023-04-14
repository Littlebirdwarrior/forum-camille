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
            $sql = "SELECT *
            FROM ".$this->tableName." u
            WHERE u.email = :email
            ";
        
        return $this -> getMultipleResults(
            DAO::select($sql, ['email' => $email]),
            $this->className
            );
        }

        //trouver un utilisateur par son pseudo
        
        public function fetchUserByName($userName){
            $sql = "SELECT *
            FROM ".$this->tableName." a
            WHERE userName = :userName";

            return $this->getOneorNullResult(
                DAO::select($sql, ['userName' => $userName], false),
                $this->className);
        }

        //retrouver seulement un email en BDD
		public function retrievePasswordByEmail($email){
            $sql = "SELECT u.password
            FROM ".$this->tableName." u
            WHERE email = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

    }