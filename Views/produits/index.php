<h1 class="text-center my-5">Nos produits</h1>

<div class="container rounded" id="affichage_produits">
    
      <div class="d-flex flex-wrap">
        <?php foreach($produits as $produit): ?>

          <div class="card card_index mx-auto my-3 rounded" style="width: 18rem;">
                <div class="card-header">
                  <h5 class="text-center"><?= $produit->titre ?></h5>  
                </div>
                <img class="mx-auto mt-2 rounded shadow" src="/uploads/images/<?= $produit->image ?>" width="200" alt="<?= $produit->titre ?>">
                <div class="card-body">
                    <p>Stock : <?= $produit->stock ?></p>
                <h5>Prix : <?= $produit->prix ?>€</h5>
                <div class="text-center">
                    <a href="/produits/details/<?= $produit->id ?>"><button type="button" class="btn btn_index shadow-lg" >Voir l'article</button></a>
                </div>
                </div>
          </div>

        <?php endforeach; ?>
      </div>
    
</div>