
<?php foreach($details as $detail) ?>
<h1 class="text-center my-5">Détails de commande N° <?= $detail->id_com ?></h1>

<div class="container">
    <div class="col-md-8 mx-auto">
        <!-- affichage de utilisateur -->
        <h5>Utilisateur :</h5>
        <?php foreach($users as $user) ?>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$user->id ?></td>
                    <td><?=$user->nom ?></td>
                    <td><?=$user->email ?></td>
                </tr>
            </tbody>
        </table>
        <h5>Produits :</h5>
        <!-- affichage des produits -->
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>ID produit</th>
                    <th>Titre</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($details as $detail): ?>
                <tr>
                    <td><?= $detail->id ?></td>
                    <td><?= $detail->titre ?></td>
                    <td><?= $detail->quantite ?></td>
                    <td><?= $detail->prix ?>€</td>
                    <!-- affichage total pour un produit "prix" * "quantite" -->
                    <td><?= $detail->prix * $detail->quantite ?>€</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tr>
            <td colspan="5" class="text-end">Total : <?= $detail->montant ?> €</td>
            </tr>
        </table>


    </div>

</div>