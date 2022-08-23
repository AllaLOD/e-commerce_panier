<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;
use App\Models\DetailsModel;
use App\Models\ProduitsModel;
use App\Models\CommandesModel;
use App\Models\ContactModel;

class AdminController extends Controller
{
    /**
     * Affichage tous les produits
     */
    public function index()
    {
        // on verifie si on est admin
        // var_dump($_SESSION);
        if($this->isAdmin())
        {

            // on instancie le model
            $produitsModel = new ProduitsModel;

            // on va chercher toutes les produit dans BDD

            $produits = $produitsModel->findAll();

            $this->render('admin/index', compact('produits'), 'admin');

        }
    }


    /**
     * Methode pour ajouter le produit dans Bdd
     */
    public function produit()
    {
        if ($this->isAdmin()) {
     
            // Traitement d'image
            if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
                // verification d'extantion et le type de image
                $allowed = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png'
                ];

                $filename = $_FILES['image']['name'];
                $filetype = $_FILES['image']['type'];
                $filesize = $_FILES['image']['size'];

                $extantion = pathinfo($filename, PATHINFO_EXTENSION);

                //on verifie l'absence de l'extantion dans les cles de $allowed ou l'absence du typa MIME
                if (!array_key_exists($extantion, $allowed) || !in_array($filetype, $allowed)) {
                    die("Erreur : format de fichier incorrect");
                }

                // on limit size à 1Mo
                if ($filesize > 1024 * 1024) {
                    die("Fichier trop volumineux");
                }
                // on genere le nouveau nom de fichier
                $newname = uniqid() . '.' . $_FILES['image']['name'];

                //On genere le chemin complet vers le fichier si on veut enregistrer le dans BDD
                // pour ça on definie l'Url de notre site
                //define("URL", "http://www.localhost/shopsite/");
                //$imageBdd = URL . "Public/uploads/images/$newname";

                // echo "<pre>";
                // var_dump($imageBdd);
                // echo "</pre>";

                // on genere le chemin vers l'image sur le serveur pour copier l'image
                $imageDossier = ROOT . "/Public/uploads/images/$newname";

                // echo "<pre>";
                // var_dump ($imageDossier);
                // echo "</pre>";

                move_uploaded_file($_FILES['image']['tmp_name'], $imageDossier);
            }
        // ________________________________________________________
 

            // on verifie la validité de formulaire qui a deux superglobal $_POST et $_FILES
            if(Form::validate($_POST,['titre', 'description', 'stock', 'prix'], $_FILES, ['image']))
            {
                
             // le formulaire est complet => on se protege contre failles XSS
             //strips_tags, htmlentities, htmlspecialchars

                    $titre = strip_tags($_POST['titre']);
                    $description = strip_tags($_POST['description']);
                    $stock = strip_tags($_POST['stock']);
                    $prix = strip_tags($_POST['prix']);
         
                    // on instancie notre model ProduitsModel
                    $produit = new ProduitsModel;

                    // on hydrate
                    $produit->setTitre($titre)
                            ->setDescription($description)
                            ->setImage($newname)
                            ->setStock($stock)
                            ->setPrix($prix);
                
                    // On enregistre
                    $produit->create();

                    // on redirige  enregistrement reussit
                    header('Location: /produits');
                    exit;
                } else {
                    // le formilaire est incomplet avec condition POST
                    $_SESSION['erreur'] = !empty($_POST) ? "<p class='fst-italic text-center text-danger mt-5'>Le formulaire est incomplet !</p>" : '';
                    $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                    $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
                    $image = isset($_FILES['image']['name']) ? strip_tags($_FILES['image']['name']) : '';
                    $stock = isset($_POST['stock']) ? strip_tags($_POST['stock']) : '';
                    $prix = isset($_POST['prix']) ? strip_tags($_POST['prix']) : '';
                }

                // on instancie le formilaire avec "enctype"
                $form = new Form;
                
