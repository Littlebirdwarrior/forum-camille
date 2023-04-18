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
                        
                        // Vérification si le userName existe déja en BDD
                            if(!$userManager->fetchUserByEmail($email))
                            {
                                
                                //On recupere le user manager par son nom
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
                                        } catch (\Exception $e) { 
                                           Session::addFlash("Error","user non registered");
                                           $_SESSION["error"] = "L'utilisateur n'a pas été enregistré";
                                        }
                                        
                                        //redirection
                                        $this->redirectTo("security","loginForm");

                                    } else {
                                        Session::addFlash("Error","password don't match");
                                        $_SESSION["error"] = "Les passwords ne correspondent pas";
                                    }
                                } else {
                                    Session::addFlash("Error","username already registered");
                                    $_SESSION["error"] = "Ce pseudo est deja pris";
                                }
                            } else {
                                Session::addFlash("Error","email already registered");
                                $_SESSION["error"] = "Cet email est déjà en enregisté <br> Veuillez-vous connecté";

                                return [
                                    "view" => VIEW_DIR . "security/login.php",
                                    "data" => []
                                    ];
                            }

                    } else  { 
                        //Le message d'erreur
                        Session::addFlash("Error","empty input when submit");
                        $_SESSION["error"] = "Les champs ne sont pas remplis";
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

                //Si submit Login.php
                if(isset($_POST['submitLogin']))
                {
                    
                    //je filtre mes données
                    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                    $password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    //si les champs sont remplis et filtré
                    if( $email && $password)
                    {
                        //retrouver le password dans la BDD à partir de l'email (renvois un t.a)
                        $existInDB = $userManager->retrievePasswordByEmail($email);

                        //si le mail n'existe pas en BDD (si cela ne renvois pas null) source : https://apcpedagogie.com/les-methodes-de-cryptage-en-php/
                            if ($existInDB)
                            {
                                //je recupère le password encodé dans la BDD 
                                $hash = $existInDB->getPassword();
                                    
                                    //si le password et celui de la bdd corresponde
                                    if(password_verify($password, $hash))
                                    {
                                        $user = $userManager->fetchUserByEmail($email);
                                        
                                        if($user->getRole() !== "ban")
                                        {
                                            try { 
                                                //connexion
                                                Session::setUser($user);
                                                Session::addFlash("Success", "Login successful");
        
                                                } catch (\Exception $e) { 
                                                   echo $e->getMessage();
                                                   Session::addFlash("Error", $e->getMessage());
                                                }
                                                
                                                //redirection
                                                $this->redirectTo("security","viewProfile");

                                        } else {
    
                                            Session::addFlash("Error", "Ban user");
                                            $_SESSION["error"] = "Vous avez été banis";

                                            return [
                                                "view" => VIEW_DIR . "security/ban.php",
                                                "data" => []
                                            ];
                                        }
                                          

                                    } else {
                                        Session::addFlash("Error", "incorrect password");
                                        $_SESSION["error"] = "Mot de passe incorrect";
                                    }
                                
                            } else {
                                Session::addFlash("Error", "non registered user");
                                $_SESSION["error"] = "Vous n'avez pas encore de compte ! <br> Enregistez votre profil";
                                
                                return [
                                    "view" => VIEW_DIR . "security/register.php",
                                    "data" => []
                                    ];
                            }

                    } else  { 
                        //Le message d'erreur
                        Session::addFlash("Error", "empty input");
                        $_SESSION["error"] = "Les champs ne sont pas remplis";
                     }
             
                
                    //affichage dans ma views
                    return [
                        "view" => VIEW_DIR . "security/login.php",
                        "data" => []
                        ];
            
                }
        }


        //*DECONNEXION
        public function logout(){
            $user = null;
            Session::setUser($user);

             //affichage dans ma views
             return [
                "view" => VIEW_DIR . "security/login.php",
                "data" => []
                ];
        }

        //*Afficher le profil viewProfile

        public function viewProfile($id)
        {
            $user = Session::getUser();
            $userId = $user->getId();
            
            return [
                "view" => VIEW_DIR . "security/viewProfile.php",
                "data" => [ "user" => $user]
                ];
        }

        //*Update role
        public function updateRole($id)
        { 
            $userManager = new UserManager;
            //attention, ici cas non traité, si un administateur se remet lui-même en utilisateur, il a toujours les droit ??
            //-----Modifier le role d'un user (a besoin de isAdmin pour s'afficher donc protection inutile ici)
            if (isset($_POST['submitRole']) && Session::isAdmin()) 
            {
                $role = filter_input(INPUT_POST, "changeRole", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                try {
                    $userManager->updateRoleInDB($role, intval($id));
                } catch (\Exception $e){
                    $_SESSION["error"] = "Ce role n'a pas été modifié";
                }

            } else {
                Session::addFlash("Error", "Not Admin");
                $_SESSION['Error'] = "Vous n'êtes pas admin";
            }
                       
        //---affichage de la view
        return [
            "view" => VIEW_DIR . "security/users.php",
            "data" => [
                "users" => $userManager->findAll(["firstLoginDate", "DESC"])
            ]
        ];

        }

        //*REGISTER Add user 
        public function updatePassword()
        {
            
            $userManager = new UserManager();
            

                //Si submit Register.php
                if(isset($_POST['submitNewPassword']))
                {

                    //je filtre mes données
                    $password= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $passwordConfirm= filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
                    

                    //si les champs sont remplis et filtré
                    if($password && $passwordConfirm)
                    {
                        
                        //si le password et le passwordConfirm correspondent
                        if($password == $passwordConfirm)
                        {
                            
                            //hashage du mot de passe source : https://www.php.net/manual/en/function.password-hash.php*/
                            $passwordHash = password_hash($password,PASSWORD_DEFAULT);

                            $id =  $_SESSION['user']->getid();

                            try {  
                            //ajout en base de données
                            $userManager->updatePasswordInDB($passwordHash, $id);
                            } catch (\Exception $e) { 
                               Session::addFlash("Error","password non updated");
                               $_SESSION["error"] = "Le password n'a pas été modifié";
                            }
                            
                            //redirection
                            $this->redirectTo("security","loginForm");

                        } else {
                            Session::addFlash("Error","password don't match");
                            $_SESSION["error"] = "Les passwords ne correspondent pas";
                        }

                    } else  { 
                        //Le message d'erreur
                        Session::addFlash("Error","empty input when submit");
                        $_SESSION["error"] = "Les champs ne sont pas remplis";
                    }
             
                
                    //affichage dans ma views
                    return [
                        "view" => VIEW_DIR . "security/viewProfile.php",
                        "data" => []
                        ];
            
                }

        }
        

    //fin de la fonction
    }