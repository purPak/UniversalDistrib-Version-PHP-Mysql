<?php
session_start();
require_once("../_BDDconnect.php");
$a=2.2;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    // Déclaration des variables
    $id_aff=(int)verif("id_aff");
    $id_aff_bdd=bdd("id_aff");
    $nom=verif("nom");
    $nom_bdd=bdd("nom");
    $cp=verif("cp");
    $cp_bdd=(int)bdd("cp");
    $ville=verif("ville");
    $ville_bdd=strtoupper(bdd("ville"));
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $ajouter=verif("ajouter");
    // Requête SQL
    $req_ajout="INSERT INTO adresses VALUES(NULL,'$id_aff_bdd','$nom_bdd','$cp_bdd','$ville_bdd',1,'$remarques_bdd');";
    // Ajout dans la BDD
    if ($ajouter==="Ajouter") {
        // Contrôle des variables
        if(!$nom||!preg_match("#^([0-9a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,255})$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$cp||!preg_match("#^[\d]{5}$#", $_POST['cp'])) {$erreur_cp=true; $erreur=true;}
        if(!$ville||!preg_match("#^[a-zA-Z\s]{3,50}$#", $_POST['ville'])) {$erreur_ville=true; $erreur=true;}
        if(!preg_match('#^.{0,}$#', $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if (!isset($erreur)) {
            mysqli_query($connect, $req_ajout);
            header ("Location:adresses.php?id_aff=$id_aff");
        }
    }
    ?>
    <!DOCTYPE HTML>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajout d'une adresse - BackOffice - Universal Distrib</title>
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
                    <?php if(isset($erreur_form)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Attention, le formulaire doit être complété.
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane active fade in" id="contact">
                        <form class="well form-horizontal" method="post" action="adresses_ajout.php">
                            <fieldset>
                                <legend>Adresse</legend>

                                <input type="hidden" name="id_aff" value="<?php echo $id_aff ?>">

                                <?php if(isset($erreur_nom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Nom" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="nom">Adresse</label></span>
                                            <input type="text" name="nom" id="nom" class="form-control" <?php if(isset($_POST['nom'])) {echo 'value="'.$_POST['nom'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_cp)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Code Postal" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="cp">Code Postal</label></span>
                                            <input type="number" name="cp" id="cp" class="form-control" <?php if(isset($_POST['cp'])) {echo 'value="'.$_POST['cp'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_ville)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Ville" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="ville">Ville</label></span>
                                            <input type="text" name="ville" id="ville" class="form-control" <?php if(isset($_POST['ville'])) {echo 'value="'.$_POST['ville'].'"';} ?>>
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
                                            <textarea name="remarques" id="remarques" class="form-control"><?php if(isset($_POST['remarques'])) {echo $_POST['remarques'];} ?></textarea>
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