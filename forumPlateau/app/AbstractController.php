<?php
    //permet de rediriger tous les controllers
    namespace App;

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
                $this->redirectTo("forum", "listPosts", $idTopic);
            }
            return;
        }

    }