<?php
// Début de la session
session_start();

// Appel des fonctions PHP
require_once("_BDDconnect.php");
include_once("_fonctionsPanier.php");

// Création du panier
creationPanier();

// Déclaration des variables
$id_affc = (int)verif("id_affc");
$id_affsc = (int)verif("id_affsc");

// Requêtes SQL
$category = mysqli_query($connect, "SELECT * FROM categories;");
$subcategory = mysqli_query($connect, "SELECT * FROM souscategories;");
$queryProduct = "SELECT produit_id, p.nom AS nom_produit, c.categorie_id AS categorie_id, c.nom AS nom_categorie, sc.souscategorie_id AS souscategorie_id, sc.nom AS nom_souscategorie, pu, tva, devise, majeur, description, p.image AS image_produit, statue FROM produits AS p INNER JOIN souscategories AS sc ON p.souscategorie_id=sc.souscategorie_id INNER JOIN categories AS c ON sc.categorie_id=c.categorie_id";

// PAGINATION
// Requête en fonction des catégories et sous-catégories
if($id_affc){
    $queryProductInCat= "$queryProduct WHERE c.categorie_id=$id_affc";
    $product=mysqli_query($connect, $queryProductInCat);
} elseif($id_affsc){
    $queryProductInSubCat= "$queryProduct WHERE c.categorie_id=$id_affsc";
    $product=mysqli_query($connect,$queryProductInSubCat);
} else{
    $product=mysqli_query($connect, $queryProduct);
}

// Nombre de produit
$nbProduct= mysqli_num_rows($product);

// Nombre de resultats par page
$productByPage=8;

// Nombre total de page
$nbPages = ceil($nbProduct/$productByPage);

// Détermination de la page actuel
if(!isset($_GET['page'])) {
    $page=1;
} else {
    $page=$_GET['page'];
}

// Page précédente
$prevPage = $page-1;

// Page suivante
$nextPage = $page+1;

// Détermination de la limite dans la requète SQL
$productOffset = ($page-1)*$productByPage;

// Requête de pagination en fonction des catégories et sous-catégories
if($id_affc) {
    $product = mysqli_query($connect,"$queryProductInCat LIMIT $productByPage OFFSET $productOffset");
}elseif ($id_affsc){
    $product=mysqli_query($connect,"$queryProductInSubCat LIMIT $productByPage OFFSET $productOffset");
}else{
    $product=mysqli_query($connect, "$queryProduct LIMIT $productByPage OFFSET $productOffset");
}

