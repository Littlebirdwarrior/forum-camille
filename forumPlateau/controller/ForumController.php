<?php

    namespace Controller;

    use App\Session;
    // use App\Entity;
    use App\Manager;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\PostManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        //lister tous les topics dans l'index
        public function index(){
            //sur l'acceuil, on affiche tous les topics
            $topicManager = new TopicManager();
            // var_dump($topicManager->findAll(["publishDate", "DESC"])->current());die;
           //ici, controller vers la view méthode listTopic
            return [
                "view" => VIEW_DIR."forum/listTopics.php",//ici remplace require
                //tableau data qui vas chercher topics
                "data" => [
                    "topics" => $topicManager->findAll(["publishDate", "DESC"])
                ]
            ];
        
        }

        //lister les categories
        public function listCategories(){
            $categoryManager = new CategoryManager();
            return [
              "view" => VIEW_DIR."forum/listCategories.php",  
              "data" => [
                "categories" => $categoryManager->findAll(["name", "ASC"])
              ]
            ];
        }

        //lister les posts d'un topic
        public function listPostsByTopic($id){
            
            $postManager = new PostManager();

            return [
                "view" => VIEW_DIR."forum/listPostsbyTopic.php",
                "data" => [
                    "posts" => $postManager->fetchPostsByTopic($id)
                ]  
            ];
        }

        //list les topics par category
        public function listTopicsByCat($id){
            
            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopicByCat.php",
                "data" => [
                    "topics" => $topicManager->fetchTopicByCat($id)
                ]  
            ];
        }

}
