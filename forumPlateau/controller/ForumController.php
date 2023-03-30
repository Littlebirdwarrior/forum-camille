<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
            //Il faudra aussi comprendre que la méthode "findAll" est une méthode générique 
            //qui provient de l'AbstractController (dont hérite chaque controller de l'application)
           $topicManager = new TopicManager();
           //ici, controller vers la view méthode listTopic
            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationdate", "DESC"])
                ]
            ];
        
        }

        

    }
