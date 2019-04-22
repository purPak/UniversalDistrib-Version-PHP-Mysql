<?php
session_start();
require_once("../_BDDconnect.php");
$a=4.2;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    $souscategorie=verif("categorie");
    $souscategorie_bdd=(int)bdd("categorie");
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
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $ajouter=verif("ajouter");
    // Requête SQL
    $souscategories=mysqli_query($connect,"SELECT souscategorie_id,nom FROM souscategories WHERE actif='1';");
    $req_ajout="INSERT INTO produits VALUES(NULL,'$souscategorie_bdd','$nom_bdd','$pu_bdd','$tva_bdd','$devise_bdd','$majeur_bdd','$description_bdd','$image_bdd','1','$remarques_bdd');";
    // Ajout dans la  BDD
    if($ajouter==="Ajouter" ) {
        // Contrôle des variables
        if(!$nom||!preg_match("#^[a-zA-Z-\s\d+-âàéèçû]{1,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$pu||!preg_match("#^[0-9]{1,10}(\.{1}[0-9]{1,2})?$#", $_POST['pu'])) {$erreur_pu=true; $erreur=true;}
        if(!$tva||!preg_match("#^[0-9]{1,10}(\.{1}[0-9]{1,2})?$#", $_POST['tva'])) {$erreur_tva=true; $erreur=true;}
        if(!$majeur||!preg_match("#^[0-9]{1,2}$#", $_POST['majeur'])) {$erreur_majeur=true; $erreur=true;}
        if(!$description||!preg_match("#^.{1,}$#", $_POST['description'])) {$erreur_description=true; $erreur=true;}
        if(!preg_match("#^.{0,}$#", $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if (!isset($erreur)) {
            mysqli_query($connect, $req_ajout);
            header ("location:produits.php");
        }
    }
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajout d'un produit - BackOffice - Universal Distrib</title>
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
                        <form class="well form-horizontal" method="post" action="produits_ajout.php">
                            <fieldset>
                                <legend>Utilisateur</legend>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="souscategorie">Sous-catégorie</label></span>
                                            <select name="souscategorie" id="souscategorie" class="form-control">
                                                <?php while ($row=mysqli_fetch_array($souscategories)) : ?>
                                                    <option value="<?php echo $row["souscategorie_id"]; ?>"><?php echo $row["nom"]; ?></option>
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
                                            <input type="text" name="nom" id="nom" class="form-control"<?php if(isset($_POST['nom'])) {echo 'value="'.$_POST['nom'].'"';} ?>>
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
                                            <input type="text" name="pu" id="pu" class="form-control"<?php if(isset($_POST['pu'])) {echo 'value="'.$_POST['pu'].'"';} ?>>
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
                                            <input type="text" name="tva" id="tva" class="form-control"<?php if(isset($_POST['tva'])) {echo 'value="'.$_POST['tva'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="devise">Devise</label></span>
                                            <select name="devise" id="devise" class="form-control">
                                                <option value="€">Euro</option>
                                                <option value="$">Dollar</option>
                                                <option value="£">Livre</option>
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
                                            <input type="number" name="majeur" id="majeur" class="form-control"<?php if(isset($_POST['majeur'])) {echo 'value="'.$_POST['majeur'].'"';} ?>>
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
                                            <input type="text" name="description" id="description" class="form-control"<?php if(isset($_POST['description'])) {echo 'value="'.$_POST['description'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="image">Image</label></span>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_remarques)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Remarque" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="remarques">Remarques</label></span>
                                            <textarea name="remarques" id="remarques" class="form-control" <?php if(isset($_POST['remarques'])) {echo 'value="'.$_POST['remarques'].'"';} ?>></textarea>
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
endif
?>
