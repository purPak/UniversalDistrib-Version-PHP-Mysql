<?php
// Début de la session
session_start();

// Appel des fonctions PHP
require_once("_BDDconnect.php");
require_once("_fonctionsPanier.php");

// Création du panier
creationPanier();

// Déclaration des variables
$e = 1;
$id_affc = (int)verif("id_affc");
$id_affsc = (int)verif("id_affsc");

// Requêtes SQL
$category = mysqli_query($connect, "SELECT * FROM categories;");
$subcategory = mysqli_query($connect, "SELECT * FROM souscategories;");

// Gestion des fonctions du Panier
$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null) {

    // Récuperation et vérification des variables en POST ou GET
    if (verif('id')) {
        $id = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null));
    }
    if (verif('qte')) {
        $qte = (isset($_POST['qte']) ? $_POST['qte'] : (isset($_GET['qte']) ? $_GET['qte'] : null));
    }

    // Identification de l'action effectuée
    if (in_array($action, array('add', 'delete', 'refresh'))) {
        switch ($action) {
            Case "add":
                $qte = intval($qte);
                if ($qte > 0) {
                    $dataProduct = mysqli_fetch_array(mysqli_query($connect, "$queryProduct WHERE produit_id=$id"));
                    ajouterProduit($id, $qte, $dataProduct);
                }
                break;

            Case "delete":
                supprimerProduit($id);
                break;

            Case "refresh" :
                $lengthArray = count($_POST['qteModif']);
                if ($lengthArray>1) {
                    $qteProduit = array();
                    foreach ($_POST['qteModif'] as $contenu) {
                        $contenu = intval($contenu);
                        if ($qte >= 0) {$errorContenu=true;}
                        $qteProduit[] = $contenu;
                    }
                    if ($errorContenu!=true) {
                        for ($i = 0; $i < count($qteProduit); $i++) {
                            modifierQteProduit($_SESSION['panier']['idProduit'][$i], $qteProduit[$i]);
                        }
                    }
                } else {
                    $qte = intval(current($_POST['qteModif']));
                    if ($qte >= 0) {
                        modifierQteProduit($_SESSION['panier']['idProduit'][key($_POST['qteModif'])], $qte);
                    }
                }
                break;

            Default:
                break;
        } sauvegardePanier();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>

        <!-- Meta Section -->
        <?php include_once "_meta.php"?>

        <title>Récapitulatif de la commande - Universal Distrib</title>

        <!-- Stylesheets Section -->
        <?php include_once "_stylesheets.php"?>

    </head>

    <body>

        <!-- Navigation Section -->
        <?php include_once "_navbar.php"?>

        <!-- Étape Commande Section -->
        <?php include_once "_etapeCommande.php" ?>

        <!-- Header Section -->
        <header>
            <div class="container">
                <hr><h1>Récapitulatif de la Commande</h1><hr>
            </div>
        </header>

        <!-- Recap Section -->
        <section class="recapitulatif">
            <div class="container">
                <form method="post" action="commande-recap.php">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>Produit</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th class="text-center">Sous-total</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if(creationPanier()) :
                            $nbProductCart=count($_SESSION['panier']['idProduit']);
                            if($nbProductCart<=0) : ?>
                                <tr>
                                    <td>Votre panier est vide </td>
                                </tr>
                            <?php else :
                                for ($i=0 ;$i<$nbProductCart ; $i++) : ?>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-2"><img class="img-fluid" src="img/ud-produit/<?php echo $_SESSION['panier']['imageProduit'][$i]; ?>" alt="Image <?php echo $_SESSION['panier']['nomProduit'][$i]; ?>"/></div>
                                                <div class="col-10">
                                                    <h4><?php echo $_SESSION['panier']['nomProduit'][$i]; ?></h4>
                                                    <h6><?php echo $_SESSION['panier']['catProduit'][$i]; ?> - <?php echo $_SESSION['panier']['subcatProduit'][$i]; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $_SESSION['panier']['prixProduit'][$i].'&nbsp;'.$_SESSION['panier']['deviseProduit'][$i]; ?></td>
                                        <td><input class="form-control text-center" title="Quantité" type="text" size="2" name="qteModif[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]; ?>"></td>
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
                        <a class="btn btn-success pull-right" href="commande-seconnecter.php">Valider ma commande <i class="fa fa-angle-right"></i></a>
                    </div>
                </form>
            </div>

            <div class="row sizeinteresser">
                <div class="offset-md-4 col-md-4 offset-sm-3 col-sm-6">
                    <p class="text-center bg-dark text-white">CE QUI PEUT AUSSI VOUS INTERESSER</p>
                </div>
            </div>

            <div class="row colorbackground">
                <div class="col-md-12">
                    <div class="row text-center">
                        <div class="offset-md-0 col-md-4 offset-sm-2 col-sm-3 offset-0 col-3">
                            <h3>Drink</h3>
                        </div>
                        <div class="offset-md-0 col-md-4  col-sm-3 col-3">
                            <h3>Softs</h3>
                        </div>
                        <div class="offset-md-0 col-md-4  col-sm-3 col-3">
                            <h3>Alcools</h3>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="offset-md-0 col-md-4 offset-sm-2 col-sm-3 offset-0 col-3">
                            <h3>Spiritueux</h3>
                        </div>
                        <div class="offset-md-0 col-md-4 o col-sm-3 col-3">
                            <h3>Promo</h3>
                        </div>
                        <div class="offset-md-0 col-md-4 col-sm-3 col-3">
                            <h3>Nouveauté</h3>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container">
                <h4>Nous vous proposons également :</h4>
                <div class="row">
                    <?php $t=0; while($t<6) : ?>
                    <div class="col-md-4">
                        <div class="padding">
                            <div class="s_service_text text-sm-center text-xs-center">
                                <img class="img-fluid imagepadding" src="img/ud-image/drink-category.png" alt="parsole che">
                            </div>
                            <div class="text-center">
                                <p><b>Che parasol</b></p>
                            </div>
                        </div>
                    </div>
                    <?php $t+=1; endwhile; ?>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <?php include_once "_footer.php"?>

        <!-- Scripts Section -->
        <?php include_once "_scripts.php" ?>

    </body>

</html>

