<?php
session_start();
require_once("../_BDDconnect.php");
$a=1;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Accueil - BackOffice - Universal Distrib</title>
        <?php include("_metasecurise.php"); ?>
    </head>
    <body class="backoffice-body">
        <div class="container">
            <?php include("_ban.php"); ?>

            <header class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">BackOffice</h1>
                </div>
            </header>

            <hr>

            <section class="row">
                <div class="col-sm-8">
                    <h2>Présentation</h2>
                    <p>
                        Cette page permet une prise en main rapide de l'administration du site aussi communément nommé BackOffice.<br>
                        Il sera géré par des utilisateurs spécifiques, à savoir les personnes qui disposent de droits définis par l'administrateur.
                    </p>
                    <br>
                    <blockquote>
                        Le BackOffice permettra de <abbr title="Lister, Ajouter, Modifier ou Supprimer">gérer</abbr> les éléments suivants :
                        <ul>
                            <li>les <a data-toggle="tooltip" href="utilisateurs.php" title="Gérer maintenant">utilisateurs</a>,</li>
                            <li>les <a data-toggle="tooltip" href="groupes.php" title="Gérer maintenant">groupes</a>,</li>
                            <li>les <a data-toggle="tooltip" href="produits.php" title="Gérer maintenant">produits</a>,</li>
                            <li>les <a data-toggle="tooltip" href="categories.php" title="Gérer maintenant">catégories</a>,</li>
                            <li>les <a data-toggle="tooltip" href="souscategories.php" title="Gérer maintenant">sous-catégories</a>.</li>
                        </ul>
                        Ainsi que de consulter les <a data-toggle="tooltip" href="commandes.php" title="Consulter maintenant">commandes</a> et les factures liées à celles-ci.<br>
                        <small class="pull-right">Admin</small><br>
                    </blockquote>
                </div>

                <?php include("_session.php"); ?>
            </section>
        </div><!-- container -->
        <?php
        include("_scripts.php");
        mysqli_close($connect);
        ?>
    </body>
</html>
<?php
//début de la permission
else :
header ("location:login.php");
endif;
?>