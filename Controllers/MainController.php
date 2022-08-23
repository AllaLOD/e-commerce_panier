<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\ContactModel;
use App\Models\ProduitsModel;
use App\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class MainController extends Controller
{
    
    public function index()
        {
            
            // on instancie le model
            $produitsModel = new ProduitsModel;

            // on va chercher toutes les produit dans BDD

            $produits = $produitsModel->findAll();
            
            $this->render('main/index', compact('produits'), 'home');

        }

       /**
        * Formilaire de contact
        */

        public function contact()
        { 
            // on instancie le contact
            $contact = new ContactModel;

            if(Form::validate($_POST, ['civilite', 'nom', 'email', 'objet', 'message']))
            {
                // On "nettoie" l'adresse email,nom,civilire,objet,message
                    $civilite = htmlspecialchars(strip_tags($_POST['civilite']));
                    $nom = htmlspecialchars(strip_tags($_POST['nom']));
                    $email = htmlspecialchars(strip_tags($_POST['email']));
                    $objet = htmlspecialchars(strip_tags($_POST['objet']));
                    $message = htmlspecialchars(strip_tags($_POST['message']));

                    $contact->setCivilite($civilite)
                            ->setNom($nom)
                            ->setEmail($email)
                            ->setObjet($objet)
                            ->setMessage($message);

                    // on enregister
                    $contact->create();
                    
                    // chargement du composer 
                    require ROOT . '/vendor/autoload.php';

                    // preparation d'email
                    $mail = new PHPMailer(true);
                    
                    // 
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = ''; //smtp.exmple.com
                    $mail->SMTPAuth   = true;         // Enable SMTP authentication
                    $mail->Username   = 'contact@example.fr';   // SMTP usernames
                    $mail->Password   = '';   // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //
                    $mail->Port = 465;
                    
                    $mail->CharSet = 'UTF-8';

                    // resipients
                    $mail->setFrom($email=$_POST['email'], $nom= $_POST['nom']);
                    $mail->addAddress('example@example.ru');
                    $mail->addReplyTo('contact@example.fr', 'Nom de site');
                    // $mail->addCC('adresse@nom.fr');
                    // $mail->addBCC('bcc@example.com');

                    $mail->isHTML(true);
                    $mail->Subject = $_POST['objet'];

                    $message = $_POST['message'];
                    $mail->Body = $message;

                    if (!$mail->send()) {
                        $_SESSION['message'] = '<small class="fst-italic text-center text-danger">Erreur d\'envoie !</small> ';
                    } else { 
                        // on redirige avec message de enregistrement reussit
                        $_SESSION['message'] = "<p class='fst-italic text-center text-success mt-5'>Votre message a été envoié avec succès !</p>";
   
                    }

                    // var_dump($mail);

                    header('Location: /main/contact');
                    exit;
            }

            $form = new Form;

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
                ->ajoutLabelFor('email', 'Email :')
                ->ajoutInput('email', 'email', [
                    'class' => 'form-control',
                    'id' => 'email',
                    'required pattern' => '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/'
                    ])
                ->ajoutLabelFor('objet', 'Sujet :')
                ->ajoutInput('objet', 'objet', [
                    'class' => 'form-control',
                    'id' => 'objet',
                    'minlength' => 2
                ])
                ->ajoutLabelFor('message', 'Message : ')
                ->ajoutTextarea('message', "", [
                    'class' => 'form-control',
                    'maxlength' => 2000
                ])
                ->ajoutBouton('Envoyer', [
                    'class' => 'btn btn_contact mt-3'
                ])
                ->finForm();


            // var_dump($_POST);

        $this->render('main/contact', ['formContact' => $form->create()]);


        }
    
}

