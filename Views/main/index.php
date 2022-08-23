<h1 class="text-center my-5">Exemple de mon petit ShopSite</h1>

<div class="container shadow-lg" id="main">

<!-- gallery des images --> 

<?php foreach($produits as $produit); ?>

<div class="col-md-9 mx-auto">
    <div class="d-flex flex-column justify-content-around">
           
            <img class="my-5 mx-auto" src="/uploads/images/<?= $produit->image ?>" alt="<?= $produit->titre ?>" id="expandedImg" width="60%">
    </div>
</div>
    <!-- La grille : nombre de produits = nombre colonnes-->
        <div class="col-md-10 mx-auto mt-5">
                <div class="d-flex justify-content-around flex-wrap">

                    <?php foreach($produits as $produit): ?>
                    
                        <div class="col-md-2 col-4 px-2">
                            <img class="mb-5" src="/uploads/images/<?= $produit->image ?>" alt="<?= $produit->titre ?>" width="99%" onclick="myFunction(this);">
                        </div>

                    <?php endforeach; ?>   
                </div>
            </div>
        </div>


          

</div>