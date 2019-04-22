<?php
session_start();
require_once("../_BDDconnect.php");
$a=2.1;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    $id_aff=(int)verif("id_aff");
    $id_aff_bdd=bdd("id_aff");
    $supp_id=verif("supp_id");
    $supp_id_bdd=bdd("supp_id");
    $nom = verif("nom");
    $cp = verif("cp");
    $ville = verif("ville");
    $supprimer = verif("supprimer");
    // Confirmation de la suppression
    $choixutilisateur = verif("choixutilisateur");
    // Requête de suppression
    if ($supprimer === "valider" && $choixutilisateur === "oui") {
        mysqli_query($connect, "DELETE FROM adresses WHERE adresse_id=$supp_id_bdd");
        header("Location:adresses.php?id_aff=$id_aff");
    }
    // Requêtes SQL
    $count=mysqli_query($connect,"SELECT COUNT(*) AS nb_enr FROM adresses WHERE user_id=$id_aff;");
    $adresses=mysqli_query($connect,"SELECT * FROM adresses WHERE user_id=$id_aff;");
    // Compte le nbre d'enregistrement(s)
    $unique=mysqli_fetch_array($count);
    if ($unique["nb_enr"]<=1) {$texte=NULL;} else {$texte="s";}
    // Gestion "actif"
    $coche=verif("coche");
    $actualise=verif("actualise");
    if($actualise==1) {header("location:adresses.php?id_aff=$id_aff&amp;coche=$coche");}
    ?>
 <!DOCTYPE HTML>
 <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Gestion des adresses de facturation - BackOffice - Universal Distrib</title>
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
                    <h2 class="text-center">Adresses de facturation</h2>
                    <div class="col-sm-12">
                        <?php if($supprimer=="valider") : ?>
                            <div class="modal" style="display: block; padding-top: 10%; background-color: rgba(0,0,0,0.5);">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3 class="modal-title">Suppression d'une adresse</h3>
                                        </div>
                                        <div class="modal-body">
                                            <blockquote class="alert-danger text-center">Attention, en confirmant, vous effacerez définitivement l'adresse de facturation : <strong><?php echo "$nom $cp $ville"; ?><strong></blockquote>
                                            <p class="text-center">
                                                <a href="adresses.php?id_aff=<?php echo $id_aff; ?>&amp;supp_id=<?php echo $supp_id; ?>&amp;supprimer=valider&amp;choixutilisateur=oui" class="btn btn-danger">Oui, je supprime l'adresse</a>&nbsp;
                                                <a href="adresses.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-primary">Non, je conserve l'adresse</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <table class="table table-bordered table-striped table-condensed text-center">
                            <thead>
                            <tr class="info">
                                <th colspan="6">
                                    Interface de gestion (<?php echo $unique["nb_enr"]."&nbsp;adresse".$texte; ?>)
                                    <span style="float:right;">
                                        <a data-toggle="tooltip" href="utilisateurs.php" class="btn btn-xs btn-success" title="Gérer les utilisateurs">
                                            <span class="glyphicon glyphicon-book"></span>
                                        </a>&nbsp;
                                        <a data-toggle="tooltip" href="adresses_ajout.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-xs btn-primary" title="Ajouter une adresse">
                                            <span class="glyphicon glyphicon-plus-sign"></span>
                                        </a>
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <th>Code Postal</th>
                                <th>Ville</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                                <?php if ($coche==1) {mysqli_query($connect,"UPDATE adresses SET actif='0' WHERE user_id<>1");?>
                                    <th><a href="adresses.php?id_aff=<?php echo $id_aff; ?>&amp;coche=2&amp;actualise=1">Tous</a></th>
                                <?php } elseif ($coche==2) {mysqli_query($connect,"UPDATE adresses SET actif='1'");?>
                                    <th><a href="adresses.php?id_aff=<?php echo $id_aff; ?>&amp;coche=1&amp;actualise=1">Aucun</a></th>
                                <?php } elseif ($coche<1 || $coche>2) { ?>
                                    <th><a href="adresses.php?id_aff=<?php echo $id_aff; ?>&amp;coche=1&amp;actualise=1">Actif</a></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row=mysqli_fetch_array($adresses)) :
                                if($row["actif"]==1) {$etat_actif=1;} else {$etat_actif=-1;} ?>
                                <tr<?php if($etat_actif===-1) {echo' class="danger"';} ?>>
                                    <td><?php echo $row["nom"]; ?></td>

                                    <td><?php echo $row["cp"]; ?></td>

                                    <td><?php echo $row["ville"]; ?></td>

                                    <td>
                                        <a href="adresses_modif.php?id_aff=<?php echo $id_aff; ?>" class="btn btn-primary" title="Modifier l'adresse"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>

                                    <td>
                                        <a href="adresses.php?id_aff=<?php echo $id_aff; ?>&amp;supp_id=<?php echo $row["adresse_id"]; ?>&amp;nom=<?php echo $row["nom"]; ?>&amp;cp=<?php echo $row["cp"]; ?>&amp;ville=<?php echo $row["ville"]; ?>&amp;supprimer=valider" class="btn btn-danger" title="Supprimer l'adresse"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>

                                    <td>
                                        <a href="modifactif.php?id_aff=<?php echo $id_aff; ?>&amp;id_etat=<?php echo $row["adresse_id"]; ?>&amp;adresse_actif=<?php echo $etat_actif; ?>">
                                            <img src="images/case<?php echo $row["actif"]; ?>.gif" <?php if ($row["actif"]==1) {echo 'alt="activée" title="activée"';} else {echo 'alt="désactivée" title="désactivée"';} ?> width="17" height="17" />
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
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