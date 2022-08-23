<div class="container">
    <div class="d-flex flex-column text-center">
        <div class="card col-md-8 mx-auto">
            <div class="card-body shadow-lg">
                <h2><?= $produit->titre ?></h2>
                <img class="mx-auto my-2" src="/uploads/images/<?= $produit->image ?>" width="300" alt="<?= $produit->titre ?>">
                <p><?= $produit->description ?></p>
                <h4>Stock : <?= $produit->stock ?></h4>
                <h4>Prix : <?= $produit->prix ?>€</h4>
                <h3>
                     <!--on ajoute au panier le quantite choisie par raport au stock -->
                     <?php if($produit->stock > 0): ?> 
                        <span class="pb-2">Ajouter au panier:</span>
                        <div class="text-center col-md-8 col-6 mx-auto">
                        <form method="post"  action="/cart/ajouter/<?= $produit->id ?>">
                                <div class="col-md-3 mx-auto my-3">
                                <input type="hidden" id="id" name="id" value="<?= $produit->id ?>">
                                <select class="form-control btn_ajouter" id="quantite" name="quantite"> 
                                <?php for($i = 1; $i <= $produit->stock; $i++): ?>

                                        <option value="<?= $i ?>"><?= $i ?></option>

                                <?php endfor; ?>
                                </select>
                                </div>
                                <div class="col-auto">
                                        <button type="submit" class="btn btn_ajouter"><i class="bi bi-cart-plus"></i></button>       
                                </div> 
                        </form> 
                        <?php else: ?>
                            <span class="pb-2">Rupture du stock !</span>
                        </div>   

                        <?php endif; ?> 
                </h3>

            </div>
        </div>

    </div>

</div>