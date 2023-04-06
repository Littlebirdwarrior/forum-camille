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
                "view" => VIEW_DIR."forum/listTopicsByCat.php",
                "data" => [
                    "topics" => $topicManager->fetchTopicsByCat($id)
                ]  
            ];
        }

        //addPost : ajouter un post depuis un Topic préétablis

        public function addPost($id){

            //ce cree un nouveau manager topic
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($id);

            //je cree le nouveau manager post
            $postManager = new PostManager();

            //seulement si l'user est connecté
            // if($_SESSION['user']){
                //Je recupère mon id user et mon id cat
                // $user_id = $_SESSION['user']->getId();
                $user_id = 21;

                if(isset($_POST['submit'])){
                    if(isset($_POST["textPost"]) &&(!empty($_POST["textPost"]))){
                        //je vide mon post ce charactères dangereux
                        $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        //si le filtre passe
                        if($text){
                            //j'insére mes données dans le sql
                            $postManager->add(["text"=>$text,"topic_id"=>$topic,"user_id"=>$user_id]);
                            Session::addFlash("Success", "Post added successfully");
                            $this->redirectTo("forum", "listPosts", $id);
                        } else {
                            echo 'erreur';
                            Session::addFlash("Error", "Blank input");
                            $this->redirectTo("forum", "listPosts", $id);
                        }
                    }
                }

            return [
                "view" => VIEW_DIR."forum/addPost.php",
                "data" => [
                    "topic" => $topic
                ]
            ];
                
            // }

            
            
    }

}