                $form->debutForm('post', '', ['enctype'=>'multipart/form-data'])
                ->ajoutLabelFor('titre', "Titre :")
                ->ajoutInput('text', 'titre', [
                    'class' => 'form-control',
                    'value' => $titre
                ])
                ->ajoutLabelFor('description', 'Description : ')
                ->ajoutTextarea('description', "$description", [
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('image', 'Image ( dimension carré):')
                ->ajoutInput('file', 'image', [
                    'id' => 'image',
                    'value' => $image  
                ])
                ->ajoutLabelFor('stock', "Stock :")
                ->ajoutInput('stock', 'stock', [
                    'class' => 'form-control',
                    'value' => $stock
                    
                ])
                ->ajoutLabelFor('prix', "Prix :")
                ->ajoutInput('prix', 'prix', [
                    'class' => 'form-control',
                    'value' => $prix
                ])
                ->ajoutBouton('Ajouter', [
                    'class' => 'btn btn-primary mt-3'
                ])
                ->finForm();
                //les fichiers envoyés sont stockés dans supperglobal $_FILES
                // echo "<pre>";
                // var_dump ($_FILES);
                // echo "</pre>";

                // echo "<pre>";
                // var_dump ($_POST);
                // echo "</pre>";

                $this->render('admin/produit', ['form' => $form->create()], 'admin');
        }
        
    }


     /**
     * Liste des utilisateurs
     * @param int $id
     * @return void
     */

    public function users()
    { 
        
        if($this->isAdmin())
        {
            $usersModel = new UsersModel;

            $users = $usersModel->findAll(); 
            // on transmet à la page ou on affiche nos "annonces" avec templet "admin"
            $this->render('admin/users', compact('users'), 'admin');
        }
    }

    
    /**
     * Supprition d'un utilisateur si on est admin
     * @param int $id
     * @return void
     */

    public function supprimeUser(int $id)
    {
        // on verifie si user est "admin"
        if($this->isAdmin())
        {
            $user = new UsersModel;
            $user->delete($id);

            // on reviene à notre page de depart
            header('Location: '.$_SERVER['HTTP_REFERER']);

        }

    }

    
     /**
     * Modifier un utilisateur
     * @return int $id utlisateur
     * @return void
     */

    public function modifierUser(int $id)
    {

        if($this->isAdmin())
        {

            // On instancie le modèle
            $userModel = new UsersModel;

            // On cherche l'annonce avec cet id
            $user = $userModel->find($id);


            // on traite formulaire
            if (Form::validate($_POST, ['nom', 'prenom', 'email', 'roles'])) {

                // on se protege contre failles XSS
                $nom = strip_tags($_POST['nom']);
                $prenom = strip_tags($_POST['prenom']);
                $email = strip_tags($_POST['email']);
                $roles = strip_tags($_POST['roles']);
        
                // On instancie le modèle
                $userModif = new UsersModel;

                // On hydrate
                $userModif->setId($user->id)
                        ->setNom($nom)
                        ->setPrenom($prenom)
                        ->setEmail($email)
                        ->setRoles($roles);

                // On enregistre
                $userModif->update();

            //Apres modification , on selection tous les utilisateur pour revenir sur la page admin/users
                $users = $userModif->findAll(); 

                $this->render('admin/users', compact('users'), 'admin'); 
            }


            $formUser = new Form;
            $formUser->debutForm()
                    ->ajoutLabelFor('nom', "Nom :")
                    ->ajoutInput('nom', 'nom', [
                        'class' => 'form-control',
                        'value' => $user->nom])
                    ->ajoutLabelFor('prenom', 'Prenom : ')
                    ->ajoutInput('prenom', 'prenom', [
                        'class' => 'form-control',
                        'value' => $user->prenom
                        ])
                    ->ajoutLabelFor('email', 'Email : ')
                    ->ajoutInput('email', 'email', [
                            'class' => 'form-control',
                            'value' => $user->email
                            ])
                    ->ajoutLabelFor('roles', 'Roles :')
                    ->ajoutSelect('roles', [
                        "'ROLE_ADMIN'" => 'Admin',
                        "'ROLE_USER'" => 'User'
                    ], 
                    [
                        'class' => 'form-select',
                        'id' => 'roles',
                        
                    ])

                    ->ajoutBouton('Valider', ['class' => 'btn btn-success mt-3 ms-5'])
                    ->finForm();

            $this->render('admin/modifier', [
                'formUser' => $formUser->create(),
                'user' => $user], 'admin');
        }
    }

