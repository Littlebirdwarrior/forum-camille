<?php
    namespace Model\Managers;
    //Dans App/Manager.php sont factorisé toutes les méthodes (requete sql) permettant de charger les données
    use App\Manager;
    //dans App/DAO est enregister la connextion à PDO (connexion à la BBD, remplace le lien à PDO)
    use App\DAO;

    //topic manager extends les methodes publique de la classe Manager 
    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";

        //ici, se connecte à la BDD (replace le new PDO, relation avec App/DAO)
        public function __construct(){
            parent::connect();
        }

    }