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

        //affichage index: redirige vers la view (ControllerInterface)
        public function index(){
            
                //renvoie la home dans la view sous forme d'un T.A avec les données
                return [
                    "view" => VIEW_DIR."home.php"
                ];
            }
            
        
   
        public function users(){
            $this->restrictTo("ROLE_USER");

            $manager = new UserManager();
            $users = $manager->findAll(['registerdate', 'DESC']);

            return [
                "view" => VIEW_DIR."security/users.php",
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
