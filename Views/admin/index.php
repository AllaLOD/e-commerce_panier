<h2 class="text-center my-5 mx-auto">Liste de produits</h2>

<!-- affichage de $_SESSION message  -->
<?php
    
    if(isset($_SESSION['erreur']))
        echo $_SESSION['erreur'];
?>
    <?php unset($_SESSION['erreur']); ?>    


<div class="container-fluid">
    <div class="d-flex mx-5">
    <table class="table-responsive table-bordered border-success text-center my-3">
        <thead>
            <tr>
                <td>ID</td>
                <td>Titre</td>
                <td>Descripttion</td>
                <td>Image</td>
                <td>Stock</td>
                <td>Prix</td>
                <td><i class="bi bi-pencil-square text-dark"></i></td>
                <td><i class="bi bi-trash3-fill text-danger"></i></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($produits as $produit): ?>
                <tr>
                    <td><?= $produit->id ?></td>
                    <td><?= $produit->titre ?></td>
                    <td><?= $produit->description ?></td>
                    <td><img class="mx-auto mt-2" src="/uploads/images/<?= $produit->image ?>" width="50" alt="<?= $produit->titre ?>"></td>
                    <td><?= $produit->stock ?></td>
                    <td><?= $produit->prix ?>€</td>
                    <td><a href="/admin/modifierProduit/<?= $produit->id ?>"><i class="bi bi-pencil-square text-info"></i></a></td>
                    <td><a href="/admin/deleteProduit/<?= $produit->id ?>"><i class="bi bi-trash3 text-danger"></i></a></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
