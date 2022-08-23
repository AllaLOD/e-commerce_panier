<?php foreach($details as $detail); ?>

<h1 class="text-center my-5">Détail de votre commande N° :<?= $detail->id_com ?></h1>

<p class="text-center mb-3">enregestré le <?= $detail->date ?></p>

<div class="col-md-8 mx-auto">
<table class="table table-responsive table-bordered border_details text-center mt-5 shadow-lg">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Image de produit</th>
            <th>Quantité</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($details as $detail): ?>
            <tr>
                <td><?= $detail->titre ?></td>
                <td><img class="mx-auto mt-2 rounded shadow" src="/uploads/images/<?= $detail->image ?>" width="100"></td>
                <td><?= $detail->quantite ?></td>
                <td><?= $detail->prix ?>€</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-end">Total :<?= $detail->montant ?>€<?php
            
            ?></td>
        </tr>

    </tfoot>
</table>
</div>
