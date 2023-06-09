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

        //je recupère l'user de mon post
        $idUser = $postManager->findOneById($id)->getUser()->getId();

        $isLock = $postManager->findOneByid($id)->getTopic()->getLock();

        if(isset($_SESSION['user']))
        {
            if( Session::isAdmin() || ($idUser == Session::getUser()->getId()) && ($isLock == 0))
            {
                //je recupere mon texte
                $text = $postManager->findOneById($id)->getText();

                //----modifier le post
                if (isset($_POST['submit'])) 
                {
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

            } else {
                //permet de réafficher la page

                Session::addFlash("Error", "Non authorised user");
                $_SESSION["error"] = "Vous n'avez pas les authorisations pour changer ce post";

                //Pour la redirection, on charge le topic_id seulement ici (en cas de submit, eviter perte perf)
                $topic_id = $postManager->findOneByid($id)->getTopic()->getId();
                $this->redirectTo("forum", "listPostsByTopic", $topic_id);


            }

        } else {
            Session::addFlash("Error", "L'utilisateur n'est pas connecté");
                $_SESSION["error"] = "Vous ne vous êtes pas connecté";
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => [ ]
                ];
        }

        
        
    }

    //DELETE supprimer un post
    public function deletePost($id)
    {
        $postManager = new postManager();

        //recuperer le topic id (à mettre avant suppression du post)
        $topic_id = $postManager->findOneByid($id)->getTopic()->getId();

        //je recupère l'user de mon post
        $idUser = $postManager->findOneById($id)->getUser()->getId();

        //je recupere le lock
        $isLock = $postManager->findOneByid($id)->getTopic()->getLock();

        if(isset($_SESSION['user']))
        {

            if( Session::isAdmin() || ($idUser == Session::getUser()->getId()) && ($isLock == 0))
            {

                try {
                    //supprimer mon post 
                    $postManager->deletePostInDB(intval($id));
                    Session::addFlash("message", "Post deleted");
                } catch (\Exception $e) {
                    $_SESSION["error"] = "Ce message n'a pas été supprimé";
                }

            } else {
                Session::addFlash("Error", "Non authorised user");
                $_SESSION["error"] = "Vous n'avez pas les authorisations pour supprimer ce post";
            }

            //Redirection
            $this->redirectTo("forum", "listPostsByTopic", $topic_id);
        } else {
            Session::addFlash("Error", "L'utilisateur n'est pas connecté");
                $_SESSION["error"] = "Vous ne vous êtes pas connecté";
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => [ ]
                ];
        }    
    }


    //CREATE addPost : ajouter un post depuis un Topic préétablis 
    public function addPost($id)
    {
        //ce cree un nouveau manager topic
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        //je cree le nouveau manager post
        $postManager = new PostManager();

        //je recupere mon lock
        $isLock = $topic->getLock();
        
        //seulement si l'user est connecté quand submit
            if (isset($_POST['submit']) && isset($_SESSION['user'])) 
            {

                if ($isLock == 0)
                {
                    if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) {
                        //Je recupère mon id user
                        $user_id = $_SESSION['user']->getId();
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
                        $_SESSION["error"] = "Vous n'avez pas remplis les inputs";
                    }

                } else {
                    Session::addFlash("Error", "lock topic");
                    $_SESSION["error"] = "ce topic est verouillé";
                    $this->redirectTo("forum", "listPostsByTopic", $id);
                }

            } else {
                Session::addFlash("Error", "L'utilisateur n'est pas connecté");
                $_SESSION["error"] = "Vous ne vous êtes pas connecté";
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => [ ]
                ];
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

            if (isset($_POST['submit']) && isset($_SESSION['user'])) 
            {

                //Je recupère mon id user
                $user_id = Session::getUser()->getId();

                //*ici, il faut que le champs topic ne soit pas vide
                if (isset($_POST["textPost"]) && (!empty($_POST["textPost"]))) {
                    
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

            } else {
                Session::addFlash("Error", "L'utilisateur n'est pas connecté");
                $_SESSION["error"] = "Vous ne vous êtes pas connecté";
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => [ ]
                ];
            }

            return [
                "view" => VIEW_DIR . "forum/listTopicsByCat.php",
                "data" => [
                    "category" => $category
                ]
            ];

    }


    //UPDATE updateTopic : modifier le titre d'un topic
    public function updateTopic($id)
    {

        $topicManager = new TopicManager();
        $title = $topicManager->findOneById($id)->getTitle();

        //--je recupère le lock de mon topic
        $isLock = $topicManager->findOneById($id)->getLock();

        //je recupère l'user de mon post
        $idUser = $topicManager->findOneById($id)->getUser()->getId();

        if(isset($_SESSION['user']))
        {

            if( Session::isAdmin() || ($idUser == Session::getUser()->getId()) && ($isLock == 0))
            {
                //---modifier le topic si il n'est pas lock
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
            } else {
                //permet de réafficher la page

                Session::addFlash("Error", "Non authorised user");
                $_SESSION["error"] = "Vous n'avez pas les authorisations pour changer ce titre";

                //Redirection
                 $category_id = $topicManager->findOneById($id)->getCategory()->getId();
                $this->redirectTo("forum", "listTopicsByCat", $category_id);

            }
        } else {
            Session::addFlash("Error", "L'utilisateur n'est pas connecté");
                $_SESSION["error"] = "Vous ne vous êtes pas connecté";
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => [ ]
                ];
        }    
            
    }

    //DELETE supprimer mon topic

    public function deleteTopic($id)
    {
        $topicManager = new TopicManager();
        $category_id = $topicManager->findOneById($id)->getCategory()->getId();

        $postManager = new PostManager();
        $posts = $postManager->fetchPostsByTopic($id); //nb : ici, l'id est celui du topic

        //--je recupère le lock de mon topic
        $isLock = $topicManager->findOneById($id)->getLock();

        //je recupère l'user de mon post
        $idUser = $topicManager->findOneById($id)->getUser()->getId();

        if(isset($_SESSION['user']))
        {
            if( Session::isAdmin() || ($idUser == Session::getUser()->getId()) && ($isLock == 0))
            {
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

            } else {
                Session::addFlash("Error", "Non authorised user");
                $_SESSION["error"] = "Vous n'avez pas les authorisations pour supprimer ce topic";
            }

            //Redirection
            $this->redirectTo("forum", "listTopicsByCat", $category_id);
        } else {
            Session::addFlash("Error", "L'utilisateur n'est pas connecté");
                $_SESSION["error"] = "Vous ne vous êtes pas connecté";
                return [
                    "view" => VIEW_DIR . "security/login.php",
                    "data" => [ ]
                ];
        }      
    }
    //*Lock
    //lock et unlock les topic

    public function lockTopic($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $category_id = $topic->getCategory()->getId();

        if(Session::isAdmin())
        {
            try {
                $topicManager->lockTopicInDB($id);
            } catch (\Exception $e) {
                $_SESSION["error"] = "Ce topic n'a pas été verouillé";
            }

        } else {
            $_SESSION["error"] = "vous n'êtes pas administateur";
        }

        //Redirection
        $this->redirectTo("forum", "listTopicsByCat", $category_id); 
        
    }

    public function unlockTopic($id)
    {

        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $category_id = $topic->getCategory()->getId();

        if(Session::isAdmin()){
            try {
                $topicManager->unlockTopicInDB($id);
            } catch (\Exception $e) {
                $_SESSION["error"] = "Ce topic n'a pas été dévrouillé";
            }
        } else {
            $_SESSION["error"] = "vous n'êtes pas administateur";
        }

        //Redirection
        $this->redirectTo("forum", "listTopicsByCat", $category_id);
    }


    //fermeture fonction
}
