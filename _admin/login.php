<?php
session_start();
require("../_BDDconnect.php");
$a="";
// Vérification habilitation
$auth=verif("auth");
if(isset($_SESSION["user_id"])&&isset($_SESSION["groupe_id"])) {
	$user_id=liste($_SESSION["user_id"]);
	$groupe_id=liste($_SESSION["groupe_id"]);
	$login=liste($_SESSION["email"]);
} else {
	$user_id=NULL;
	$groupe_id=NULL;
	$login=NULL;
}
if(!isset($user_id)||!isset($groupe_id)) :
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Identification - BackOffice - Universal Distrib</title>
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
                <div class="col-xs-3">&nbsp;</div>
                <div class="col-xs-6">
                    <div class="tab-pane active fade in" id="contact">
                        <form class="well form-horizontal" method="post" action="_veriflog.php">
                            <fieldset>
                            <legend>Authentification</legend>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="input-group col-xs-12"><span class="input-group-addon"><label for="login">Identifiant</label></span>
                                        <input type="text" name="login" id="login" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="input-group col-xs-12"><span class="input-group-addon"><label for="password">Mot de passe</label></span>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <button class="btn btn-<?php if(isset($auth)&&$auth==1) {echo"danger";} else {echo"primary";} ?>" type="submit" name="connection" id="connection" value="Identifier"><span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Connexion</button>
                                </div>
                            </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <div class="col-xs-3">&nbsp;</div>
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
header ("location:index.php");
endif;
?>