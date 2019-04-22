<?php
session_start();
require_once("../_BDDconnect.php");
$a=5.2;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    $nom=verif("nom");
    $nom_bdd=ucwords(bdd("nom"));
    $icone=verif("icone");
    $icone_bdd=bdd("icone");
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $ajouter=verif("ajouter");
    // Requête SQL
    $req_ajout="INSERT INTO categories VALUES(NULL,'$nom_bdd','$icone_bdd','1','$remarques_bdd');";
    // Ajout dans la BDD
    if ($ajouter==="Ajouter") {
        // Contrôle des variables
        if(!$nom||!preg_match("#^[a-zA-Z-\s]{1,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$icone||!preg_match("#^[a-z-]{1,50}$#", $_POST['icone'])) {$erreur_icone=true; $erreur=true;}
        if(!preg_match("#^(.){0,}$#", $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if(!isset($erreur)) {
            mysqli_query($connect, $req_ajout);
            header("location:categories.php");
        }
    }
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajout d'une categorie - BackOffice - Universal Distrib</title>
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
                        <form class="well form-horizontal" method="post" action="categories_ajout.php">
                            <fieldset>
                                <legend>Categorie</legend>

                                <?php if(isset($erreur_nom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Nom" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="nom">nom</label></span>
                                            <input type="text" name="nom" id="nom" class="form-control" <?php if(isset($_POST['nom'])) {echo 'value="'.$_POST['nom'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_icone)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Icone" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="icone">icone</label></span>
                                            <input type="text" name="icone" id="icone" class="form-control" <?php if(isset($_POST['icone'])) {echo 'value="'.$_POST['icone'].'"';} ?>>
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
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="remarquess">Remarques</label></span>
                                            <input type="text" name="remarques" id="remarquess" class="form-control" <?php if(isset($_POST['remarques'])) {echo 'value="'.$_POST['remarques'].'"';} ?>>
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
        <br>
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
