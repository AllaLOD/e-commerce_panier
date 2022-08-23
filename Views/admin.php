<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BACOFFICE</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/CSS/admin.css">
</head>
<body>
<div class="container-fluid" id="nav_admin">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto ps-5 text-decoration-none">
        <button type="button" class="btn  btn_admin">ShopSite</button>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/admin" class="nav-link link-light">Produits</a></li>
        <li class="nav-item"><a href="/admin/produit" class="nav-link link-light">Ajouter produit</a></li>
        <li class="nav-item"><a href="/admin/users" class="nav-link link-light">Utilisateures</a></li>
        <li class="nav-item"><a href="/admin/commandes" class="nav-link link-light">Commandes</a></li>
        <li class="nav-item"><a href="/admin/contact" class="nav-link link-light">Messages</a></li>
      </ul>
    </header>
  </div>


   

<!-- on reserve la place pour injecter le contenue -->
<?= $contenu ?>
    



 <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>   
</body>
</html>