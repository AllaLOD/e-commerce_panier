<h1 class="text-center my-5" >Gérer les commandes</h1>
<div class="container">
    <div class="col-md-8 mx-auto">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($commandes as $commande): ?>
                        <tr>
                            <td><?= $commande->id_com ?></td>
                            <td><?= $commande->date ?></td>
                            <td><?= $commande->montant ?></td>
                            <td><a href="/admin/detailsAdmin/<?= $commande->id_com ?>">Voir détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>


            </table>
    </div>
</div>