<?php
session_start();
require_once("../_BDDconnect.php");
$a=4.3;
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
    $souscategorie=verif("souscategorie");
    $souscategorie_bdd=(int)bdd("souscategorie");
    $nom=verif("nom");
    $nom_bdd=ucfirst(bdd("nom"));
    $pu=verif("pu");
    $pu_bdd=(float)bdd("pu");
    $tva=verif("tva");
    $tva_bdd=(float)bdd("tva");
    $devise=verif("devise");
    $devise_bdd=bdd("devise");
    $majeur=verif("majeur");
    $majeur_bdd=(int)bdd("majeur");
    $description=verif("description");
    $description_bdd=bdd("description");
    $image=verif("image");
    $image_bdd=strtolower(bdd("image"));
    $actif=verif("actif");
    $actif_bdd=(int)bdd("actif");
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $modifier=verif("modifier");
    $supprimer=verif("supprimer");
    // Confirmation de la suppression
    $choixproduit=verif("choixproduit");
    // Requête SQL
    $affichage=mysqli_query($connect,"SELECT * FROM produits WHERE produit_id='$id_aff_bdd';");
    $souscategories=mysqli_query($connect,"SELECT souscategorie_id,nom FROM souscategories WHERE actif='1';");
    $req_modif="UPDATE produits SET souscategorie_id='$souscategorie_bdd',nom='$nom_bdd',pu='$pu_bdd',tva='$tva_bdd',devise='$devise_bdd',majeur='$majeur_bdd',description='$description_bdd',image='$image_bdd',actif='$actif_bdd',remarques='$remarques_bdd' WHERE produit_id='$modif_id_bdd';";
    $req_supp="DELETE FROM produits WHERE produit_id='$supp_id_bdd' AND produit_id<>1;";
    // Modification dans la BDD
    if ($modifier==="Modifier") {
        // Contrôle des variables
        if(!$nom||!preg_match("#^[a-zA-Z-\s\d+-âàéèçû]{1,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$pu||!preg_match("#^[0-9]{1,10}(\.{1}[0-9]{1,2})?$#", $_POST['pu'])) {$erreur_pu=true; $erreur=true;}
        if(!$tva||!preg_match("#^[0-9]{1,10}(\.{1}[0-9]{1,2})?$#", $_POST['tva'])) {$erreur_tva=true; $erreur=true;}
        if(!$majeur||!preg_match("#^[0-9]{1,2}$#", $_POST['majeur'])) {$erreur_majeur=true; $erreur=true;}
        if(!$description||!preg_match("#^.{1,}$#", $_POST['description'])) {$erreur_description=true; $erreur=true;}
        if(!preg_match("#^.{0,}$#", $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if(!isset($erreur)){
            mysqli_query($connect, $req_modif);
            header ("location:produits.php");
        }
    } elseif($modifier) {
        header ("location:produits_modif.php?id_aff=$id_aff");
    }
    // Suppression dans la BDD
    if ($supprimer==="valider"&&$choixproduit==="oui") {
        mysqli_query($connect, $req_supp);
        header ("location:produits.php");
    }
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Modification d'un produit - BackOffice - Universal Distrib</title>
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
                                        <h3 class="modal-title">Suppression d'un produit</h3>
                                    </div>
                                    <div class="modal-body">
                                        <blockquote class="alert-danger">Attention, en confirmant, vous effacerez définitivement le produit <strong><?php echo $row["nom"]; ?></strong>.</blockquote>
                                        <p class="text-center">
                                            <a href="produits_modif.php?supp_id=<?php echo $id_aff; ?>&amp;supprimer=valider&amp;choixproduit=oui" class="btn btn-danger">Oui je supprime le produit</a>&nbsp
                                            <a href="produits_modif.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-primary">Non je conserve le produit</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="well form-horizontal" method="post" action="produits_modif.php?id_aff=<?php echo $id_aff; ?>">
                            <div class="text-right">
                                <a data-toggle="modal" href="#infos" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
                            </div>

                            <fieldset>
                                <legend><?php echo $row["nom"]; ?></legend>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="souscategorie">Sous-Catégorie</label></span>
                                            <select name="souscategorie" id="souscategorie" class="form-control">
                                                <?php while ($row2=mysqli_fetch_array($souscategories)) : ?>
                                                    <option value="<?php echo $row2["souscategorie_id"]; ?>"<?php if($row["souscategorie_id"]===$row2["souscategorie_id"]) {echo' selected="selected"';} ?>><?php echo $row2["nom"]; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

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

                                <?php if(isset($erreur_pu)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Prix" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="pu">Prix Unitaire</label></span>
                                            <input type="text" name="pu" id="pu" class="form-control" value="<?php if(isset($_POST['pu'])) {echo $_POST['pu'];} else {echo $row["pu"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_tva)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "TVA" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="tva">TVA (en %)</label></span>
                                            <input type="text" name="tva" id="tva" class="form-control" value="<?php if(isset($_POST['tva'])) {echo $_POST['tva'];} else {echo $row["tva"];}  ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="devise">Devise</label></span>
                                            <select name="devise" id="devise" class="form-control">
                                                <option value="€"<?php if($row["devise"]==="€") {echo' selected="selected"';} ?>>Euro</option>
                                                <option value="$"<?php if($row["devise"]==="$") {echo' selected="selected"';} ?>>Dollar</option>
                                                <option value="£"<?php if($row["devise"]==="£") {echo' selected="selected"';} ?>>Livre</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_majeur)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Majeur" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="majeur">Majeur</label></span>
                                            <input type="number" name="majeur" id="majeur" class="form-control" value="<?php  if(isset($_POST['majeur'])) {echo $_POST['majeur'];} else {echo $row["majeur"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_description)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Description" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="description">Description</label></span>
                                            <input type="text" name="description" id="description" class="form-control" value="<?php if(isset($_POST['description'])) {echo $_POST['description'];} else {echo $row["description"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="image">Image</label></span>
                                            <input type="file" name="image" id="image" class="form-control" value="<?php echo $row["image"]; ?>">
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
                                            <textarea name="remarques" id="remarques" class="form-control"><?php  if(isset($_POST['remarques'])) {echo $_POST['remarques'];} else {echo $row["remarques"];}  ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="modif_id" id="modif_id" value="<?php echo $id_aff; ?>">
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
        <br>
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