    /**
     * Modification de produit selectionné
     */
    public function modifierProduit(int $id)
    {
        if ($this->isAdmin()) {

            // on instancie produit
            $produitsModel = new ProduitsModel;
            $produit = $produitsModel->find($id);

             // Traitement de nouvelle l'image
            if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
                // verification d'extantion et le type de image
                $allowed = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png'
                ];

                $filename = $_FILES['image']['name'];
                $filetype = $_FILES['image']['type'];
                $filesize = $_FILES['image']['size'];

                $extantion = pathinfo($filename, PATHINFO_EXTENSION);

                //on verifie l'absence de l'extantion dans les cles de $allowed ou l'absence du typa MIME
                if (!array_key_exists($extantion, $allowed) || !in_array($filetype, $allowed)) {
                    die("Erreur : format de fichier incorrect");
                }

                // on limit size à 1Mo
                if ($filesize > 1024 * 1024) {
                    die("Fichier trop volumineux");
                }
                // on genere le nouveau nom de fichier
                $newname = uniqid() . '.' . $_FILES['image']['name'];

                //On genere le chemin complet vers le fichier si on veut enregistrer le dans BDD
                // pour ça on definie l'Url de notre site
                //define("URL", "http://www.localhost/shopsite/");
                //$imageBdd = URL . "Public/uploads/images/$newname";

                // on genere le chemin vers l'image sur le serveur pour copier l'image
                $imageDossier = ROOT . "/Public/uploads/images/$newname";
                $image = $produit->image;
                // echo "<pre>";
                // var_dump ($imageDossier);
                // echo "</pre>";

                // un supprime l'image actuelle qui est remplacer par une nouvelle image
                unlink(ROOT . "/Public/uploads/images/$image");

                move_uploaded_file($_FILES['image']['tmp_name'], $imageDossier);

                }else {

                    $image = $produit->image;
                    // var_dump($image);
                }
        
            // ________________________________________________________
            // on traite formulaire
            // on verifie la validité de formulaire qui a deux superglobal $_POST et $_FILES
            if (Form::validate($_POST, ['titre', 'description', 'stock', 'prix'], $_FILES, ['image']))
            {
                    
                // le formulaire est complet => on se protege contre failles XSS
                //strips_tags, htmlentities, htmlspecialchars

                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);
                $stock = strip_tags($_POST['stock']);
                $prix = strip_tags($_POST['prix']);
            
                // on instancie notre produit Modifié ProduitsModel
                $produitModif = new ProduitsModel;

                // on hydrate
                    if (isset($newname)) {
                        $produitModif->setId($produit->id)
                                ->setTitre($titre)
                                ->setDescription($description)
                                ->setImage($newname)           
                                ->setStock($stock)
                                ->setPrix($prix);
                    }else{
                        $produitModif->setId($produit->id)
                                ->setTitre($titre)
                                ->setDescription($description)
                                ->setImage($image)               
                                ->setStock($stock)
                                ->setPrix($prix);

                    }
                    
                // On enregistre modification
                $produitModif->update();

                // on redirige avec message de enregistrement reussit
                $_SESSION['message'] = "<p class='fst-italic text-center text-success mt-5'>Votre annonce a été modifié avec succès</p>";

