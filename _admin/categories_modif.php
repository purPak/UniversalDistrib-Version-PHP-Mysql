<?php
session_start();
require_once("../_BDDconnect.php");
$a=5.3;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    $id_aff=(int)verif("id_aff");
    $id_aff_bdd=bdd("id_aff");
    $modif_id=verif("modif_id");
    $modif_id_bdd=bdd("modif_id");
    $supp_id=verif("supp_id");
    $supp_id_bdd=bdd("supp_id");
    $nom=verif("nom");
    $nom_bdd=ucwords(bdd("nom"));
    $icone=verif("icone");
    $icone_bdd=bdd("icone");
    $actif=verif("actif");
    $actif_bdd=bdd("actif");
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $modifier=verif("modifier");
    $supprimer=verif("supprimer");
    // Confirmation de la suppression
    $choixcategorie=verif("choixcategorie");
    // Requête SQL
    $affichage=mysqli_query($connect,"SELECT * FROM categories WHERE categorie_id='$id_aff_bdd'");
    $req_modif="UPDATE categories SET nom='$nom_bdd',icone='$icone_bdd',actif='$actif_bdd',remarques='$remarques_bdd' WHERE categorie_id='$modif_id_bdd';";
    $req_supp="DELETE FROM categories WHERE categorie_id='$supp_id_bdd' AND categorie_id<>1;";
    // Modification dans la BDD
    if ($modifier==="Modifier") {
        // Contrôle des variables
        if(!$nom||!preg_match("#^[a-zA-Z-\s\d+-âàéèçû]{1,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$icone||!preg_match("#^[a-z-]{1,50}$#", $_POST['icone'])) {$erreur_icone=true; $erreur=true;}
        if(!preg_match("#^.{0,}$#", $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if(!isset($erreur)) {
            mysqli_query($connect, $req_modif);
            header("location:categories.php");
        }
    } elseif($modifier) {
        header ("location:categories_modif.php?id_aff=$id_aff");
    }
    // Suppression dans la BDD
    if ($supprimer==="valider"&&$choixcategorie==="oui") {
        mysqli_query($connect, $req_supp);
        header ("location:categories.php");
    }
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Modification d'une catégorie - BackOffice - Universal Distrib</title>
        <?php include("_metasecurise.php"); ?>
    </head>
    <body class="backoffice-body">
    <?php while ($row=mysqli_fetch_array($affichage)) : ?>
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
                    <h2 class="text-center">Formulaire de modification</h2>
                    <div class="tab-pane active fade in" id="contact">

                        <div class="modal" id="infos">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h3 class="modal-title">Suppression d'une catégorie</h3>
                                    </div>
                                    <div class="modal-body">
                                        <blockquote class="alert-danger">Attention, en confirmant, vous effacerez définitivement la catégorie <strong><?php echo $row["nom"]; ?></strong>.</blockquote>
                                        <p class="text-center">
                                            <a href="categories_modif.php?supp_id=<?php echo $id_aff; ?>&amp;supprimer=valider&amp;choixcategorie=oui" class="btn btn-danger">Oui, je supprime la catégorie</a>&nbsp;
                                            <a href="categories_modif.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-primary">Non, je conserve cette catégorie</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <form class="well form-horizontal" method="post" action="categories_modif.php?id_aff=<?php echo $id_aff; ?>">
                            <div class="text-right">
                                <a data-toggle="modal" href="#infos" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
                            </div>

                            <fieldset>
                                <legend><?php echo $row["nom"]; ?></legend>


                                <?php if(isset($erreur_nom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Nom" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="nom">Nom</label></span>
                                            <input type="text" name="nom" id="nom" class="form-control" value="<?php if(isset($_POST['nom'])) {echo $_POST['nom'];} else {echo $row["nom"];} ?>">
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
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="icone">Icone</label></span>
                                            <input type="text" name="icone" id="icone" class="form-control" value="<?php if(isset($_POST['icone'])) {echo $_POST['icone'];} else {echo $row["icone"];} ?>">
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
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="remarques">Remarques</label></span>
                                            <textarea name="remarques" id="remarques" class="form-control"><?php if(isset($_POST['remarques'])) {echo $_POST['remarques'];} else {echo $row["remarques"];} ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="modif_id" id="modif_id" value="<?php echo $id_aff; ?>">
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-<?php if(isset($auth)&&$auth==1) {echo"danger";} else {echo"primary";} ?>" type="submit" name="modifier" id="modifier" value="Modifier">
                                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;Modifier
                                        </button>
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
        endwhile;
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
