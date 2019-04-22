<?php
session_start();
require_once("_BDDconnect.php");
require_once("_fonctionsPanier.php");
creationPanier();
// Déclaration des variables
$e=3;
$numAddress=0;
$id_affc=(int)verif("id_affc");
$id_affsc=(int)verif("id_affsc");
// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
$address=mysqli_query($connect, "SELECT * FROM adresses WHERE user_id=".$_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
    <head>

        <!-- Meta Section -->
        <?php include_once "_meta.php"?>

        <title>Adresse de livraison - Universal Distrib</title>

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
                <hr><h1 class="text-center">ADRESSE</h1><hr>
            </div>
        </header>

        <!-- Adresse Section -->
        <section class="adresse">
            <div class="container">
                <div class="row justify-content-center">
                    <form class="col-10" method="post">
                        <div class="form-group">
                            <label class="col-auto" for="selectAdresse">CHOISISSIEZ UNE ADRESSE DE LIVRAISON :</label>
                            <select id="selectAdresse" name="adresse" class="form-control col-5">
                                <option>Sélectionner une adresse de livraison</option>
                                <?php while($row_address=mysqli_fetch_array($address)) : $numAddress+=1; ?>
                                <option value="<?= $row_address['adresse_id']; ?>">Adresse de livraison - N°<?= $numAddress; ?></option>
                                <?php endwhile; mysqli_data_seek($address, 0); $numAddress=0; ?>
                            </select>
                        </div>
                        <div class="form-check-inline">
                            <input type="checkbox" class="form-check-input" id="checkAdresse">
                            <label class="form-check-label" for="checkAdresse">Utiliser la même adresse pour la facturation</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <?php while($row_address=mysqli_fetch_array($address)) : $numAddress+=1; ?>
                    <div class="adresse-save col-lg-5 col-10">
                        <h4>Adresse de livraison - N°<?= $numAddress; ?></h4><hr>
                        <p>
                            <?= $row_address['nom']; ?><br>
                            <?= $row_address['cp'].'&nbsp;'.$row_address['ville']; ?><br>
                        </p>
                        <a href="#" class="btn btn-dark">Mettre à jour&nbsp;<i class="fa fa-angle-right"></i></a>
                    </div>
                    <?php endwhile; ?>
                </div>

                <a href="#" class="btn btn-next-adresse btn-dark btn-lg offset-sm-9 offset-5">Suivant&nbsp;<i class="fa fa-angle-right"></i></a>
            </div>
        </section>

        <!-- Footer Section -->
        <?php include_once "_footer.php"?>

        <!-- JavaScript -->
        <?php include_once "_scripts.php" ?>

    </body>
</html>