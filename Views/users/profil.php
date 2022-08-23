<div class="container profil">
<h1 class="text-center my-5">Bonjour
    <?php if(isset($_SESSION['user']) &&  $_SESSION['user']['civilite'] == 1): ?>
    Madame
    <?php else: ?>
    Monsieur
    <?php endif; ?>
    <span><?= $_SESSION['user']['nom'] ?> <?= $_SESSION['user']['prenom'] ?></span></h1>

    <!-- condition pour affichage des commanfdes -->

<?php if(isset($commandes) && $commandes != null): ?>
<div class="card card_profil shadow-lg">
<h1 class="text-center my-3">Vos commandes :</h1>

<div class="d-flex flex-wrap">

<?php foreach($commandes as $commande): ?>
        <div class="card mx-auto my-3" style="width: 18rem">
            <div class="card-body">
                <h5>Commande N°<?= $commande->id_com ?></h5>
                <p>enregistré le <?= $commande->date ?></p>
                <h5>Total : <?= $commande->montant ?>€</h5>
                <p>
                    <div class="text-center">
                            <a href="/users/details/<?= $commande->id_com ?>"><button type="button" class="btn btn_ajouter shadow-lg" >Voir les détails</button></a>
                    </div>
                </p>

            </div>
        </div>
<?php endforeach; ?>
</div>
<?php else: ?>

<h3 class="text-center">Vous n'avez pas de commandes</h3>

<?php endif; ?>





</div>