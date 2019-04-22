<?php
// Début de la session
session_start();

// Appel des fonctions PHP
require_once("_BDDconnect.php");
include_once("_fonctionsPanier.php");

// Création du panier
creationPanier();

// Déclaration des variables
$id_user=$_SESSION["user_id"];
$id_affc=(int)verif("id_aff");
$id_affsc=(int)verif("id_aff");
$nom=verif("nom");
$nom_bdd=bdd("nom");
$cp=verif("cp");
$cp_bdd=(int)bdd("cp");
$ville=verif("ville");
$ville_bdd=strtoupper(bdd("ville"));
$modif_id=verif("modif_id");
$modif_id_bdd=bdd("modif_id");
$supp_id=verif("supp_id");
$supp_id_bdd=bdd("supp_id");
$modifier=verif("modifier");
$supprimer=verif("supprimer");
$formError='';

// Requêtes SQL
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
$adresses=mysqli_query($connect,"SELECT * FROM adresses WHERE user_id=$id_user;");

// Modifier dans la BDD
if(isset($_POST['modifier'])) :
    // Contrôle des variables

    if(!preg_match("#^([0-9a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,255})$#", $_POST['nom'])) {$erreur_nom=true; $erreur=true;}
    if(!preg_match("#^[\d]{5}$#", $_POST['cp'])) {$erreur_cp=true; $erreur=true;}
    if(!preg_match("#^[a-zA-Z\s]{3,50}$#", $_POST['ville'])) {$erreur_ville=true; $erreur=true;}

    $formError=1;

    // Éxecution de la requête
    if (!isset($erreur)) :

        $req_modif="UPDATE adresses SET nom='$nom_bdd',cp='$cp_bdd',ville='$ville_bdd' WHERE user_id=$id_user AND adresse_id=$modif_id_bdd;";
        mysqli_query($connect, $req_modif);
        header ("Location:myAdresses.php");

        var_dump(mysqli_query($connect, $req_modif));

    endif;

endif;

// Supprimer dans la BDD
if(isset($_POST['supprimer'])) :
    $req_supp="DELETE FROM adresses WHERE adresse_id='$supp_id_bdd';";
    mysqli_query($connect, $req_supp);
    header ("location:myAdresses.php");
    echo 'Modification appliqué !';
endif;

// Gestion des fonctions du Panier
$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null) {

    // Récuperation et vérification des variables en POST ou GET
    if (verif('id')) {
        $id = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null));
    }
    if (verif('qte')) {
        $qte = (isset($_POST['qte']) ? $_POST['qte'] : (isset($_GET['qte']) ? $_GET['qte'] : null));
    }

    // Identification de l'action effectuée
    if (in_array($action, array('add', 'delete', 'refresh'))) {
        switch ($action) {
            Case "add":
                $dataProduct=mysqli_fetch_array(mysqli_query($connect, "$queryProduct WHERE produit_id=$id"));
                ajouterProduit($id, $qte, $dataProduct);
                break;

            Case "delete":
                supprimerProduit($id);
                break;

            Case "refresh" :
                foreach ($_POST['qteModif'] as $i => $qteProduit) {
                    modifierQteProduit($_SESSION['panier']['idProduit'][$i], $qteProduit);
                }
                break;

            Default:
                break;
        } sauvegardePanier();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta -->
    <?php include_once "_meta.php"; ?>

    <title>Mes adresses - Universal Distrib</title>

    <!-- Stylesheet -->
    <?php include_once "_stylesheets.php"; ?>

</head>

<body>

<div class="container">
    <section class="indication">
        <ul class="nav nav-pills nav-fill text-center">
            <li class="nav-item col-auto border">
                <a class="nav-link" href="myProfil.php"><h6>Mon profil</h6></a>
            </li>
            <li class="nav-item col-auto border">
                <a class="nav-link active" href="myAdresses.php"><h6>Mes adresses</h6></a>
            </li>
            <li class="nav-item col-auto border ">
                <a class="nav-link" href="myCommandes.php"><h6>Mes commandes</h6></a>
            </li>
        </ul>

        <?php if($formError==1) :?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                Attention, le formulaire n'a pas été rempli correctement.
            </div>
        <?php endif; ?>
    </section>

    <section class="indication">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Mes adresses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ajoutAdresses.php">Ajouter une adresses </a>
            </li>
        </ul>
    </section>
</div>

<div class="container">
    <div class="row">


        <div class="col-md-12">
            <?php if (mysqli_num_rows($adresses)==0) : echo "Vous n'avez pas encore renseigné d'adresse";
            else: ?>
            <h4>Mes adresses de livraisons</h4>
            <div class="table-responsive">


                <table id="mytable" class="table table-bordred table-striped">

                    <thead>



                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Code Postal</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </thead>
                    <tbody>

                            <?php while ($row=mysqli_fetch_array($adresses)) : ?>
                                <tr>

                                    <td><?php echo $row["nom"]; ?></td>
                                    <td><?php echo $row["ville"]; ?></td>
                                    <td><?php echo $row["cp"]; ?></td>
                                    <td><p data-placement="top"  data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit-<?php echo $row['adresse_id']; ?>" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
                                    <td><p data-placement="top"  data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete-<?php echo $row['adresse_id']; ?>" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
                                </tr>
                            <?php endwhile; mysqli_data_seek($adresses, 0); ?>
                <?php endif;?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

    <?php while ($row=mysqli_fetch_array($adresses)) : ?>
    <div class="modal fade" id="edit-<?php echo $row['adresse_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Modifier cette adresse</h4>
                </div>
                <form role="form" method="post" action="myAdresses.php">
                    <div class="modal-body">

                            <div class="form-group">
                                <input type="hidden" name="modif_id" value="<?php echo $row['adresse_id']; ?>">
                                <input class="form-control " type="text" name="nom" placeholder="Adresse">
                                <?php if(isset($erreur_nom)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, l'adresse n'est pas valide.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">

                                <input class="form-control " type="text"  name="ville" placeholder="Ville">
                                <?php if(isset($erreur_ville)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Ville" n'est pas valide.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <textarea rows="2" class="form-control"   name="cp" placeholder="Code Postal"></textarea>
                                <?php if(isset($erreur_cp)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Attention, le champs "Code Postal" doit contenir 5 chiffres.
                                    </div>
                                <?php endif; ?>


                        </div>
                    </div>

                    <div class="modal-footer ">
                        <button type="submit" name="modifier" class="btn btn-warning btn-lg " style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Modifier</button>
                    </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <?php endwhile; mysqli_data_seek($adresses, 0); ?>


    <?php while ($row=mysqli_fetch_array($adresses)) : ?>
    <div class="modal fade" id="delete-<?php echo $row['adresse_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Voulez-vous vraiment supprimer cette adresse ?</div>

                </div>
                <div class="modal-footer">
                    <form method="post" action="myAdresses.php">
                        <input type="hidden" name="supp_id" value="<?php echo $row['adresse_id']; ?>">
                        <button type="submit" name="supprimer" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span>Oui</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Non</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <?php endwhile; mysqli_data_seek($adresses, 0); ?>


<!-- Navigation Section -->
<?php include_once "_navbar.php"; ?>

<!-- Panier Section -->
<?php include_once "_modalPanier.php"; ?>

<!-- Footer Section -->
<?php include_once "_footer.php"; ?>

<!-- Scripts Section -->
<?php include_once "_scripts.php"; ?>

</body>

</html>