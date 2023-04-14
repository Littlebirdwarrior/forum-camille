<?php
    
    namespace Controller;

    use App\Session;
    use App\AbstractController; 
    use App\ControllerInterface; 
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class HomeController extends AbstractController implements ControllerInterface 
    {

        //*Affichage
        //permet afficher le formulaire de connexion dès l'index
        //!public function index(){} je ne sais pas à quoi ça sert ici

        public function loginForm(){
            return [
                "view" => VIEW_DIR."security/login.php",
                //pas de connexion à la BDD nécéssaire pour l'affichage
                "data" => []
            ];
        }

        public function registerForm(){
            return [
                "view" => VIEW_DIR."security/register.php",
                //pas de connexion à la BDD nécéssaire pour l'affichage
                "data" => []
            ];
        }
        //*! ne marche pas 
        //lister les users
        public function listUsers()
        {
            $userManager = new UserManager();

            return [
                "view" => VIEW_DIR . "security/users.php",
                "data" => [
                    "users" => $userManager->findAll(["userName", "DESC"])
                ]
            ];
        }

        //trouver un user par son id
        public function userById($id)
        {
    
            $userManager = new UserManager();
    
            return [
                "view" => VIEW_DIR . "security/userById.php",
                "data" => [
                    "user" => $userManager->findOneById($id)
                ]
            ];
        }

        //*REGISTER Add user 
         public function register()
        {
            $userManager = new UserManager();

                //Si submit Register.php
                if(isset($_POST['submitRegister']))
                {

                    //je filtre mes données
                    $userName= filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                    $password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $passwordConfirm= filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);  


                    //si les champs sont remplis et filtré
                    if($userName && $email && $password &&$passwordConfirm)
                    {
                        //si le mail n'existe pas en BDD
                            if(!$userManager->fetchUserByEmail($email))
                            {

                                //Si le mot de passe correspond à sa confirmation
                                if(!$userManager->fetchUserByName($userName))
                                {

                                    //si le password et le passwordConfirm correspondent
                                    if($password == $passwordConfirm)
                                    {

                                        //hashage du mot de passe source : https://www.php.net/manual/en/function.password-hash.php*/
                                        $passwordHash = password_hash($password,PASSWORD_DEFAULT);

                                        try {  
                                        //ajout en base de données
                                        $userManager->add(["userName"=>$userName,"email"=>$email,"password"=>$passwordHash]);
                                        Session::addFlash("Success", "User added");
                                        } catch (\Exception $e) {
                                            $_SESSION["error"] = "Cet utilisateur n'a pas été ajouté";
                                        }
                                        
                                        //redirection
                                        $this->redirectTo("security","login");
                                    }
                                }
                            }

                    }             
             
                
                    //affichage dans ma views
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => []
                        ];
            
                }
        
        

        }
        //*LOGIN 
        

        //*DECONNEXION

        //*Afficher le profil

    //fin de la fonction
    }