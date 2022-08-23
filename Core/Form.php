<?php
namespace App\Core;

class Form
{ 
    private $formCode = '';

    /**
     * Génère le formulaire HTML
     * @return string
     */
    public function create()
    {
        return $this->formCode;
    } 

    /**
     * Valide si tout les champes proposés sont remplis
     * @param array $form  Tableau issu du formulaire ($_POST, $_GET)
     * @param array $champs tableau listant les champs obligatoires
     * @return bool
     */

    public static function validate(array $form, array $champs)
    {
        // on parcourt les champs
        foreach($champs as $champ)
        {
            // on verifie si le champ est absent ou vide dans le formulaire
            if (!isset($form[$champ]) || empty($form[$champ])) {
                return false;
            }    
        }

        return true;
        
    }

    /**
     * Ajout des attributs envoyés à la balise
     * @param array $attributs Tableau associatif ['class' => 'form-control', 'required => true]
     * 
     */

    private function ajoutAttributs(array $attributs): string
    {
        // on initialise une chaine de caractaire
        $str = '';
        // on liste des attrubuts "courts"
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];
        // on boucle sur le tableau d'attributs

        foreach($attributs as $attribut => $valeur){
            // on verifie si attribut est court
            if(in_array($attribut, $courts) && $valeur == true){
                $str .= " $attribut";
            }else{
                // on ajoute attribut='valeure'
                $str .= " $attribut=\"$valeur\"";

            }
        }

        return $str;

    }

    /**
     * Balise d'ouverture de formulaire
     * @param string $methode Méthode du formulaire (post ou get)
     * @param string $action Action du formulaire
     * @param array $attributs Attributs
     * @return Form 
     */

    public function debutForm(string $method = 'post', string $action = '', array $attributs = []): self
    {
        // on cree la balise form
        $this->formCode .= "<form action='$action' method='$method'";
        
        // on ajout des attributs éventuels
        
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    /**
     * balise de fermeture de formulaire
     * @return Form
     */

    public function finForm():self
    {
        $this->formCode .= "</form>";

        return $this;
    }

    /**
     * Ajout d'un label
     * @param string $for 
     * @param string $texte 
     * @param array $attributs 
     * @return Form 
     */
     
     //on fait avec ajout(en francais, mais on peut mettre n'import quel nom !)
    public function ajoutLabelFor(string $for, string $text, array $attributs = []): self
    {
        // on ouvre la balise
        $this->formCode .= "<label for='$for' class='my-3 col-md-12 col-sm-12 col-12'";

        // on ajoute des attrubuts

        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // on ajoute le texte
        $this->formCode .= ">$text</label>";

        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs = []): self
    {
        // on ouvre la balise
        $this->formCode .= "<input type='$type' name='$nom' class='form-control'";
        
        //on ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    /**
     * Ajoute un champ textarea
     * @param string $nom Nom du champ
     * @param string $valeur Valeur du champ
     * @param array $attributs Attributs
     * @return Form Retourne l'objet
     */

    public function ajoutTextarea(string $nom, string $valeur = '', array $attributs = []): self
    {
        // on ouvre la balise
        $this->formCode .= "<textarea name='$nom' rows='5' class='col-md-12 col-sm-12 col-12'";

        // on ajoute des attrubuts

        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // on ajoute le texte
        $this->formCode .= ">$valeur</textarea>";

        return $this;
    }

    /**
     * Liste déroulante
     * @param string $nom Nom du champ
     * @param array $options Liste des options (tableau associatif)
     * @param array $attributs 
     * @return Form
     */

    public function ajoutSelect(string $nom, array $options, array $attributs = []): self
    {
        // On crée le select
        $this->formCode .= "<select name='$nom' class='col-xl-2 col-lg-2 col-md-2 col-3'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        // On ajoute les options
        foreach($options as $valeur => $texte){
            $this->formCode .= "<option   value=\"$valeur\">$texte</option>";
    }

        // On ferme le select
        $this->formCode .= "</select>";

        return $this;
    }

    public function ajoutBouton(string $texte, array $attributs = []): self
    {
        // on ouvre le bouton
        $this->formCode .= "<button ";
           
        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // On ajoute le texte et on ferme
        $this->formCode .= ">$texte</button>";

        return $this;
    }




}