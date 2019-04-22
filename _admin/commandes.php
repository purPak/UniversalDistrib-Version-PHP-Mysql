<?php
session_start();
require_once("../_BDDconnect.php");
$a=6;
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") :
    $id_aff=(int)verif("id_aff");
    $id_aff_bdd=bdd("id_aff");
    // les requêtes SQL
    $count=mysqli_query($connect,"SELECT COUNT(*) AS nb_enr FROM commandes ;");
    $commande=mysqli_query($connect,"SELECT * FROM commandes ");
    // Compte le nbre d'enregistrement(s)
    $unique=mysqli_fetch_array($count);
    if ($unique["nb_enr"]<=1) {$texte=NULL;} else {$texte="s";}
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des commmandes - BackOffice - Universal Distrib</title>
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
                    <h2 class="text-center">Commandes</h2>
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped table-condensed text-center">
                            <thead>
                            <tr class="info">
                                <th colspan="5">
                                    Interface de gestion (<?php echo $unique["nb_enr"]."&nbsp;ligne$texte&nbsp;de&nbsp;commande"; ?>)
                                </th>
                            </tr>
                            <tr>
                                <th>Numéro de commande</th>
                                <th>Id d'utilisateur</th>
                                <th>Date</th>
                                <th>Facturation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row=mysqli_fetch_array($commande)) : ?><?php //var_dump($row); ?>
                                <tr<?php ?>>
                                    <td><?php echo $row["commande_id"]; ?></td>

                                    <td><?php echo $row["user_id"]; ?></td>

                                    <td><?php echo $row["date"]; ?></td>

                                    <td>
                                        <a href="factures.php?id_aff=<?php echo $row["commande_id"]?>" data-toggle="tooltip" class="btn btn-default" title="Voir la facture"><span class="glyphicon glyphicon-list-alt"></span></a>
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