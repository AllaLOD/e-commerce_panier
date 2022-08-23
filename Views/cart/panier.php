<div class="panier">
<?php if(empty($_SESSION['panier']['id_panier'])): ?>

<h2 class='text-center my-5'>Votre panier est vide !</h2>
<h4 class="text-center my-3"><a class="lien_panier" href="/produits">Commencer mes achat</a></h4>

<?php else: ?>

    <h2 class="text-center my-3">Votre panier</h2>
        <div class="col-md-10 mx-auto col-12 table_panier">
        <table class="table table-bordered text-center my-5 shadow">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Stock disponible</th>
                    <th>Prix</th>
                    <th>Quantite</th>
                    <th>Total</th>
                    <th>Supprimer</th>
                </tr>    
            </thead>
            <tbody>
                <?php for($i = 0; $i < count($_SESSION['panier']['id_panier']); $i++): ?>

                <tr>
                    <td><?= $_SESSION['panier']['titre'][$i] ?></td>
                    <td><?= $_SESSION['panier']['stock'][$i] ?></td>
                    <td><?= $_SESSION['panier']['prix'][$i] ?>€</td>
                    <td>
                    <!-- modification de quantite d'aricle -->
                    <!-- <?= $_SESSION['panier']['quantite'][$i] ?> -->
                        <?php
                        $id = $_SESSION['panier']['id_panier'][$i];
                        ?> 
                    <form method="POST" action="/cart/modifier/<?= $id ?>">
                        <input type="hidden" id="id_panier" name="id_panier" value="<?= $_SESSION['panier']['id_panier'][$i] ?>">
                        <input type="number" name="quantite" min="1" max="<?= $_SESSION['panier']['stock'][$i] ?>" value="<?= $_SESSION['panier']['quantite'][$i] ?>">
                        <button type="submit" name="modifier" class="btn btn_panier"><i class="bi bi-arrow-repeat"></i></button>
                    </form> 
        
                    </td>
                    <!-- total pour un article -->
                    <td><?= $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i] ?>€</td>

                    <!-- supprision d'un article -->
                    <?php
                        $id = $_SESSION['panier']['id_panier'][$i];
                    ?> 
                    <td class="text-center"><a href="/cart/supprimer/<?= $id ?>" class="text-danger" onclick="return(confirm('Voulez-vous réellement supprimer <?= $_SESSION['panier']['titre'][$i]  ?> de votre panier ?'));"><i class="bi bi-trash3"></i></a></td>
                </tr>
                
                <?php endfor; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">Total :</td>
                    <td class="text-center"><?= $total ?> €</td>
                <!-- supprision de panier total -->
                    <td class="text-center"><a href="/cart/delate" class="text-danger"><i class="bi bi-trash3-fill"></i></a></td>

                </tr>
            </tfoot>
        </table>
    

        <h4 class="text-center my-3"><a class="lien_panier" href="/produits">Continuer les achats </a></h4>

            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
                <div class="d-flex justify-content-around text-center my-5"> 
                    <a  href="/cart/commande"><button type="button" class="btn btn_ajouter shadow">Commander <i class="bi bi-cart-check bi_ajouter"></i></button></a>
                </div>
                <?php else: ?>
                <div class="d-flex flex-column text-center my-5"> 
                    <a href="/users/login"><button type="button" class="btn btn-border btn_ajouter me-2">Pour commander - connectez-vous</button></a>
                    <h4>ou</h4>
                    <a href="/users/register"><button type="button" class="btn btn_ajouter">Inscrivez-vous</button></a>
                </div> 
            <?php endif; ?>

        <?php endif; ?>
        </div>
</div>
