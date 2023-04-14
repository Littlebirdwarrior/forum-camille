<?php
    
    namespace Controller;

    use App\Session;
    use App\AbstractController; 
    use App\ControllerInterface; 
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        //*Affichage
        //permet afficher le formulaire de connexion dès l'index
        //!public function index(){} je ne sais pas à quoi ça sert ici

        public function loginForm(){
            return [
                "view" => VIEW_DIR."security/login.php",
                //pas de connexion à la BDD nécéssaire pour l'affichage
                "data" => []
            ];
        }

        public function registerForm(){
            return [
                "view" => VIEW_DIR."security/register.php",
                //pas de connexion à la BDD nécéssaire pour l'affichage
                "data" => []
            ];
        }
        //*! ne marche pas 
        //lister les users
        public function listUsers()
        {
            $userManager = new UserManager();

            return [
                "view" => VIEW_DIR . "security/users.php",
                "data" => [
                    "users" => $userManager->findAll(["userName", "DESC"])
                ]
            ];
        }

        //trouver un user par son id
        public function userById($id)
        {
    
            $userManager = new UserManager();
    
            return [
                "view" => VIEW_DIR . "security/userById.php",
                "data" => [
                    "user" => $userManager->findOneById($id)
                ]
            ];
        }

        //*REGISTER Add user 
         public function register(){
            $userManager = new UserManager();

            //je filtre mes données
            if(isset($_POST['submitRegister'])){
                

            }

            //Si submit Register.php

            //si le mail n'existe pas en BDD

            //Si le mot de passe correspond à sa confirmation

            //J'encrypte mon mot de passe avec password_hash() 
            //source : https://www.php.net/manual/en/function.password-hash.php

            //j'execute la requete addUser

            //je redirige vers mon login
         }


        //*LOGIN 

        //*DECONNEXION

        //*Afficher le profil

    //fin de la fonction
    }