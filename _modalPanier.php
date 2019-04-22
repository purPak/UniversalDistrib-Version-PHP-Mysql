<div id="ud-panier" class="panier-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content col-xl-8 col-10">
            <div class="modal-header">
                <h2 class="modal-title">Mon Panier</h2><br>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="post">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="">Produit</th>
                                <th class="">Prix Unitaire</th>
                                <th class="">Quantité</th>
                                <th class="text-center">Sous-total</th>
                                <th class=""></th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if(creationPanier()) :
                            $nbProduit=count($_SESSION['panier']['idProduit']);
                            if($nbProduit<=0) : ?>
                                <tr>
                                    <td>Votre panier est vide </td>
                                </tr>
                            <?php else :
                                for ($i=0 ;$i<$nbProduit ; $i++) : ?>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-1"><img class="img-fluid" src="img/ud-produit/<?php echo $_SESSION['panier']['imageProduit'][$i]; ?>" alt="Image <?php echo $_SESSION['panier']['nomProduit'][$i]; ?>"/></div>
                                            <div class="col-11">
                                                <h4><?php echo $_SESSION['panier']['nomProduit'][$i]; ?></h4>
                                                <h6><?php echo $_SESSION['panier']['catProduit'][$i]; ?> - <?php echo $_SESSION['panier']['subcatProduit'][$i]; ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $_SESSION['panier']['prixProduit'][$i].'&nbsp;'.$_SESSION['panier']['deviseProduit'][$i]; ?></td>
                                    <td>
                                        <div class="counter js-counter">
                                            <div class="counter-item">
                                                <a class="counter-minus js-counter-btn" data-action="minus"></a>
                                            </div>
                                            <div class="counter-item counter-item-center">
                                                <input class="counter-value js-counter-value" title="Quantité" type="text" name="qteModif[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]; ?>">
                                            </div>
                                            <div class="counter-item">
                                                <a class="counter-plus js-counter-btn" data-action="plus"></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?php echo $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i].'&nbsp;'.$_SESSION['panier']['deviseProduit'][$i]; ?></td>
                                    <td>
                                        <button class="btn btn-info" type="submit" name="action" value="refresh"><i class="fa fa-refresh"></i></button>
                                        <a class="btn btn-danger" href="?action=delete&id=<?php echo $_SESSION['panier']['idProduit'][$i]; ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php endfor;
                            endif;
                        endif; ?>
                        </tbody>
                    </table>
                    <div class="text-right"><strong class="text-muted">Total:</strong>&nbsp;<?php echo MontantTotal(); ?>&nbsp;&euro;&nbsp;</div>
                    <br>
                    <div>
                        <a class="btn btn-warning pull-left" href="produits.php"><i class="fa fa-angle-left"></i> Continuer mes achats</a>
                        <a class="btn btn-success pull-right" href="commande-recap.php">Valider mon panier <i class="fa fa-angle-right"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>