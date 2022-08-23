<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopSite</title>
    <meta name="description" content="Exemple d’un site e-commerce avec affichage d’un panier , des commandes et d’un profil de l’utilisateur.">
    <meta name="keywords" content="e-commerce, panier, cart, profil, commande user, commandes user, galerie images, site exemple">
    <meta name="subject" content="e-commerce - exemple">
    <meta name="copyright" content="2022 - AllaLOD - ShopSite - exemple - tous droits reservés">
    <meta name="author" content="Alla Dumenil">
    <meta name="identifier-Url" content="https://www.shopsite.fr">
    <meta name="reply-to" content="contact@shopsite.fr">
    <meta name="revisit-after" content="1 day">
    <meta name="robots" content="all">

    <link rel="icon" type="image/gif" href="/uploads/logo/icons8_shopping_basket_64px_1.png">

    <!-- CSS only -->
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/CSS/style.css">
</head>
<body>
<div class="container-fluid" id="nav_home">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none"></a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 link-light">Home</a></li>
            <li><a href="/produits" class="nav-link px-2 link-light">Produits</a></li>
            <li><a href="/cart/panier" class="nav-link px-2 link-light"><i class="bi bi-basket2"></i></a></li>
            <li><a href="/main/contact" class="nav-link px-2 link-light">Contact</a></li>
          <!-- condition à affichage BACKOFFICE -->
          <?php if(isset($_SESSION['user']['roles']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])): ?>    
            <li><a href="/admin" class="nav-link px-2 link-light">BACOFFICE</a></li>
            <?php endif; ?>
        </ul>

        <div class="col-md-3 text-end">

        <!-- si l'utilisateur n'est pas connecté ou n'est pas enregistré il peut s'inscrire -->
        <?php if(!isset($_SESSION['user']) && empty($_SESSION['user']['id'])): ?>
            <a href="/users/login"><button type="button" class="btn btn_nav me-2">Connexion</button></a>
            <a href="/users/register"><button type="button" class="btn btn_nav">Inscription</button></a>
            <?php else: ?>
                <div class="d-flex">
                <a class="nav-link" href="/users/profil"><button type="button" class="btn btn_nav me-2">Profil</button></a>
                <a class="nav-link" href="/users/logout"><button type="button" class="btn btn_nav me-2">Déconnexion</button></a>
                </div>
        <?php endif; ?>
        
        </div>
    </header>
</div>
<main>
<div class="container col-sm-fluid">
<?php
    if(isset($_SESSION['erreur']))
        echo $_SESSION['erreur'];    
?>
<?php unset($_SESSION['erreur']); ?>

<!-- on reserve la place pour injecter le contenue -->
<?= $contenu ?>
</div>
</main>
<footer class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mt-4 border-top">
    <div class="mx-auto">
   
    <h2 class="text-center"><a href="https://github.com/AllaLOD?tab=projects&type=beta" target="blanc"><i class="bi bi-github text-light"></i></a></h2>
    <small class="mb-3 text-light">&copy; 2022 - AllaLOD - ShopSite - exemple - tous droits reservés</small>
    </div>
    </div>
</footer>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="/JS/script.js" type="text/javascript"></script>  
</body>
</html>