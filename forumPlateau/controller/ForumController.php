<?php

    namespace Controller;

    use App\Session;
    // use App\Entity;
    use App\Manager;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
            
            $topicManager = new TopicManager();
           //ici, controller vers la view méthode listTopic
            return [
                "view" => VIEW_DIR."forum/listTopics.php",//ici remplace require
                "data" => [
                    "topics" => $topicManager->findAll(["publishDate", "DESC"])
                ]
            ];
        
        }


        public function listCategories(){

            $categoryManager = new CategoryManager();

            return [
              "view" => VIEW_DIR."forum/listCategories.php",  
              "data" => [
                "categories" => $categoryManager->findAll(["name", "ASC"])
              ]
            ];
        }

        

    }
