<h2 class="text-center my-5">Ajouter un produit</h2>

<div class="container">

<?php
if(isset($_SESSION['erreur']))
 echo $_SESSION['erreur'];


?>

<?= $form ?>

</div>