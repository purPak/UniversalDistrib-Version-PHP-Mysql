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
    $groupe=verif("groupe");
    $groupe_bdd=(int)bdd("groupe");
    $societe=verif("societe");
    $societe_bdd=strtoupper(bdd("societe"));
    $siret=verif("siret");
    $siret_bdd=bdd("siret");
    $tvaintra=verif("tvaintra");
    $tvaintra_bdd=bdd("tvaintra");
    $tel=verif("tel");
    $tel_bdd=bdd("tel");
    $nom=verif("nom");
    $nom_bdd=strtoupper(bdd("nom"));
    $prenom=verif("prenom");
    $prenom_bdd=ucfirst(bdd("prenom"));
    $email=verif("email");
    $email_bdd=bdd("email");
    $password=verif("password");
    $password_bdd=md5(bdd("password").SEL);
    if($password) {$passmodif=",password='$password_bdd'";} else {$passmodif=NULL;}
    $date_naissance=verif("date_naissance");
    $date_naissance_bdd=substr(bdd("date_naissance"),6,4)."-".substr(bdd("date_naissance"),3,2)."-".substr(bdd("date_naissance"),0,2);
    $actif=verif("actif");
    $actif_bdd=(int)bdd("actif");
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $modifier=verif("modifier");
    $supprimer=verif("supprimer");
    $choixutilisateur=verif("choixutilisateur");
    // Requête SQL
    $groupes=mysqli_query($connect,"SELECT groupe_id,nom FROM groupes WHERE actif='1';");
    $utilisateurs=mysqli_query($connect,"SELECT * FROM users WHERE user_id='$id_aff_bdd'");
    $exist_email=mysqli_fetch_row(mysqli_query($connect, "SELECT email FROM users WHERE email='$email_bdd' AND user_id!='$id_aff';"));
    $req_modif="UPDATE users SET groupe_id='$groupe_bdd',societe='$societe_bdd',tel='$tel_bdd',nom='$nom_bdd',prenom='$prenom_bdd',email='$email_bdd'$passmodif,date_naissance='$date_naissance_bdd',actif='$actif_bdd',remarques='$remarques_bdd' WHERE user_id='$modif_id_bdd';";
    $req_supp="DELETE FROM users WHERE user_id='$supp_id_bdd' AND user_id<>1;";
    // Modification dans la BDD
    if ($modifier==="Modifier") {
        // Contrôle des variables
        if(!preg_match("#^([a-zA-Z-\s]{0,30})?$#", $_POST['societe'])) {$erreur_societe=true; $erreur=true;}
        if(!preg_match("#^([\d]{14,30})?$#", $_POST['siret'])) {$erreur_siret=true; $erreur=true;}
        if(!preg_match("#^([0-9A-Z]{13})?$#", $_POST['tvaintra'])) {$erreur_tvaintra=true;}
        if(!preg_match("#^(\+[0-9]{3}[0-9]{8}|0[0-9]{9})?$#", $_POST['tel'])) {$erreur_tel=true; $erreur=true;}
        if(!$nom||!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$prenom||!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['prenom'])) {$erreur_prenom=true; $erreur=true;}
        if(!$email||!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $_POST['email'])) {$erreur_email=true; $erreur=true;}
        if(!is_null($exist_email)) {$erreur_email_exist=true; $erreur=true;}
        if(!preg_match('#^([0-9a-zA-Z-*]{6,32})?$#', $_POST['password'])) {$erreur_password=true; $erreur=true;}
        if(!$date_naissance||!preg_match('#^([0-3]{1}[0-9]{1})(/)([0-9]{2})(/)([1-2]{1}[0-9]{3})$#', $_POST['date_naissance'])) {$erreur_date=true; $erreur=true;}
        if(!preg_match('#^.{0,}$#', $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if (!isset($erreur)) {
            mysqli_query($connect, $req_modif);
            header ("location:utilisateurs.php");
        }
    } elseif($modifier) {
        header ("location:utilisateurs_modif.php?id_aff=$id_aff");
    }
    // Suppression dans la BDD
    if ($supprimer==="valider"&&$choixutilisateur==="oui") {
        mysqli_query($connect, $req_supp);
        header ("location:utilisateurs.php");
        echo 'Modification appliqué !';
    }
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Modification d'un utilisateur - BackOffice - Universal Distrib</title>
        <?php include("_metasecurise.php"); ?>
    </head>
    <body class="backoffice-body">
    <?php while ($row=mysqli_fetch_array($utilisateurs)) : ?>
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
                                        <h3 class="modal-title">Suppression d'un utilisateur</h3>
                                    </div>
                                    <div class="modal-body">
                                    <blockquote class="alert-danger">Attention, en confirmant, vous effacerez définitivement le compte <strong><?php echo $row["nom"]."&nbsp;".$row["prenom"]; ?></strong>.</blockquote>
                                    <p class="text-center"><a href="utilisateurs_modif.php?supp_id=<?php echo $id_aff; ?>&amp;supprimer=valider&amp;choixutilisateur=oui" class="btn btn-danger">Oui je supprime le compte</a>&nbsp;<a href="utilisateurs_modif.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-primary">Non je conserve le compte</a></p></div>
                                </div>
                            </div>
                        </div>

                        <form class="well form-horizontal" method="post" action="utilisateurs_modif.php?id_aff=<?php echo $id_aff; ?>">
                            <div class="text-right">
                                <a data-toggle="modal" href="#infos" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
                            </div>

                            <fieldset>
                                <legend><?php echo $row["nom"]."&nbsp;".$row["prenom"]; ?></legend>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="groupe">Groupe</label></span>
                                            <select name="groupe" id="groupe" class="form-control">
                                                <?php while ($row2=mysqli_fetch_array($groupes)) : ?>
                                                <option value="<?php echo $row2["groupe_id"]; ?>"<?php if($row["groupe_id"]===$row2["groupe_id"]) {echo' selected="selected"';} ?>><?php echo $row2["nom"]; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_societe)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Société" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="societe">Société</label></span>
                                            <input type="text" name="societe" id="societe" class="form-control" value="<?php if(isset($_POST['societe'])) {echo $_POST['societe'];} else {echo $row["societe"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_siret)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Siret" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="siret">Siret</label></span>
                                            <input type="text" name="siret" id="siret" class="form-control" value="<?php if(isset($_POST['siret'])) {echo $_POST['siret'];} else {echo $row["siret"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_tvaintra)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "TVA-intra" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="tvaintra">TVA-intra</label></span>
                                            <input type="text" name="tvaintra" id="tvaintra" class="form-control" value="<?php if(isset($_POST['tvaintra'])) {echo $_POST['tvaintra'];} else {echo $row["tvaintra"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_tel)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Téléphone" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="tel">Téléphone</label></span>
                                            <input type="tel" name="tel" id="tel" class="form-control" value="<?php if(isset($_POST['tel'])) {echo $_POST['tel'];} else {echo $row["tel"];} ?>">
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

                                <?php if(isset($erreur_prenom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Prénom" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="prenom">Prénom</label></span>
                                            <input type="text" name="prenom" id="prenom" class="form-control" value="<?php if(isset($_POST['prenom'])) {echo $_POST['prenom'];} else {echo $row["prenom"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_email)||isset($erreur_email_exist)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, <?php if(isset($erreur_email_exist)) {echo "l'email est déjà pris par un autre utilisateur.";} else {echo "le champs \"E-mail\" n\'est pas valide.";} ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="email">E-mail</label></span>
                                            <input type="email" name="email" id="email" class="form-control" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} else {echo $row["email"];} ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_password)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Mot de passe" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group col-xs-12"><span class="input-group-addon"><label for="password">Mot de passe</label></span>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <?php if(isset($erreur_date)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Date de naissance" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="input-group date col-xs-12"><span class="input-group-addon"><label for="date_naissance">Date naissance</label></span>
                                            <input type="text" name="date_naissance" id="date_naissance" class="form-control" placeholder="jj/mm/aaaa" value="<?php if(isset($_POST['date_naissance'])) {echo $_POST['date_naissance'];} else {echo substr($row["date_naissance"],8,2)."/".substr($row["date_naissance"],5,2)."/".substr($row["date_naissance"],0,4);} ?>">
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