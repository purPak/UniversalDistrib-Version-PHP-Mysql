<?php
session_start();
require_once("../_BDDconnect.php");
$a=5.1;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    $supp_id=verif("supp_id");
    $supp_id_bdd=bdd("supp_id");
    $nom = verif("nom");
    $supprimer = verif("supprimer");
    // Confirmation de la suppression
    $choixcategorie = verif("choixcategorie");
    // Requête de suppression
    if ($supprimer === "valider" && $choixcategorie === "oui") {
        mysqli_query($connect, "DELETE FROM categories WHERE categorie_id='$supp_id_bdd'");
        header("location:categories.php");
    }
    // Les requêtes SQL
    $count=mysqli_query($connect,"SELECT COUNT(*) AS nb_enr FROM categories;");
    $categories=mysqli_query($connect,"SELECT * FROM categories");
    // Compte le nbre d'enregistrement(s)
    $unique=mysqli_fetch_array($count);
    if ($unique["nb_enr"]<=1) {$texte=NULL;} else {$texte="s";}
    // Gestion "actif"
    $coche=verif("coche");
    $actualise=verif("actualise");
    if($actualise==1) {header("Location:categories.php?coche=$coche");}
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Gestion des catégories - BackOffice - Universal Distrib</title>
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

                    <h2 class="text-center">Catégorie</h2>

                    <div class="col-sm-12">
                        <?php if($supprimer=="valider") : ?>
                            <div class="modal" style="display: block; padding-top: 10%; background-color: rgba(0,0,0,0.5);">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><a href="categories.php">&times;</a></button>
                                            <h3 class="modal-title">Suppression d'une catégorie</h3>
                                        </div>
                                        <div class="modal-body">
                                            <blockquote class="alert-danger text-center">Attention, en confirmant, vous effacerez définitivement la catégorie: <strong><?php echo $nom; ?></strong></blockquote>
                                            <p class="text-center">
                                                <a href="categories.php?supp_id=<?php echo $supp_id; ?>&amp;supprimer=valider&amp;choixcategorie=oui" class="btn btn-danger">Oui, je supprime la catégorie</a>&nbsp;
                                                <a href="categories.php" class="btn btn-primary">Non, je conserve cette catégorie</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <table class="table table-bordered table-striped table-condensed text-center">
                            <thead>
                                <tr class="info">
                                    <th colspan="5">
                                        Interface de gestion (<?php echo $unique["nb_enr"]."&nbsp;catégorie$texte"; ?>)
                                        <span style="float:right;">
                                            <a data-toggle="tooltip" href="categories_ajout.php" class="btn btn-xs btn-primary" title="Ajouter un catégorie">
                                                <span class="glyphicon glyphicon-plus-sign"></span>
                                            </a>
                                        </span>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Nom</th>
                                    <th>Remarque</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>

                                    <?php if ($coche==1) {mysqli_query($connect,"UPDATE categories SET actif='0' WHERE categorie_id<>1");?>
                                        <th><a href="categories.php?coche=2&amp;actualise=1">Tous</a></th>
                                    <?php } elseif ($coche==2) {mysqli_query($connect,"UPDATE categories SET actif='1'");?>
                                        <th><a href="categories.php?coche=1&amp;actualise=1">Aucun</a></th>
                                    <?php } elseif ($coche<1 || $coche>2) { ?>
                                        <th><a href="categories.php?coche=1&amp;actualise=1">Actif</a></th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                            <?php while ($row=mysqli_fetch_array($categories)) :
                                if($row["actif"]==1) {$etat_actif=1;} else {$etat_actif=-1;} ?>

                                <tr<?php if($etat_actif===-1) {echo' class="danger"';} ?>>
                                    <td><?php echo $row["nom"]; ?></td>

                                    <td><?php echo $row["remarques"]; ?></td>

                                    <td>
                                        <a href="categories_modif.php?id_aff=<?php echo $row["categorie_id"]; ?>" class="btn btn-primary" title="Modifier la catégorie"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>

                                    <td>
                                        <a href="categories.php?supp_id=<?php echo $row["categorie_id"]; ?>&amp;nom=<?php echo $row["nom"]; ?>&amp;supprimer=valider" class="btn btn-danger" title="Supprimer la catégorie"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>

                                    <td>
                                        <a href="modifactif.php?id_etat=<?php echo $row['categorie_id']; ?>&amp;categorie_actif=<?php echo $etat_actif; ?>">
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