                header('Location: /admin/index');
                exit;
            } 

            // on instancie le formilaire avec "enctype"
            $form = new Form;
                    
            $form->debutForm('post', '', ['enctype'=>'multipart/form-data'])
                ->ajoutLabelFor('titre', "Titre :")
                ->ajoutInput('text', 'titre', [
                    'class' => 'form-control',
                    'value' => $produit->titre
                ])
                ->ajoutLabelFor('description', 'Description : ')
                ->ajoutTextarea('description', $produit->description, [
                    'class' => 'form-control'
                ])
                ->ajoutLabelFor('image', "Image actuelle :")
                ->ajoutInput('text', 'image', [
                    'class' => 'form-control',
                    'value' => $produit->image
                ])
                ->ajoutLabelFor('image', "Pour changer l'image - sélectionnez une nouvelle image ( dimension carré):")
                ->ajoutInput('file', "image", [
                    'id' => 'image',
                    
                ])
                ->ajoutLabelFor('stock', "Stock :")
                ->ajoutInput('stock', 'stock', [
                    'class' => 'form-control',
                    'value' => $produit->stock
                        
                ])
                ->ajoutLabelFor('prix', "Prix :")
                ->ajoutInput('prix', 'prix', [
                    'class' => 'form-control',
                    'value' => $produit->prix
                ])
                ->ajoutBouton('Ajouter', [
                    'class' => 'btn btn-primary mt-3'
                ])
                ->finForm();
            //les fichiers envoyés sont stockés dans supperglobal $_FILES
            // echo "<pre>";
            // var_dump ($_FILES);
            // echo "</pre>";

            // echo "<pre>";
            // var_dump ($_POST);
            // echo "</pre>";

            $this->render('admin/modifierProduit', ['form' => $form->create()], 'admin');
        }


    }

    /**
     * Supprision de produit
     */
    public function deleteProduit(int $id )
    {
        if ($this->isAdmin()) {

            // on instancie detailsModel pour verifier si il y a des commandes associeés à l'article
            $details = new DetailsModel;

            // on trouve les détails, qui corespondent à $id
            $detail = $details->findBy(['produit_id' => $id]);

            if (isset($detail) && !empty($detail)) {
                $_SESSION['erreur'] = "<p class='fst-italic text-center text-danger mt-5'>L'article ne peut pas être supprimé. Il y a des commandes associées à cet article</p>";
            } else {
                $produits = new ProduitsModel;
                
                // on trouve $produit pour pouvoir acceder à données et supprimer l'image
                $produit = $produits->find($id);
                $image = $produit->image;
                
                $produits->delete($id);

                // on supprime le lien vers l'image
                unlink(ROOT . "/Public/uploads/images/$image");
            }

            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    

    /**
     * Affichage des commandes enregistrés
     */
    public function commandes()
    {
        if($this->isAdmin())
        {
            // on instancie commandeModel pour avoir acces aux données
            $commandesModel = new CommandesModel;

            $commandes = $commandesModel->findAll();
        
            $this->render('admin/commandes', compact('commandes'), 'admin');
        }
    }


    /**
     * Détails de commande
     */
    public function detailsAdmin($id_com)
    {
        if($this->isAdmin())
        {
            // on instacie les detailsModel
            $detailsModel = new DetailsModel;
            // on instancie users pour avoir acces aux données de utilisateur

            $usersModel = new UsersModel;

            $users = $usersModel->userCommande($id_com);

            $details = $detailsModel->commandesUser($id_com);

            $this->render('admin/detailsAdmin', compact('details','users'), 'admin');
        }
    }


    /**
     * Affichage des messages
     */
    public function contact()
    {
        if($this->isAdmin())
        {
            $contactModel = new ContactModel;

            $contacts = $contactModel->findAll();

            $this->render('admin/contact', compact('contacts'), 'admin');
        }
    }



    
    /**
     * Methode qui verifie si on est admin
     * @return true
     */

    private function isAdmin()
    {
        // on verifie si on est connecté et si role est "ROLE_ADMIN"
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles']))
        {
            //On est admin
            return true;

        }else{

            // on n'est pas admin :
            $_SESSION['erreur'] = "<p class='fst-italic text-center text-danger mt-5'>Vous n'avez pas accès à cette page !</p>";
            header(('Location: /'));
            exit;
        }
    }


}
