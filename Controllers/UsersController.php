<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\ProduitsModel;
use App\Models\CommandesModel;
use App\Models\DetailsModel;
use App\Models\UsersModel;


class UsersController extends Controller
{


    /**
     * Connexion des utilisateur
     * @return void
     */
    public function login()
    {

        
        // on verifie si formulaire est complete
        if(Form::validate($_POST, ['email', 'password'])){
            
            //CONNEXION
            // si le formulaire est complete on cherche dans Bdd l'email entré
            $userModel = new UsersModel;
            $userArray = $userModel->findOneByEmail(htmlspecialchars(strip_tags($_POST['email'])));

            // si l'utilisateur n'existe pas 
            if(empty($userArray)){

                $_SESSION['erreur'] = "<p class='fst-italic text-center text-danger'>L'adresse email et/ou le mot de passe sont incorrect</p>";
                
                
                header('Location: /users/login');
                exit;
            }

            // si l'utilisateur existe
            
            $user = $userModel->hydrate($userArray);

            // verification de mot de passe
            if(password_verify($_POST['password'], $user->getPassword())){
                $user->setSession();
                header('Location: /');
            }else{
                
                $_SESSION['erreur'] = "<p class='fst-italic text-center text-danger'>L'adresse email et/ou le mot de passe sont incorrect</p>";
                
                header('Location: /users/login');
                exit;

            }
        }

        // var_dump($_SESSION);

        $form = new Form;
        $form->debutForm()
            ->ajoutLabelFor('email', 'Email')
            ->ajoutInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email'
                ])
            ->ajoutLabelFor('password', 'Mot de passe')
            ->ajoutInput('password', 'password', [
                'id' => 'password',
                'class' => 'form-control',
                'type' => 'password'
                ])
            ->ajoutBouton('Me connecter', [
                'class' => 'btn btn_connexion mt-3'
                ])
            ->finForm();
            
         //var_dump($form);

         // on envoie le formulair sur la page

        $this->render('users/login', ['loginForm' => $form->create()]);

    }

    /**
     * Inscription des utilisateures
     * @return void
     */
    public function register()
    {

        // On hydrate l'utilisateur
        $user = new UsersModel;
        $form = new Form;
        $errorEmail ='';
            
        // On vérifie si notre post contient les champs nom,prenom, email et password
        if (Form::validate($_POST, ['civilite', 'nom', 'prenom', 'email', 'password'])) {
    
            // le formulaire est valide
           // echo "valide";
            // On "nettoie" l'adresse email,nom,prenom
            $civilite = strip_tags($_POST['civilite']);
            $nom = htmlspecialchars(strip_tags($_POST['nom']));
            $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
            $email = htmlspecialchars(strip_tags($_POST['email']));

            // On chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $user->setCivilite($civilite)
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setEmail($email)
                ->setPassword($pass);

            // On stocke l'utilisateur
            $user->create(); 
            
            header('Location: /users/login');
            exit;
            
        }

        $form->debutForm()
            ->ajoutLabelFor('civilite', 'Civilité :')
            ->ajoutSelect('civilite', [
                '1' => 'Madame',
                '2' => 'Monsieur'
            ], 
            [
                'class' => 'form-select',
                'id' => 'civilite',
                
            ])
            ->ajoutLabelFor('nom', 'Nom :')
            ->ajoutInput('nom', 'nom', [
                'class' => 'form-control',
                'id' => 'nom',
                'minlength' => 2
            ])
            ->ajoutLabelFor('prenom', 'Prenom :')
            ->ajoutInput('prenom', 'prenom', [
                'class' => 'form-control',
                'id' => 'prenom',
                'minlength' => 2
            ])
            ->ajoutLabelFor('email', 'Email :')
            ->ajoutInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'required pattern' => '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/'
                ])
            ->ajoutLabelFor('password', 'Mot de passe :')
            ->ajoutInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'minlength' => '8',
                'placeholder' => 'Minimum 8 characters'
                ])
            ->ajoutBouton('M\'inscrire', [
                'class' => 'btn btn_inscription mt-3'
                ])
            ->finForm();


   // var_dump($_POST);

    $this->render('users/register', ['registerForm' => $form->create()]);


    }

    /**
     * Déconnexion de l'utilisateur
     * @return exit 
     */
    public function logout(){
        unset($_SESSION['user']);
        header('Location: /');
        exit;
    }

    //Route vers la page de profil et affichage les commandes d'utilisateur

    public function profil(int $users_id = null)
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {
             // users_id de table annonces est egale à 'id' de user connecté
            $users_id === $_SESSION['user']['id'];
        
            // On instancie "commandesModel" pour selection toutes les commandes enregistrés par utilisateur connecté
            $commandesModel = new CommandesModel;

            $commandes = $commandesModel->findBy(['user_id' => $_SESSION['user']['id']]);

            $this->render('users/profil', compact('commandes'));
        }
    }

    // affichage de détails d'une annonce

    public function details($id_com)
    {

        // on instancie les détailsModel pour avoir acces aux données
       $detailsModel = new DetailsModel;

       $details = $detailsModel->commandesUser($id_com);

        $this->render('users/details', compact('details'));
    }

}