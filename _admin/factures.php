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
    $envoyer=verif("envoyer");
    // Requêtes SQL
    $count=mysqli_query($connect,"SELECT COUNT(*) AS nb_enr FROM _lignecommande WHERE commande_id=$id_aff;");
    $lignecommande=mysqli_query($connect,"SELECT * FROM _lignecommande AS l INNER JOIN produits AS p ON l.produit_id = p.produit_id INNER JOIN commandes AS c ON l.commande_id=c.commande_id WHERE l.commande_id=$id_aff;");
    $groupe_user=mysqli_query($connect,"SELECT g.nom FROM commandes AS c INNER JOIN users AS u ON c.user_id=u.user_id INNER JOIN groupes AS g ON u.groupe_id=g.groupe_id WHERE c.commande_id=$id_aff;");
    // Compte le nbre d'enregistrement(s)
    $unique=mysqli_fetch_array($count);
    if ($unique["nb_enr"]<=1) {$texte=NULL;} else {$texte="s";}
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
                    <h2 class="text-center">Facturation</h2>
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped table-condensed text-center">
                            <thead>
                            <tr class="info">
                                <th colspan="10">
                                    FACTURE N°<?php echo $id_aff; ?> (<?php echo $unique["nb_enr"]."&nbsp;ligne$texte&nbsp;de&nbsp;commande"; ?>)
                                </th>
                            </tr>
                            <tr>
                                <th>Id Commande</th>
                                <th>Date</th>
                                <th>Id Ligne de commande</th>
                                <th>Id Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                                <th>Montant TVA</th>
                                <th>Taux TVA</th>
                                <th>TTC</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $facture_array[]=array("Id Commande","Date","Id Ligne de commande","Id Produit","Prix unitaire","Quantité","Montant","Montant TVA","Taux TVA","TTC");
                                $total=0; $devise="-";
                                while ($row=mysqli_fetch_array($lignecommande)) : ?>
                                <tr>
                                    <td><?php echo $row["commande_id"]; ?></td>

                                    <td><?php echo $row["date"]; ?></td>

                                    <td><?php echo $row["lignecommande_id"]; ?></td>

                                    <td><?php echo $row["produit_id"]; ?></td>

                                    <td><?php echo $row["pu"]."&nbsp;".$row['devise'] ?></td>

                                    <td><?php echo $row["qte"]; ?></td>

                                    <?php $montant=$row["pu"] * $row["qte"]; ?>
                                    <td><?php echo $montant.$row["devise"] ?></td>

                                    <?php $tva=$row["qte"] * $row["pu"] * ($row["tva"]/100); ?>
                                    <td><?php echo $tva.$row["devise"] ?></td>

                                    <td><?php echo $row["tva"]."&nbsp;"."%"; ?></td>

                                    <?php $ttc=$montant + $tva; ?>
                                    <td><?php echo $ttc.$row["devise"] ?></td>

                                </tr>
                                <?php
                                    $total+=$ttc; $devise=$row['devise'];
                                    $facture_row=array($row["commande_id"],$row["date"],$row["lignecommande_id"],$row["produit_id"],$row["pu"],$row["qte"],$montant,$tva,$row["tva"],$ttc);
                                    $facture_array[]=$facture_row;
                                endwhile; ?>
                                <tr class="info">
                                    <td colspan="2"><strong>Montant Total</strong></td>
                                    <td class="text-right" colspan="8"><strong><?php echo $total."&nbsp;".$devise; ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <a class="btn btn-info text-right" href="factures.php?id_aff=<?php echo $id_aff; ?>&amp;envoyer=oui">
                            <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Récupérer la facture
                        </a>
                    </div>
                    <?php
                    // Crée un fichier csv de la facture
                    if(isset($facture_array)&&$envoyer==="oui") :
                        $nom_dossier=strtolower(mysqli_fetch_assoc($groupe_user)['nom']);
                        var_dump($nom_dossier);
                        $date_facture=date('dmY', strtotime($facture_array[1][1]));
                        //var_dump($facture_array["date"]);
                        $chemin="../facture";
                        if(!is_dir($chemin)){
                            mkdir($chemin);
                        }
                        $chemin.="/facture-$nom_dossier";
                        if(!is_dir($chemin)) {
                            mkdir($chemin);
                        }
                        $chemin .= "/facture-$nom_dossier-date-$date_facture-commande-$id_aff.csv";
                        $delimiteur = ';';
                        $fichier_csv = fopen($chemin, 'w+');
                        // Corrige les erreurs d'affichage dans excel
                        fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
                        foreach($facture_array as $facture_row){
                            fputcsv($fichier_csv, $facture_row, $delimiteur);
                        }
                        fclose($fichier_csv);
                    ?>
                    <div class="modal" style="display: block; padding-top: 10%; background-color: rgba(0,0,0,0.5);">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><a href="factures.php?id_aff=<?php echo $id_aff; ?>">&times;</a></button>
                                    <h3 class="modal-title">Facture envoyée !</h3>
                                </div>
                                <div class="modal-body">
                                    <blockquote class="alert-success text-center">La facture a été récupéré et envoyé avec succès</blockquote>
                                    <p class="text-center">
                                        <a href="commandes.php" class="btn btn-primary">Retourner vers la page des commandes</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
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