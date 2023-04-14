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
                    
                    //role par defaut
                    $role = 'user';

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
                                        $userManager->add(["userName"=>$userName,"email"=>$email,"password"=>$passwordHash,"role" => $role]);
                                        Session::addFlash("Success", "User added");
                                        //Le message d'erreur
                                        throw new \Exception("L'utilisateur n'a pas été enregistré");
                                        } catch (\Exception $e) { 
                                           echo $e->getMessage();
                                           Session::addFlash("Error", $e->getMessage());
                                        }
                                        
                                        //redirection
                                        //$this->redirectTo("security","login");

                                    } else {
                                        echo "les passwords ne correspondent pas";
                                    }
                                } else {
                                    echo "le mot de passe et sa confirmation ne matche pas";
                                }
                            } else {
                                echo "l'email est déja en bdd";
                            }

                    } else  { 
                        //Le message d'erreur
                        echo ("les champs ne sont pas remplis");
                     }
             
                
                    //affichage dans ma views
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => []
                        ];
            
                }

        }

        //*LOGIN 

        public function login()
        {
            
            $userManager = new UserManager();
            

                //Si submit Register.php
                if(isset($_POST['submitLogin']))
                {

                    //je filtre mes données
                    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                    $password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    //role par defaut
                    $role = 'user';

                    //si les champs sont remplis et filtré
                    if( $email && $password)
                    {
                        //chercher l'email dans la BDD (bool)
                        $existInDB = $userManager->retrievePasswordByEmail($email);

                        //si le mail n'existe pas en BDD
                            if ($existInDB)
                            {
                                //Je retrouve mon user
                                $user = $userManager->fetchUserByEmail($email);

                                //je charge le pasword encrypté en BDD
                                $passwordBDD = $user->getPassword();
                               
                                //j'encrypte le pawword rentré en input 
                                $passwordHash = password_hash($password,PASSWORD_DEFAULT);

                                    //si le password et celui de la bdd corresponde
                                    if(password_verify ($passwordHash, $passwordBDD))
                                    {
                                        
                                        try { 
                                        echo "connexion reussie";     
                                        //connexion
                                        Session::setUser($user);
                                        Session::addFlash("Success", "Login successful");
                                        
                                        //Le message d'erreur
                                        throw new \Exception("Connexion impossible");
                                        } catch (\Exception $e) { 
                                           echo $e->getMessage();
                                           Session::addFlash("Error", $e->getMessage());
                                        }
                                        
                                        //redirection
                                        //$this->redirectTo("security","login");

                                    } else {
                                        echo "Mot de passe incorrect";
                                    }
                                
                            } else {
                                echo "Vous n'avez pas encore de compte ! <br> Enregistez votre profil";
                            }

                    } else  { 
                        //Le message d'erreur
                        echo ("les champs ne sont pas remplis");
                     }
             
                
                    //affichage dans ma views
                    return [
                        "view" => VIEW_DIR . "security/login.php",
                        "data" => []
                        ];
            
                }
        }


        //*DECONNEXION

        //*Afficher le profil

    //fin de la fonction
    }