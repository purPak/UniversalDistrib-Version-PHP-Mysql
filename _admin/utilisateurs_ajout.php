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
    $groupe=verif("groupe");
    $groupe_bdd=(int)bdd("groupe");
    $societe=verif("societe");
    $societe_bdd=strtoupper(bdd("societe"));
    $siret=verif('siret');
    $siret_bdd=bdd("siret");
    $tvaintra=verif('tvaintra');
    $tvaintra_bdd=bdd('tvaintra');
    $tel=verif("tel");
    $tel_bdd=bdd("tel");
    $nom=verif("nom");
    $nom_bdd=strtoupper(bdd("nom"));
    $prenom=verif("prenom");
    $prenom_bdd=ucwords(bdd("prenom"));
    $email=verif("email");
    $email_bdd=strtolower(bdd("email"));
    $password=verif("password");
    $password_bdd=md5(bdd("password").SEL);
    $date_naissance=verif("date_naissance");
    $date_naissance_bdd=substr(bdd("date_naissance"),6,4)."-".substr(bdd("date_naissance"),3,2)."-".substr(bdd("date_naissance"),0,2);
    $remarques=verif("remarques");
    $remarques_bdd=bdd("remarques");
    $ajouter=verif("ajouter");
    // Requête SQL
    $groupes=mysqli_query($connect,"SELECT groupe_id,nom FROM groupes WHERE actif='1';");
    $exist_email=mysqli_fetch_row(mysqli_query($connect, "SELECT email FROM users WHERE email='$email_bdd';"));
    $req_ajout="INSERT INTO users VALUES(NULL,'$groupe_bdd','$societe_bdd','$siret_bdd','$tvaintra_bdd','$tel_bdd','$nom_bdd','$prenom_bdd','$email_bdd','$password_bdd','$date_naissance_bdd','1','$remarques_bdd');";
    // Ajout dans la BDD
    if ($ajouter==="Ajouter") {
        // Contrôle des variables
        if(!preg_match("#^([a-zA-Z-\s]{0,30})?$#", $_POST['societe'])) {$erreur_societe=true; $erreur=true;}
        if(!preg_match("#^([\d]{14,30})?$#", $_POST['siret'])) {$erreur_siret=true; $erreur=true;}
        if(!preg_match("#^([0-9A-Z]{13})?$#", $_POST['tvaintra'])) {$erreur_tvaintra=true;}
        if(!preg_match("#^(\+[0-9]{3}[0-9]{8}|0[0-9]{9})?$#", $_POST['tel'])) {$erreur_tel=true; $erreur=true;}
        if(!$nom||!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
        if(!$prenom||!preg_match("#^[a-zA-Z-\s]{3,50}$#", $_POST['prenom'])) {$erreur_prenom=true; $erreur=true;}
        if(!$email||!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $_POST['email'])) {$erreur_email=true; $erreur=true;}
        if(!is_null($exist_email)) {$erreur_email_exist=true; $erreur=true;}
        if(!$password||!preg_match('#^[0-9a-zA-Z-*]{6,32}$#', $_POST['password'])) {$erreur_password=true; $erreur=true;}
        if(!$date_naissance||!preg_match('#^([0-3]{1}[0-9]{1})(/)([0-9]{2})(/)([1-2]{1}[0-9]{3})$#', $_POST['date_naissance'])) {$erreur_date=true; $erreur=true;}
        if(!preg_match('#^.{0,}$#', $_POST['remarques'])) {$erreur_remarques=true; $erreur=true;}
        // Éxecution de la requête
        if (!isset($erreur)) {
            mysqli_query($connect, $req_ajout);
            header ("location:utilisateurs.php");
        }
    }
?>
    <!DOCTYPE HTML>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajout d'un utilisateur - BackOffice - Universal Distrib</title>
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
                    <form class="well form-horizontal" method="post" action="utilisateurs_ajout.php">
                        <fieldset>
                            <legend>Utilisateur</legend>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="input-group col-xs-12"><span class="input-group-addon"><label for="groupe">Groupe</label></span>
                                        <select name="groupe" id="groupe" class="form-control">
                                            <?php while ($row=mysqli_fetch_array($groupes)) : ?>
                                                <option value="<?php echo $row["groupe_id"]; ?>" <?php if(isset($_POST['groupe'])&&$row["groupe_id"]===$_POST['groupe']) {echo ' selected="selected"';} ?>><?php echo $row["nom"]; ?></option>
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
                                        <input type="text" name="societe" id="societe" class="form-control" <?php if(isset($_POST['societe'])) {echo 'value="'.$_POST['societe'].'"';} ?>>
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
                                        <input type="text" name="siret" id="siret" class="form-control" <?php if(isset($_POST['siret'])) {echo 'value="'.$_POST['siret'].'"';} ?>>
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
                                        <input type="text" name="tvaintra" id="tvaintra" class="form-control" <?php if(isset($_POST['tvaintra'])) {echo 'value="'.$_POST['tvaintra'].'"';} ?>>
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
                                        <input type="tel" name="tel" id="tel" class="form-control" <?php if(isset($_POST['tel'])) {echo 'value="'.$_POST['tel'].'"';} ?>>
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
                                        <input type="text" name="nom" id="nom" class="form-control" <?php if(isset($_POST['nom'])) {echo 'value="'.$_POST['nom'].'"';} ?>>
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
                                        <input type="text" name="prenom" id="prenom" class="form-control" <?php if(isset($_POST['prenom'])) {echo 'value="'.$_POST['prenom'].'"';} ?>>
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
                                        <input type="email" name="email" id="email" class="form-control" <?php if(isset($_POST['email'])) {echo 'value="'.$_POST['email'].'"';} ?>>
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
                                        <input type="password" name="password" id="password" class="form-control" <?php if(isset($_POST['password'])) {echo 'value="'.$_POST['password'].'"';} ?>>
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
                                        <input type="text" name="date_naissance" id="date_naissance" class="form-control" placeholder="jj/mm/aaaa" <?php if(isset($_POST['date_naissance'])) {echo 'value="'.$_POST['date_naissance'].'"';} ?>>
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