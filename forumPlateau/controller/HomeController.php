<?php
    //ici, on place le controller au bon endroit, dans le namespace Controller
    namespace Controller;

    use App\Session;
    use App\AbstractController; //indispensable, creer index et redirection
    use App\ControllerInterface; //
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        //lister tous les topics dans l'index
        public function index(){
            //sur l'acceuil, on affiche tous les topics
            $topicManager = new TopicManager();
            //var_dump($topicManager->findAll(["publishDate", "DESC"])->current());die;
        //    //ici, controller vers la view méthode listTopic
            return [
                "view" => VIEW_DIR."home.php",//ici remplace require
                //tableau data qui vas chercher topics
                "data" => [
                    "topics" => $topicManager->findAll(["publishDate", "DESC"])
                ]
            ];
        
        }
            
        
   
        public function users(){
            $this->restrictTo("ROLE_USER");

            $manager = new UserManager();
            $users = $manager->findAll(['firstLoginDate', 'DESC']);

            return [
                "view" => VIEW_DIR."Security/users.php",
                "data" => [
                    "users" => $users
                ]
            ];
        }

        public function forumRules(){
            
            return [
                "view" => VIEW_DIR."rules.php"
            ];
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
