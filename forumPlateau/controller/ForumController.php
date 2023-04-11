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

class ForumController extends AbstractController implements ControllerInterface
{


    //lister les categories
    public function listCategories()
    {
        $categoryManager = new CategoryManager();
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->findAll(["name", "ASC"])
            ]
        ];
    }

    //lister les posts d'un topic
    public function listPostsByTopic($id)
    {

        $postManager = new PostManager();

        return [
            "view" => VIEW_DIR . "forum/listPostsbyTopic.php",
            "data" => [
                "posts" => $postManager->fetchPostsByTopic($id)
            ]
        ];

    }

    //list les topics par category
    public function listTopicsByCat($id)
    {

        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum/listTopicsByCat.php",
            "data" => [
                "topics" => $topicManager->fetchTopicsByCat($id)
            ]
        ];
    }
    //*CRUD POSTS
    //UPDATE updatePost : modifier le message d'un post
    
    public function updatePost($id){
        $postManager = new PostManager();
        $text = $postManager->findOneById($id)->getText();
        $id = $postManager->findOneById($id)->getId();

        //----modifier le post
        if(isset($_POST['submit'])){
        //je vide mon post ce charactères dangereux
            $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $postManager->updatePostInDB($text, $id);
            Session::addFlash("message", "Post updated");
            $this->redirectTo("forum", "listPostsByTopic", $id);
        }
        else {
            $_SESSION["error"] = "Ce message n'a pas été ajouté";
        }

        //----diriger vers le form de updatePost et l'afficher (avec le bon id)
        return [
            "view" => VIEW_DIR . "forum/updatePost.php",
            "data" => [
                "text" => $text
            ]
        ];
    }
    

    //CREATE addPost : ajouter un post depuis un Topic préétablis 
    public function addPost($id)
    {

        //ce cree un nouveau manager topic
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        //je cree le nouveau manager post
        $postManager = new PostManager();

        //seulement si l'user est connecté
        // if($_SESSION['user']){
        //Je recupère mon id user et mon id cat
        // $user_id = $_SESSION['user']->getId();
        $user_id = 21;//*!a modifier

        if (isset($_POST['submit'])) {
            //var_dump ici ne marche pas
            if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) {
                //je vide mon post ce charactères dangereux
                $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                //si le filtre passe
                if ($text) {
                    //j'insére mes données dans le sql
                    $postManager->add(["text" => $text, "topic_id" => $topic->getId(), "user_id" => $user_id]);
                    Session::addFlash("Success", "Post added successfully");
                    //je redirige ma page
                    $this->redirectTo("forum", "listPostsByTopic", $id);
                } else {
                    $this->redirectTo("forum", "listPostsByTopic", $id);
                }
            } else {
                Session::addFlash("Error", "Blank input");
            }
        }

        return [
            "view" => VIEW_DIR . "forum/listPostsbyTopic.php",
            "data" => [
                "topic" => $topic
            ]
        ];
    }
    //*CRUD TOPIC
    //CREATE addTopic : ajouter un topic et un post depuis une categorie préétablis
    public function addTopic($id)
    {
        //ce cree un nouveau manager topic
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);

        //je cree le nouveau manager topic
        $topicManager = new TopicManager();//*! comment récupérer l'id tout juste créer

        //je cree le nouveau manager post
        $postManager = new PostManager();

        //seulement si l'user est connecté
        // if($_SESSION['user']){
        //Je recupère mon id user et mon id cat
        // $user_id = $_SESSION['user']->getId();
        $user_id = 21;//*!a modifier lors de la creation des connexions

        if (isset($_POST['submit'])) {
            //var_dump ici ne marche pas
            if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) { //*!ici, il faut que le champs topic ne soit pas vide
                //je vide mon post ce charactères dangereux
                $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $title = filter_input(INPUT_POST, "titleTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $category_id = $category->getId();
                //si le filtre passe
                if ($text) {
                    //j'insère mes données dans la table topic
                    $last_id = $topicManager->add(["title"=> $title, "user_id" => $user_id, "category_id" => $category_id]);
                    //j'insére mes données dans la table post
                    $postManager->add(["text" => $text, "topic_id" => $last_id, "user_id" => $user_id]);//*! ici l'id devra être le dernier créer
                    Session::addFlash("Success", "Post added successfully");
                    //je redirige ma page
                    $this->redirectTo("forum", "listTopicsByCat", $id);
                } else {
                    $this->redirectTo("forum", "listTopicsByCat", $id);
                    echo 'erreur';
                }
            } else {
                Session::addFlash("Error", "Blank input");
            }
        }

        return [
            "view" => VIEW_DIR . "forum/listTopicsByCat.php",//*! ici pas sûre que c'est bien la catégorie que l'on rajoute
            "data" => [
                "category" => $category
            ]
        ];
    }


//fermeture fonction
}
