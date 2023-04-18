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
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum/listPostsbyTopic.php",
            "data" => [
                "posts" => $postManager->fetchPostsByTopic($id),
                "topic" => $topicManager->findOneById($id)
            ]
        ];
    }

    //list les topics par category
    public function listTopicsByCat($id)
    {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR . "forum/listTopicsByCat.php",
            "data" => [
                "topics" => $topicManager->fetchTopicsByCat($id),
                "category" => $categoryManager->findOneById($id)
            ]
        ];
    }

    //*CRUD POSTS

    //UPDATE updatePost : modifier le message d'un post 
    public function updatePost($id)
    {
        $postManager = new PostManager();
        $text = $postManager->findOneById($id)->getText();

        //----modifier le post
        if (isset($_POST['submit'])) {
            //je vide mon post ce charactères dangereux
            $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try {
                //ici, l'id est une string, or, il faut le convertir en int
                $postManager->updatePostInDB($text, intval($id));
                Session::addFlash("Success", "Post updated");
            } catch (\Exception $e) {
                $_SESSION["error"] = "Ce message n'a pas été ajouté";
            }

            //Pour la redirection, on charge le topic_id seulement ici (en cas de submit, eviter perte perf)
            $topic_id = $postManager->findOneByid($id)->getTopic()->getId();
            $this->redirectTo("forum", "listPostsByTopic", $topic_id);
        }

        //----diriger vers le form de updatePost et l'afficher (avec le bon id)
        return [
            "view" => VIEW_DIR . "forum/updatePost.php",
            "data" => [
                "text" => $text
            ]
        ];
    }

    //DELETE supprimer un post
    public function deletePost($id)
    {
        $postManager = new postManager();
        //recuperer le topic id (à mettre avant suppression du post)
        $topic_id = $postManager->findOneByid($id)->getTopic()->getId();

        try {
            //supprimer mon post 
            $postManager->deletePostInDB(intval($id));
            Session::addFlash("message", "Post deleted");
        } catch (\Exception $e) {
            $_SESSION["error"] = "Ce message n'a pas été supprimé";
        }

        //Redirection
        $this->redirectTo("forum", "listPostsByTopic", $topic_id);
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
        if($_SESSION['user'])
        {
        //Je recupère mon id user et mon id cat
        $user_id = $_SESSION['user']->getId();
        

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
        $topicManager = new TopicManager();
        //je cree le nouveau manager post
        $postManager = new PostManager();

        //seulement si l'user est connecté
        if ($_SESSION['user'] !== null)
        {
            //Je recupère mon id user
            $user_id = $_SESSION['user']->getId();

            if (isset($_POST['submit'])) {

                //var_dump ici ne marche pas
                if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) {
                    //*ici, il faut que le champs topic ne soit pas vide

                    //je vide mon post ce charactères dangereux
                    $text = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $title = filter_input(INPUT_POST, "titleTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    //je recupere mon id category
                    $category_id = $category->getId();

                    //si le filtre passe
                    if ($text) {
                        //j'insère mes données dans la table topic
                        $last_id = $topicManager->add(["title" => $title, "user_id" => $user_id, "category_id" => $category_id]);
                        //j'insére mes données dans la table post
                        $postManager->add(["text" => $text, "topic_id" => $last_id, "user_id" => $user_id]); //* ici l'id devra être le dernier créer
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

                return [
                    "view" => VIEW_DIR . "forum/listTopicsByCat.php",
                    "data" => [
                        "category" => $category
                    ]
                ];
            }

        } else {
            Session::addFlash("Error", "L'utilisateur n'est pas connecté");
            //je redirige ma page
            $this->redirectTo("security", "login");

        }

    }


    //UPDATE updateTopic : modifier le titre d'un topic
    public function updateTopic($id)
    {

        $topicManager = new TopicManager();
        $title = $topicManager->findOneById($id)->getTitle();

        //---modifier le topic
        if (isset($_POST['submit'])) 
        {
            $title = filter_input(INPUT_POST, "topicTitle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            try {
                $topicManager->updateTopicInDB(intval($id), $title);
                Session::addFlash("Success", "Topic updated");
            } catch (\Exception $e) {
                $_SESSION["error"] = "Ce sujet n'a pas été modifié";
            }

            //redirection vers listTopicsByCat
            $category_id = $topicManager->findOneById($id)->getCategory()->getId();
            $this->redirectTo("forum", "listTopicsByCat", $category_id);
        }

        //---affichage du form
        return [
            "view" => VIEW_DIR . "forum/updateTopic.php",
            "data" => [
                "title" => $title,
            ]
        ];
    }

    //DELETE supprimer mon topic

    public function deleteTopic($id)
    {
        $topicManager = new TopicManager();
        $category_id = $topicManager->findOneById($id)->getCategory()->getId();

        $postManager = new PostManager();
        $posts = $postManager->fetchPostsByTopic($id); //nb : ici, l'id est celui du topic

        //boucle pour supprimer tous les posts de ce topic
        try {
            foreach ($posts as $post) {
                $post_id = $post->getId();
                $postManager->deletePostInDB(intval($post_id));
            }
        } catch (\Exception $e) {
            $_SESSION["error"] = "Les posts du sujet ne sont pas supprimé";
        }

        //supprimer le topic
        try {
            //supprimer mon topic
            $topicManager->deleteTopicInDB(intval($id));
            Session::addFlash("Success", "Topic deleted");
        } catch (\Exception $e) {
            $_SESSION["error"] = "Ce sujet n'a pas été supprimé";
        }

        //Redirection
        $this->redirectTo("forum", "listTopicsByCat", $category_id);
    }
    //*Lock
    //lock et unlock les topic

    public function lockTopic($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $category_id = $topic->getCategory()->getId();
        try {

            $topicManager->lockTopicInDB($id);
        } catch (\Exception $e) {
            $_SESSION["error"] = "Ce topic n'a pas été verouillé";
        }

        //Redirection
        $this->redirectTo("forum", "listTopicsByCat", $category_id);
    }

    public function unlockTopic($id)
    {

        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $category_id = $topic->getCategory()->getId();

        try {
            $topicManager->unlockTopicInDB($id);
        } catch (\Exception $e) {
            $_SESSION["error"] = "Ce topic n'a pas été dévrouillé";
        }

        //Redirection
        $this->redirectTo("forum", "listTopicsByCat", $category_id);
    }


    //fermeture fonction
}
