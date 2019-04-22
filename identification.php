<?php
session_start();
require_once("_BDDconnect.php");
// Déclaration des variables
$e=0;
$id_affc=(int)verif("id_affc");
$id_affsc=(int)verif("id_affsc");
// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
// Vérification habilitation
if(isset($_SESSION["user_id"])&&isset($_SESSION["groupe_id"])) {
    $user_id=liste($_SESSION["user_id"]);
    $groupe_id=liste($_SESSION["groupe_id"]);
    $login=liste($_SESSION["email"]);
} else {
    $user_id=NULL;
    $groupe_id=NULL;
    $login=NULL;
}
if(!isset($user_id)||!isset($groupe_id)) :
?>
<!DOCTYPE html>
<html lang="fr">
    <head>

        <!-- Meta -->
        <?php include_once "_meta.php"?>

        <title>Identification - Universal Distrib</title>

        <!-- Stylesheet CSS -->
        <?php include_once "_stylesheets.php"?>

    </head>

    <body>

        <!-- Navigation Section -->
        <?php include_once "_navbar.php"?>

        <!-- Header Section -->
        <header id="identification-header">
            <div class="container">
                <h1 class="text-center">BIENVENUE</h1>
            </div>
        </header>

        <!-- Connection Section -->
        <?php include_once "_connexionUser.php" ?>

        <!-- Footer Section -->
        <?php include_once "_footer.php"?>

        <!-- JavaScripts -->
        <?php
        include_once "_scripts.php";
        mysqli_close($connect);
        ?>
    </body>
</html>
<?php
//début de la permission
else :
    header ("location:index.php");
endif;
?>
