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
$societe_bdd=strtoupper(bdd("societe"));
$tel_bdd=bdd("tel");
$nom_bdd=strtoupper(bdd("nom"));
$prenom_bdd=ucfirst(bdd("prenom"));
$email=verif("email");
$email_bdd=bdd("email");
$groupe_bdd=(int)bdd("groupe");
$password=verif("password");
$password_bdd=md5(bdd("password").SEL);
$hashed=md5($password.SEL);
$tvaintra_bdd=bdd("tvaintra");
$siret_bdd=bdd("siret");

// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
$req_affichage=mysqli_query($connect,"SELECT * FROM users WHERE user_id=$id_user;");
$groupes=mysqli_query($connect,"SELECT groupe_id,nom FROM groupes WHERE groupe_id != 1;");
$exist_email=mysqli_fetch_row(mysqli_query($connect, "SELECT email FROM users WHERE email='$email_bdd' AND user_id!=$id_user;"));

if($password) {$passmodif=",password='$password_bdd'";} else {$passmodif=NULL;}

//Exécution de la requète si le bouton 'modifier est activé'
if(isset($_POST['modifier'])) :
    // Contrôle des variables
    if(!preg_match("#^([a-zA-Z-\s]{0,30})?$#", $_POST['societe'])) {$erreur_societe=true; $erreur=true;}
    if(!preg_match("#^([\d]{14,30})?$#", $_POST['siret'])) {$erreur_siret=true; $erreur=true;}
    if(!preg_match("#^([0-9A-Z]{13})?$#", $_POST['tvaintra'])) {$erreur_tvaintra=true;}
    if(!preg_match("#^(\+[0-9]{3}[0-9]{8}|0[0-9]{9})?$#", $_POST['tel'])) {$erreur_tel=true; $erreur=true;}
    if(!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
    if(!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['prenom'])) {$erreur_prenom=true; $erreur=true;}
    if(!$email||!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $_POST['email'])) {$erreur_email=true; $erreur=true;}
    if(!is_null($exist_email)) {$erreur_email_exist=true; $erreur=true;}
    if(!preg_match('#^([0-9a-zA-Z-*]{6,32})?$#', $_POST['password'])) {$erreur_password=true; $erreur=true;}

    if (!isset($erreur)) :
        // Requète de modification
        $req_modif="UPDATE users SET societe='$societe_bdd',groupe_id='$groupe_bdd',tvaintra='$tvaintra_bdd',siret='$siret_bdd',tel='$tel_bdd',nom='$nom_bdd',prenom='$prenom_bdd',email='$email_bdd',password='$password_bdd' WHERE user_id=$id_user;";
        mysqli_query($connect, $req_modif);
        header ("location:myProfil.php");

    endif;
endif;

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

    <title>Mofifier mes coordonnées - Universal Distrib</title>

    <!-- Stylesheet -->
    <?php include_once "_stylesheets.php"; ?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">

        <title>Checkout example for Bootstrap</title>

        <!-- Bootstrap core CSS -->
        <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="form-validation.css" rel="stylesheet">
    </head>
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
                <a class="nav-link" href="myProfil.php">Mes coordonnées</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="modifCoordonees.php">Modifier mes coordonnées </a>
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
            <form class="needs-validation" novalidate=""  method="post" action="modifCoordonees.php">
                <?php while ($row_values=mysqli_fetch_array($req_affichage)): ?>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="nom">Nom</label>

                        <input type="text" class="form-control" id="nom" name="nom" placeholder="" value="<?php echo $row_values["nom"]; ?>" required="">

                        <?php if(isset($erreur_nom)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Attention, le champs "Nom" n'est pas valide.
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom">Prenom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="" value="<?php echo $row_values["prenom"]; ?>" required="">
                        <?php if(isset($erreur_prenom)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Attention, le champs "Prénom" n'est pas valide.
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="groupe">Groupe</label>
                        <select name="groupe" id="groupe" class="form-control">
                            <?php while ($row2=mysqli_fetch_array($groupes)) : ?>
                                <option value="<?php echo $row2["groupe_id"]; ?>" <?php if($row_values["groupe_id"]===$row2["groupe_id"]) {echo' selected="selected"';} ?>><?php echo $row2["nom"]; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4 mb-3">
                            <label for="societe">Société</label>
                        <input type="text" class="form-control" id="societe" name="societe" placeholder="" value="<?php echo $row_values["societe"]; ?>" required="">
                        <?php if(isset($erreur_societe)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Attention, le champs "Société" n'est pas valide.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tvaintra">Siret</label>
                        <input type="text" class="form-control" id="siret" name="siret" placeholder="" value="<?php echo $row_values["siret"]; ?>" required="">
                        <?php if(isset($erreur_siret)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Attention, le champs "Siret" n'est pas valide.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tvaintra">TvaIntra</label>
                        <input type="text" class="form-control" id="tvaintra" name="tvaintra" placeholder="" value="<?php echo $row_values["tvaintra"]; ?>" required="">
                        <?php if(isset($erreur_tvaintra)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Attention, le champs "TVA-intra" n'est pas valide.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                    <div class="mb-3">
                        <label for="tel">Téléphone</label>

                            <div class="input-group-prepend">
                                <!--<span class="input-group-text"></span> -->
                            </div>
                            <input type="text" class="form-control" id="tel" name="tel" placeholder="" value="<?php echo $row_values["tel"]; ?>" required="">
                            <?php if(isset($erreur_tel)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    Attention, le champs "Téléphone" n'est pas valide.
                                </div>
                            <?php endif; ?>

                    </div>

                <div class="mb-3">
                    <label for="email">E-mail <span class="text-muted"></span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="prenom@exemple.com" value="<?php echo $row_values["email"]; ?>">
                    <?php if(isset($erreur_email)||isset($erreur_email_exist)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Attention, <?php if(isset($erreur_email_exist)) {echo "l'email est déjà pris par un autre utilisateur.";} else {echo "le champs \"E-mail\" n\'est pas valide.";} ?>
                        </div>
                    <?php endif; ?>
                </div>


                <div class="mb-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="" required="" value="<?php echo $row_values["password"]; ?>">
                    <?php if(isset($erreur_password)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Attention, votre mot de passe doit ètre composé d'au moins 6 caractères et contenir des lettres et des chiffres.
                        </div>
                    <?php endif; ?>
                </div>

                <br><br><br>
                <button class="btn btn-primary btn-lg btn-block btn-success " type="submit" name="modifier" >Modifier mes coordonnées</button>
                <?php endwhile; ?>
            </form>
        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<script src="../../assets/js/vendor/holder.min.js"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');

            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>



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

