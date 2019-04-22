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
                $dataProduct=mysqli_fetch_array(mysqli_query($connect, "$queryProduct WHERE produit_id=$id"));
                ajouterProduit($id, $qte, $dataProduct);
                break;

            Case "delete":
                supprimerProduit($id);
                break;

            Case "refresh" :
                foreach ($_POST['qteModif'] as $i => $qteProduit) {
                    modifierQteProduit($_SESSION['panier']['idProduit'][$i], $qteProduit);
                }
                break;

            Default:
                break;
        } sauvegardePanier();
    }
}
//Identification
$id_user=$_SESSION["user_id"];
//Modif coordonnées
// Déclaration des variables
$nom=verif("nom");
$nom_bdd=bdd("nom");
$cp=verif("cp");
$cp_bdd=(int)bdd("cp");
$ville=verif("ville");
$ville_bdd=strtoupper(bdd("ville"));
$ajouter=verif("ajouter");
//REQUETE SQL
/* $req_ajout="INSERT INTO adresses VALUES(NULL,user_id='$id_user','$nom_bdd','$cp_bdd','$ville_bdd',1);"; */

// Ajout dans la BDD
 if(isset($_POST['ajouter'])) :
    // Contrôle des variables

     if(!$nom||!preg_match("#^([0-9a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,255})$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
     if(!$cp||!preg_match("#^[\d]{5}$#", $_POST['cp'])) {$erreur_cp=true; $erreur=true;}
     if(!$ville||!preg_match("#^[a-zA-Z\s]{3,50}$#", $_POST['ville'])) {$erreur_ville=true; $erreur=true;}

    // Éxecution de la requête
    if (!isset($erreur)) :

        $req_ajout="INSERT INTO adresses (adresse_id,user_id, nom, cp, ville, actif) VALUES(NULL,$id_user,'$nom_bdd','$cp_bdd','$ville_bdd',1);";
        mysqli_query($connect, $req_ajout);
        header ("Location:myAdresses.php");



    endif;
endif;
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta -->
    <?php include_once "_meta.php"; ?>

    <title>Ajouter une adresse - Universal Distrib</title>

    <!-- Stylesheet -->
    <?php include_once "_stylesheets.php"; ?>

</head>

<body>

<section class="indication">
    <div class="container">
        <ul class="nav nav-pills nav-fill text-center">
            <li class="nav-item col-auto border">
                <a class="nav-link" href="myProfil.php"><h6>Mon profil</h6></a>
            </li>
            <li class="nav-item col-auto border">
                <a class="nav-link active" href="myAdresses.php"><h6>Mes adresses</h6></a>
            </li>
            <li class="nav-item col-auto border ">
                <a class="nav-link" href="myCommandes.php"><h6>Mes commandes</h6></a>
            </li>
        </ul>
    </div>
</section>

<section class="indication">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="myAdresses.php">Mes adresses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Ajouter une adresse </a>
            </li>
        </ul>
    </div>
</section>


<div class="container">
    <!--<div class="py-5 text-center">

        <h2>Checkout form</h2>

    </div> -->

    <div class="row">

        <div class="col-md-12 order-md-1">
            <form class="needs-validation" novalidate="" method="post" action="ajoutAdresses.php">
                <div class="row">

                </div>

                <div class="mb-3">
                    <label for="nom">Adresse</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="" required="">
                    <?php if(isset($erreur_nom)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Attention, le champs "Nom" n'est pas valide.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="ville">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ville" placeholder="" required="">
                    <?php if(isset($erreur_ville)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Attention, le champs "Ville" n'est pas valide.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="cp">Code Postal <span class="text-muted"></span></label>
                    <input type="text" class="form-control" id="cp" name="cp" placeholder="">
                    <?php if(isset($erreur_cp)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Attention, le champs "Code Postal" n'est pas valide.
                        </div>
                    <?php endif; ?>
                </div>

                <button class="btn btn-primary btn-lg btn-block btn-success " type="submit" name="ajouter">Ajouter</button>
            </form>
        </div>
    </div>

</div>

<!-- Navigation Section -->
<?php include_once "_navbar.php"; ?>

<!-- Panier Section -->
<?php include_once "_modalPanier.php"; ?>

<!-- Footer Section -->
<?php include_once "_footer.php"; ?>

<!-- Scripts Section -->
<?php include_once "_scripts.php"; ?>

</body>

</html>