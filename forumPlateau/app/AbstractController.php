<?php
    //permet de rediriger tous les controllers
    namespace App;

    /*En PHP, un namespace est un mécanisme qui permet de regrouper des classes, des interfaces, des fonctions et des constantes sous un même nom. Il s'agit d'une fonctionnalité introduite dans PHP 5.3 pour aider à éviter les conflits de noms de classes ou de fonctions. */

    abstract class AbstractController{
        //fonction index
        public function index(){}
        //constuit une url de redirection, construit une url plus pratique (evite bugg de route)
        public function redirectTo($ctrl = null, $action = null, $id = null){

            if($ctrl != "home"){
                $url = $ctrl ? "/".$ctrl : "";
                $url.= $action ? "/".$action : "";
                $url.= $id ? "/".$id : "";
                $url.= ".html";
            }
            else $url = "/";
            header("Location: $url");
            die();

            /** Exemple : si vous souhaitez faire une redirection vers :
                *index.php?ctrl=forum&action=listCategories
                *Il vous suffira de faire :
                *$this->redirectTo("forum", "listCategories");
                *Même principe si vous souhaitez inclure un id dans l'URL :
                *index.php?ctrl=forum&action=listTopics&id=1
                *En partant du principe que l'id est stocké dans la variable $id :
                *$this->redirectTo("forum","listTopics", $id);*/

        }
        //restrain les autorisations par rapport au role de l'user
        public function restrictTo($role){
            
            if(!Session::getUser() || !Session::getUser()->hasRole($role)){
                $this->redirectTo("forum", "listPosts", $id);
            }
            return;
        }

    }