<!-- Product Modal -->
<?php while($row_product=mysqli_fetch_array($product)) : ?>
    <div id="ud-product-<?php echo $row_product['produit_id'];?>" class="product-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content col-xl-8 col-10">
                <div class="modal-header">
                    <h2 class="modal-title"><?php echo $row_product['nom_produit'];?></h2><br>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <img class="img-fluid d-block mx-auto" src="img/ud-produit/<?php echo $row_product['image_produit'];?>" alt="Image Che">
                            </div>

                            <div class="col-6">
                                <h5 class="text-muted text-center"><?php echo $row_product['nom_categorie'].' - '.$row_product['nom_souscategorie'].' - '.$row_product['nom_produit']; ?></h5>
                                <input type="hidden" name="id" value="<?php echo $row_product['produit_id']; ?>">
                                <br>
                                <h5>Prix: <?php echo $row_product['pu'];?>&nbsp;<?php echo $row_product['devise'];?></h5>
                                <br>
                                <h5>Description</h5>
                                <p><?php echo $row_product['description'];?></p>
                                <div class="col-12">
                                    <img src="img/ud-produit/<?php echo $row_product['image_produit'];?>" class="img-thumbnail" alt="Image <?php echo $row_product['nom_produit'];?>">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="row justify-content-center">
                                    <div class="form-group row">
                                        <label for="qte-product-<?php echo $row_product['produit_id'];?>" class="col-7 col-form-label">Quantité :</label>
                                        <div class="counter js-counter col-5">
                                            <div class="counter-item">
                                                <a class="counter-minus js-counter-btn" <?php if ($row_product['statue']!=='rupture') echo 'data-action="minus"'; ?>></a>
                                            </div>
                                            <div class="counter-item counter-item-center">
                                                <input class="counter-value js-counter-value" id="qte-product-<?php echo $row_product['produit_id'];?>" type="text" value="1" tabindex="-1" <?php if ($row_product['statue']==='rupture') echo 'disabled'; ?>/>
                                            </div>
                                            <div class="counter-item">
                                                <a class="counter-plus js-counter-btn" <?php if ($row_product['statue']!=='rupture') echo 'data-action="plus"'; ?>></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <?php if ($row_product['statue']==='rupture') : ?>
                                            <h5 class="text-center text-warning">Indisponible pour le moment</h5>
                                        <?php else : ?>
                                            <h5 class="text-center text-success">Disponible maintenant</h5>
                                        <?php endif; ?>
                                    </div>

                                    <button class="btn btn-primary" <?php if ($row_product['statue']==='rupture') echo 'disabled'; else echo 'type="submit" name="action" value="add"'; ?>>
                                        <i class="fa fa-shopping-cart"></i>&nbsp;Ajouter au Panier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>