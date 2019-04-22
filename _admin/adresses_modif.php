<?php
session_start();
require_once("../_BDDconnect.php");
$a=2.3;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    // Déclaration des variables
    $id_aff=(int)verif("id_aff");
    $id_aff_bdd=bdd("id_aff");
    $modif_id=verif("modif_id");
    $modif_id_bdd=bdd("modif_id");
    $supp_id=verif("supp_id");
    $supp_id_bdd=bdd("supp_id");
    $nom=verif("nom");
    $nom_bdd=bdd("nom");
    $cp=verif("cp");
    $cp_bdd=(int)bdd("cp");
    $ville=verif("ville");
    $ville_bdd=strtoupper(bdd("ville"));
    $actif=verif("actif");
    $actif_bdd=(int)bdd("actif");
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $modifier=verif("modifier");
    $supprimer=verif("supprimer");
    $choixutilisateur=verif("choixutilisateur");
    // Requête SQL
    $adresses=mysqli_query($connect,"SELECT * FROM adresses WHERE user_id='$id_aff_bdd'");
    $req_modif="UPDATE adresses SET nom='$nom_bdd',cp='$cp_bdd',ville='$ville_bdd',actif='$actif_bdd',remarques='$remarques_bdd' WHERE user_id='$modif_id_bdd';";
    $req_supp="DELETE FROM adresses WHERE adresse_id='$supp_id_bdd';";
    // Modification dans la BDD
    if ($modifier==="Modifier") {
        // Contrôle des variables
        if(!$nom||!preg_match("#^([0-9a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,255})$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$cp||!preg_match("#^[\d]{5}$#", $_POST['cp'])) {$erreur_cp=true; $erreur=true;}
        if(!$ville||!preg_match("#^[a-zA-Z\s]{3,50}$#", $_POST['ville'])) {$erreur_ville=true; $erreur=true;}
        if(!preg_match('#^.{0,}$#', $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if (!isset($erreur)) {
            mysqli_query($connect, $req_modif);
            header ("location:adresses.php?id_aff=$id_aff");
        }
    } elseif($modifier) {
        header ("location:adresses_modif.php?id_aff=$id_aff");
    }
    // Suppression dans la BDD
    if ($supprimer==="valider"&&$choixutilisateur==="oui") {
        mysqli_query($connect, $req_supp);
        header ("location:adresses.php?id_aff=$id_aff");
        echo 'Modification appliqué !';
    }
    ?>
    <!DOCTYPE HTML>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Modification d'une adresse - BackOffice - Universal Distrib</title>
        <?php include("_metasecurise.php"); ?>
    </head>
    <body class="backoffice-body">
    <?php while ($row=mysqli_fetch_array($adresses)) : ?>
        <div class="container">
            <?php include("_ban.php"); ?>

            <header class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">BackOffice</h1>
                </div>
            </header>

            <hr>

            <section class="backoffice-section row">
                <div class="col-sm-8">
                    <h2 class="text-center">Formulaire de modification</h2>
                    <div class="tab-pane active fade in" id="contact">
                        <div class="modal" id="infos">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h3 class="modal-title">Suppression d'une adresse</h3>
                                    </div>
                                    <div class="modal-body">
                                        <blockquote class="alert-danger">Attention, en confirmant, vous effacerez définitivement l'adresse de facturation <strong><?php echo "$nom $cp $ville"; ?></strong>.</blockquote>
                                        <p class="text-center">
                                            <a href="adresses_modif.php?supp_id=<?php echo $id_aff; ?>&amp;supprimer=valider&amp;choixutilisateur=oui" class="btn btn-danger">Oui je supprime l'adresse</a>&nbsp;
                                            <a href="adresses_modif.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-primary">Non je conserve l'adresse</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="well form-horizontal" method="post" action="adresses_modif.php?id_aff=<?php echo $id_aff; ?>">
                            <div class="text-right">
                                <a data-toggle="modal" href="#infos" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
                            </div>

                            <fieldset>
                                <legend><?php echo "$nom $cp $ville"; ?></legend>

                                <?php if(isset($erreur_nom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Nom" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12">
                                            <span class="input-group-addon"><label for="nom">Adresse</label></span>
                                            <input type="text" name="nom" id="nom" class="form-control" value="<?php if(isset($_POST['nom'])) {echo $_POST['nom'];} else {echo $row["nom"];} ?>">
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
                                        <div class="input-group col-xs-12">
                                            <span class="input-group-addon"><label for="cp">Code Postal</label></span>
                                            <input type="number" name="cp" id="cp" class="form-control" value="<?php if(isset($_POST['cp'])) {echo $_POST['cp'];} else {echo $row["cp"];} ?>">
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
                                        <div class="input-group col-xs-12">
                                            <span class="input-group-addon"><label for="ville">Ville</label></span>
                                            <input type="text" name="ville" id="ville" class="form-control" value="<?php if(isset($_POST['ville'])) {echo $_POST['ville'];} else {echo $row["ville"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="actif">En activité</label></span>
                                            <input type="checkbox" name="actif" id="actif"<?php if($row["actif"]==1) {echo' checked="checked"';} ?> value="1">
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
                                        <div class="input-group col-xs-12"><span class="input-group-addon">
                                                <label for="remarques">Remarques</label></span>
                                            <textarea name="remarques" id="remarques" class="form-control"><?php if(isset($_POST['remarques'])) {echo $_POST['remarques'];} else {echo $row["remarques"];} ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="modif_id" id="modif_id" value="<?php echo $id_aff; ?>">

                                <br>

                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-<?php if(isset($auth)&&$auth==1) {echo"danger";} else {echo"primary";} ?>" type="submit" name="modifier" id="modifier" value="Modifier"><span class="glyphicon glyphicon-pencil"></span>&nbsp;modifier</button>
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
    endwhile;
    ?>
    </body>
    </html>
<?php
//début de la permission
else :
    header ("location:login.php");
endif;
?>