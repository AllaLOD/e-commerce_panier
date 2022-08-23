<div class="panier">
<h2 class="text-center my-5">Détails de votre commande N° : <?= $_SESSION['id_com'] ?></h2>

<div class="card rounded shadow-lg">
    <div class="col-md-10 mx-auto col-12">
        <table class="table table-bordered table-responsive border_details text-center mt-5">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($details as $detail): ?>
                    <tr>
                        <td><?= $detail->titre ?></td>
                        <td><?= $detail->quantite ?></td>
                        <td><?= $detail->prix ?>€</td>
                    </tr>
                    <?php endforeach; ?>   
            </tbody>
            <tfoot>
            <?php foreach($details as $detail): ?>
                <tr>
                    <td colspan="3" class="text-end"><h6>Total :<?= $detail->montant ?>€</h6></td>
                </tr>
                <?php endforeach; ?>   
            </tfoot>
        </table>
        <p class="text-center mb-5">enregestré le <?= $detail->date ?></p>
    </div>
</div>
</div>