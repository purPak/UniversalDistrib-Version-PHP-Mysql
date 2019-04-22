<?php
// Début de la session
session_start();


// Appel des fonctions PHP
require_once("_BDDconnect.php");
include_once("_fonctionsPanier.php");

// Création du panier
creationPanier();

// Déclaration des variables
$id_user=$_SESSION["user_id"];
$id_affc=(int)verif("id_aff");
$id_affsc=(int)verif("id_aff");

// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
$utilisateurs=mysqli_query($connect,"SELECT user_id,email,password,siret,tvaintra,tel,users.actif,users.groupe_id,users.nom,prenom,societe,groupes.nom AS groupe_nom FROM groupes INNER JOIN users ON groupes.groupe_id = users.groupe_id WHERE user_id=$id_user;");

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

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta -->
    <?php include_once "_meta.php"; ?>

    <title>Mon profil - Universal Distrib</title>

    <!-- Stylesheet -->
    <?php include_once "_stylesheets.php"; ?>

</head>

<body>

<section class="indication">
    <div class="container">
        <ul class="nav nav-pills nav-fill text-center">
            <li class="nav-item col-auto border">
                <a class="nav-link active" href="myProfil.php"><h6>Mon profil</h6></a>
            </li>
            <li class="nav-item col-auto border">
                <a class="nav-link" href="myAdresses.php"><h6>Mes adresses</h6></a>
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
                <a class="nav-link active" href="#">Mes coordonnées</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="modifCoordonees.php">Modifier mes coordonnées </a>
            </li>
        </ul>
    </div>
</section>

<div class="container">
    <div class="row">


        <div class="col-md-12">
            <div class="table-responsive">


                <table id="mytable" class="table table-bordred table-striped">

                    <thead>


                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>e-mail</th>
                    <th>Téléphone</th>
                    <th>Groupe</th>
                    <th>Société</th>
                    <th>Siret</th>
                    <th>Tvaintra</th>
                    </thead>
                    <tbody>

                    <?php while ($row=mysqli_fetch_array($utilisateurs)) : ?>
                    <tr>

                        <td><?php echo $row["nom"]; ?></td>
                        <td><?php echo $row["prenom"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["tel"]; ?></td>
                        <td><?php echo $row["groupe_nom"]; ?></td>
                        <td><?php echo $row["societe"]; ?></td>
                        <td><?php echo $row["siret"]; ?></td>
                        <td><?php echo $row["tvaintra"]; ?></td>
                        <?php endwhile; ?>
                    </tr>
                    </tbody>
                </table>
            </div>

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