// Gestion des fonctions du Panier
$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
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
        <!-- Meta -->
        <?php include_once "_meta.php"?>

        <title>Produits - Universal Distrib</title>

        <!-- Stlylesheet CSS -->
        <?php include_once "_stylesheets.php"?>
    </head>

    <body>

        <!-- Navigation Section -->
        <?php include_once "_navbar.php"?>

        <!-- Modal Panier -->
        <?php include_once "_modalPanier.php"; ?>

        <!-- Header Section -->
        <header id="product-header">
            <div class="product-search">
                <form class="form-inline justify-content-center" method="post" action="search.php">
                    <input class="form-control" type="search" name="search" placeholder="Rechercher un produit..." aria-label="ProductSearch">
                    <button class="btn btn-secondary" type="submit" name="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </header>

        <!-- Subcategory Section -->
        <section id="subcategory">
            <div id="subcategoryCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-img">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <?php $compteur=1; $limite=8;  while($row_souscategorie=mysqli_fetch_array($subcategory)) :
                                        if(empty($id_cat)){$row_categorieproduit=mysqli_fetch_array($product); $id_cat=$row_categorieproduit['categorie_id']; mysqli_data_seek($product, 0);}
                                        if($row_souscategorie['categorie_id']==$id_affc || $row_souscategorie['categorie_id']==$id_cat) :
                                            if($compteur>$limite) :
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-img">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <?php $limite*=2; endif; ?>
                                    <div class="col-lg-3 col-6">
                                        <h2 class="subcategory-name"><?= $row_souscategorie['nom']; ?></h2>
                                        <?php if($row_souscategorie['souscategorie_id']==$id_affsc) :?><img class="griffe" src="img/ud-image/griffes.png"><?php endif; ?>
                                    </div>
                                    <?php $compteur+=1; endif;
                                    endwhile; mysqli_data_seek($subcategory, 0); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="subcategory-pager">
                    <a class="left-indicator" href="#subcategoryCarousel" role="button" data-slide="prev"><div><i class="fa fa-arrow-circle-o-left"></i></div></a>
                    <a class="right-indicator" href="#subcategoryCarousel" role="button" data-slide="next"><div><i class="fa fa-arrow-circle-o-right"></i></div></a>

                    <ol class="carousel-indicators">
                        <?php for ($i=0; $i<$limite/8; $i++) : ?>
                            <li data-target="#subcategoryCarousel" data-slide-to="<?= $i; ?>" <?php if ($i===0) echo 'class="active"'; ?>></li>
                        <?php endfor; ?>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Produit Section -->
        <section id="product">
            <div class="col-12 text-center">
                <div class="product-title">
                    <h2>Produits</h2>
                </div>

                <div class="product-list row">
                    <?php while($row_product=mysqli_fetch_array($product)) :
                        $position=0;
                        $nbElement=count($_SESSION['panier']['idProduit']);
                        while ($position<$nbElement) :
                            if ($row_product['produit_id']==$_SESSION['panier']['idProduit'][$position]) {
                                $positionProductInCart = $position;
                            } $position+=1;
                        endwhile;
                        ?>
                        <div class="product-item col-xl-3 col-lg-4 col-6 <?php if ($row_product['statue']==='rupture') echo 'rupture'; ?>">
                            <div class="product-header jumbotron">
                                <?php if (!isset($positionProductInCart)) :
                                    if ($row_product['statue']==='new') {$imgProduct = 'new-icon.png';}
                                    elseif ($row_product['statue']==='promo') {$imgProduct = 'promo-icon.png';}
                                    elseif ($row_product['statue']==='rupture') {$imgProduct = 'rupture-icon.png';}
                                    else {
                                        while ($row_category=mysqli_fetch_array($category)) {
                                            if ($row_product['nom_categorie'] === $row_category['nom']) {$imgProduct = strtolower($row_product['nom_categorie']) . '-icon.png';}
                                        } mysqli_data_seek($category, 0);
                                    } ?>
                                    <img class="<?php if ($row_product['statue']==='rupture') echo 'product-icon'; else echo 'counter-img'; ?>" src="img/ud-icon/<?= $imgProduct ?>"/>
                                <?php endif; if ($row_product['statue']!='rupture') : ?>
                                <div class="counter js-counter">
                                    <div class="counter-item">
                                        <a class="counter-minus js-counter-btn" data-action="minus">
                                            <i class="fa fa-minus js-counter-btn" data-action="minus"></i>
                                        </a>
                                    </div>
                                    <div class="counter-item counter-item-center">
                                        <form method="post" autocomplete="off">
                                            <input class="counter-value js-counter-value" title="Quantité" name="<?php if (isset($positionProductInCart)) echo "qteModif[$positionProductInCart]"; else echo 'qte'; ?>" type="text" min="0" max="9" value="<?php if (isset($positionProductInCart)) echo $_SESSION['panier']['qteProduit'][$positionProductInCart]; else echo '0'; ?>" tabindex="-1"/>
                                            <button class="counter-valid btn" type="submit" name="action" value="<?php if (isset($positionProductInCart)) echo 'refresh'; else echo 'add'; ?>">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <?php if (!isset($positionProductInCart)) : ?><input type="hidden" name="id" value="<?php echo $row_product['produit_id']; ?>"><?php endif; $positionProductInCart = NULL; ?>
                                        </form>
                                    </div>
                                    <div class="counter-item">
                                        <a class="counter-plus js-counter-btn" data-action="plus">
                                            <i class="fa fa-plus js-counter-btn" data-action="plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-body jumbotron">
                                <a data-toggle="modal" href="#ud-product-<?= $row_product['produit_id']; ?>">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div>
                                                    <h3><?= $row_product['nom_produit']; ?></h3>
                                                    <h4><?= $row_product['pu']; ?>&nbsp;<?= $row_product['devise']; ?></h4>
                                                    <p><?= $row_product['description']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div>
                                                    <img class="img-fluid" src="img/ud-produit/<?= $row_product['image_produit']; ?>" alt="Image Che">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; mysqli_data_seek($product, 0); ?>
                </div>

                <nav class="product-pager">
                    <ul class="pagination justify-content-center">
                        <?php if ($prevPage <= $nbPages AND $prevPage !=0) : ?>
                            <li class="page-item">
                                <?php if ($id_affc) : ?>
                                    <a class="page-link" href="produits.php?id_affc=<?= $id_affc; ?>&amp;page=<?= $prevPage; ?>">Précédent</a>
                                <?php elseif ($id_affsc) : ?>
                                    <a class="page-link" href="produits.php?id_affsc=<?= $id_affsc; ?>&amp;page=<?= $prevPage; ?>">Précédent</a>
                                <?php else : ?>
                                    <a class="page-link" href="produits.php?page=<?= $prevPage; ?>">Précédent</a>
                                <?php endif; ?>
                            </li>
                        <?php endif ?>

                        <?php for ($i=1; $i<=$nbPages; $i++) :?>
                            <li class="page-item">
                                <?php if ($id_affc) : ?>
                                    <a class="page-link <?php if($i==$page) echo "pageActuelle"; ?>" href="produits.php?id_affc=<?php echo $id_affc; ?>&amp;page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php elseif($id_affsc) : ?>
                                    <a class="page-link <?php if($i==$page) echo "pageActuelle"; ?>" href="produits.php?id_affsc=<?php echo$id_affsc; ?>&amp;page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php else : ?>
                                    <a class="page-link <?php if($i==$page) echo "pageActuelle"; ?>" href="produits.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php endif; ?>

                            </li>
                        <?php endfor; ?>

                        <?php if ($nextPage == $nbPages) : ?>
                            <li class="page-item">
                                <?php if ($id_affc) : ?>
                                    <a class="page-link" href="produits.php?id_affc=<?= $id_affc; ?>&amp;page=<?= $nextPage; ?>">Suivant</a>
                                <?php elseif ($id_affsc) : ?>
                                    <a class="page-link" href="produits.php?id_affsc=<?=$id_affsc; ?>&amp;page=<?= $nextPage; ?>">Suivant</a>
                                <?php else : ?>
                                    <a class="page-link" href="produits.php?page=<?= $nextPage; ?>">Suivant</a>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </section>

        <!-- News Section -->
        <?php include_once "_news.php" ?>

        <!-- Footer Section -->
        <?php include_once "_footer.php"?>

        <!-- Products Modals -->
        <?php include_once "_modalProduits.php" ?>

        <!-- Javascript Section -->
        <?php include_once "_scripts.php" ?>

    </body>
</html>