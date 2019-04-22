<?php
session_start();
require_once ("_BDDconnect.php");
// Déclaration des variables
$id_affc=(int)verif("id_affc");
$id_affsc=(int)verif("id_affsc");
$email=verif("email");
$email_bdd=strtolower(bdd("email"));
$password=verif("password");
$password_bdd=md5(bdd("password").SEL);
$sexe=verif("sexe");
$sexe_bdd=bdd("sexe");
$nom=verif("nom");
$nom_bdd=bdd("nom");
$prenom=verif("prenom");
$prenom_bdd=(bdd("prenom"));
$date_naissance=verif("date_naissance");
$date_naissance_bdd=bdd("date_naissance");
$tel=verif("tel");
$tel_bdd=bdd("tel");
$adresse=verif("adresse");
$adresse_bdd=bdd("adresse");
$adressecpt=verif("adressecpt");
$adressecpt_bdd=bdd("adressecpt");
$societe=verif("societe");
$societe_bdd=strtoupper(bdd("societe"));
$cp=verif("cp");
$cp_bdd=(int)bdd("cp");
$ville=verif("ville");
$ville_bdd=strtoupper(bdd("ville"));
$pay=verif("pay");
$pay_bdd=strtoupper(bdd("pay"));
$valider=verif("valider");
// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
$groupes=mysqli_query($connect,"SELECT groupe_id,nom FROM groupes WHERE actif='1';");
$exist_email=mysqli_fetch_row(mysqli_query($connect, "SELECT email FROM users WHERE email='$email_bdd';"));
$req_ajout="INSERT INTO users VALUES(NULL,'4','$societe_bdd','client','Fr123','$adresse_bdd','$adressecpt_bdd','$cp_bdd','$ville_bdd','$pay_bdd','$tel_bdd','$sexe_bdd','$nom_bdd','$prenom_bdd','$email_bdd','$password_bdd','$date_naissance_bdd','1',NULL);";
// Ajout dans la BDD
if ($valider==="Valider") {
    // Contrôle des variables
    if(!$email||!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $_POST['email'])) {$erreur_email=true; $erreur=true;}
    if(!$password||!preg_match('#^[0-9a-zA-Z-*]{6,32}$#', $_POST['password'])) {$erreur_password=true; $erreur=true;}
    if(!$nom||!preg_match("#^[a-zA-Z-\s]{2,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
    if(!$prenom||!preg_match("#^[a-zA-Z-\s]{2,50}$#", $_POST['prenom'])) {$erreur_prenom=true; $erreur=true;}
    if(!$date_naissance||!preg_match('#^[1-2][0-9]{3}\-[0-1][0-9]\-[0-3][0-9]$#', $_POST['date_naissance'])) {$erreur_date=true; $erreur=true;}
    if(!preg_match("#^(\+[0-9]{3}[0-9]{8}|0[0-9]{9})?$#", $_POST['tel'])) {$erreur_tel=true; $erreur=true;}
    if(!$adresse||!preg_match("#^([0-9a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,255})$#", $_POST['adresse'])) {$erreur_adresse=true; $erreur=true;}
    if(!preg_match("#^([a-zA-Z-\s]{0,30})?$#", $_POST['societe'])) {$erreur_societe=true; $erreur=true;}
    if(!$cp||!preg_match("#^[\d]{5}$#", $_POST['cp'])) {$erreur_cp=true; $erreur=true;}
    if(!$ville||!preg_match("#^[a-zA-Z\s]{3,50}$#", $_POST['ville'])) {$erreur_ville=true; $erreur=true;}
    if(!is_null($exist_email)) {$erreur_email_exist=true; $erreur=true;}
    //if(!preg_match('#^.{0,}$#', $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
    // Éxecution de la requête
    if (!isset($erreur)) {
        mysqli_query($connect, $req_ajout);
        header ("location:identification.php");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>

        <!-- Meta Section -->
        <?php include_once "_meta.php"?>

        <title>Authentification - Universal Distrib</title>

        <!-- Stylesheets Section -->
        <?php include_once "_stylesheets.php"?>

    </head>

    <body>

        <!-- Navigation Section -->
        <?php include_once "_navbar.php"?>

        <!-- Header Section -->
        <header>
            <div>
                <h1 class="text-center">AUTHENTIFICATION</h1><hr>
            </div>
        </header>

        <!-- Authentification Section -->
        <?php include_once "_inscriptionUser.php" ?>

        <!-- Footer Section -->
        <?php include_once "_footer.php"?>

        <!-- Scripts Section -->
        <?php include_once "_scripts.php" ?>

    </body>
</html>