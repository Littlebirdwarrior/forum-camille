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
        
        return $this -> getOneorNullResult(
            DAO::select($sql, ['email' => $email], false),
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

        //retrouver un email en BDD
        public function retrieveEmail($email){
            $sql = "SELECT u.email
            FROM ".$this->tableName." u
            WHERE email = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

        //retrouver seulement un password à partir d'un en BDD
		public function retrievePasswordByEmail($email){
            $sql = "SELECT u.password
            FROM ".$this->tableName." u
            WHERE email = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

        //Update role d'un user
        public function updateRoleInDB($role, $id)
        {
            $sql = "UPDATE ".$this->tableName."
            SET role = :role 
            WHERE id_".$this->tableName." = :id";

            DAO::update($sql, ['role' => $role, 'id' => $id]);
        }

        //Update le mot de passe d'un user
        public function updatePasswordInDB($passwordHash, $id)
        {
            $sql = "UPDATE ".$this->tableName."
            SET password = :password 
            WHERE id_".$this->tableName." = :id";

            DAO::update($sql, ['password' => $passwordHash, 'id' => $id]);
        }

    }