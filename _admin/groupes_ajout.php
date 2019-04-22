<?php
session_start();
require_once("../_BDDconnect.php");
$a=3.2;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    // Déclaration des variables
    $nom=verif("nom");
    $nom_bdd=ucwords(bdd("nom"));
    $type=verif("type");
    $type_bdd=bdd("type");
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $ajouter=verif("ajouter");
    // Requête SQL
    $req_ajout="INSERT INTO groupes VALUES(NULL,'$nom_bdd','$type_bdd','1','$remarques_bdd');";
    // Ajout dans la BDD
    if ($ajouter==="Ajouter") {
        // Contrôle des variables
        if (!$nom||!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if (!preg_match('#^.{0,}$#', $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if (!isset($erreur)) {
            mysqli_query($connect, $req_ajout);
            header("location:groupes.php");
        }
    }
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajout d'un groupe - BackOffice - Universal Distrib</title>
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
                    <h2 class="text-center">Formulaire d'ajout</h2>
                    <div class="tab-pane active fade in" id="contact">
                        <form class="well form-horizontal" method="post" action="groupes_ajout.php">
                            <fieldset>
                                <legend>Groupe</legend>

                                <?php if(isset($erreur_nom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Nom" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="nom">Nom</label></span>
                                            <input type="text" name="nom" id="nom" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="type">Statut</label></span>
                                            <select name="type" id="type" class="form-control">
                                                <option value="admin">Administrateur</option>
                                                <option value="client">Client</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_remarques)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Remarques" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="remarques">Remarques</label></span>
                                            <textarea name="remarques" id="remarques" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-primary" type="submit" name="ajouter" id="ajouter" value="Ajouter"><span class="glyphicon glyphicon-plus"></span>&nbsp;Ajouter</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
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
