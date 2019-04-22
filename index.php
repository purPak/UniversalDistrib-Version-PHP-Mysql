<?php
// Début de la session
session_start();

// Appel des fonctions PHP
require_once("_BDDconnect.php");
include_once("_fonctionsPanier.php");

// Création du panier
creationPanier();

// Déclaration des variables
$id_affc=(int)verif("id_aff");
$id_affsc=(int)verif("id_aff");

// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");

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
        <?php include_once "_meta.php"; ?>

        <title>Accueil - Universal Distrib</title>

        <!-- Stylesheet -->
        <?php include_once "_stylesheets.php"; ?>

    </head>

    <body>

        <!-- Navigation Section -->
        <?php include_once "_navbar.php"; ?>

        <!-- Panier Section -->
        <?php include_once "_modalPanier.php"; ?>

        <!-- Header Section -->
        <header id="home-header">
            <div id="homeHeaderCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#homeHeaderCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#homeHeaderCarousel" data-slide-to="1"></li>
                    <li data-target="#homeHeaderCarousel" data-slide-to="2"></li>
                </ol>
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-caption">
                            <div>Universal Distrib</div>
                            <div>Placer ici le slogan de Universal Distrib</div>
                            <a class="btn btn-more btn-primary text-uppercase" href="#">VOIR PLUS</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption d-none d-md-block">
                            <div>Universal Distrib</div>
                            <div>Placer ici le slogan de Universal Distrib</div>
                            <a class="btn btn-more btn-primary text-uppercase" href="#">VOIR PLUS</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption d-none d-md-block">
                            <div>Universal Distrib</div>
                            <div>Placer ici le slogan de Universal Distrib</div>
                            <a class="btn btn-more btn-primary text-uppercase" href="#">VOIR PLUS</a>
                        </div>
                    </div>
                </div>
                <!-- Carousel nav -->
                <a class="carousel-control-prev" href="#homeHeaderCarousel" role="button" data-slide="prev">
                    <span class="fa fa-arrow-circle-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#homeHeaderCarousel" role="button" data-slide="next">
                    <span class="fa fa-arrow-circle-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </header>

        <!-- Category Home Section -->
        <section id="category">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="category-list text-center">
                            <div>
                                <h2>Catégorie</h2>
                            </div>
                            <div class="row justify-content-center">
                                <?php while($raw_category=mysqli_fetch_array($category)) : ?>
                                    <div class="category col-lg-4 col-sm-6 col-xs-12">
                                        <div>
                                            <img class="category-icon img-fluid" src="img/ud-icon/<?php echo strtolower($raw_category['nom']); ?>-icon.png" alt="image icône <?php echo strtolower($raw_category['nom']); ?>">
                                        </div>
                                        <div class="jumbotron">
                                            <a href="produits.php?id_affc=<?php echo $raw_category['categorie_id']; ?>">
                                                <div>
                                                    <img class="category-img img-fluid" src="img/ud-image/<?php echo strtolower($raw_category['nom']); ?>-category.png" alt="image catégorie <?php echo strtolower($raw_category['nom']); ?>">
                                                </div>
                                                <div>
                                                    <p><strong><?php echo strtoupper($raw_category['nom']); ?></strong></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; mysqli_data_seek($category, 0);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Analytics Section -->
        <section id="analytics">
            <div class="col-md-12 text-center">
                <div class="row justify-content-center">
                    <div class="analytics-title">
                        <h2>Universal Distrib<br><b>ANALYTICS</b></h2>
                    </div>
                </div>

                <div class="row">
                    <div class="analytic col-xl-3 col-sm-6">
                        <div class="analytic-body">
                            <h3 class="stat-title">Stat 1</h3>
                            <p class="stat-text">Nombre de Clients</p>
                            <p class="stat-numb">2000</p>
                        </div>
                    </div>

                    <div class="analytic col-xl-3 col-sm-6">
                        <div class="analytic-body">
                            <h3 class="stat-title">Stat 2</h3>
                            <p class="stat-text">Produits Vendus</p>
                            <p class="stat-numb">5650</p>
                        </div>
                    </div>

                    <div class="analytic col-xl-3 col-sm-6">
                        <div class="analytic-body">
                            <h3 class="stat-title">Stat 3</h3>
                            <p class="stat-text">Utilisateurs Actifs</p>
                            <p class="stat-numb">1325</p>
                        </div>
                    </div>

                    <div class="analytic col-xl-3 col-sm-6">
                        <div class="analytic-body">
                            <h3 class="stat-title">Stat 4</h3>
                            <p class="stat-text">Nombre de Pays</p>
                            <p class="stat-numb">50</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <?php include_once "_news.php" ?>

        <!-- Footer Section -->
        <?php include_once "_footer.php"; ?>

        <!-- Scripts Section -->
        <?php include_once "_scripts.php"; ?>

    </body>

</html>