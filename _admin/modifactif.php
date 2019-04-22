<?php
session_start();
require_once("../_BDDconnect.php");
// Vérification habilitation
$user_id=liste($_SESSION["user_id"]);
$groupe_id=liste($_SESSION["groupe_id"]);
$login=liste($_SESSION["email"]);
if($user_id&&$groupe_id==="1") {
    $id_aff=verif("id_aff");
    $id_aff_bdd=bdd("id_aff");
    $id_etat=verif("id_etat");
    $id_etat_bdd=bdd("id_etat");
    // Gestion des différents liens actif
    $lien=array(
        "form"=>array(verif("etat_actif"),verif("adresse_actif"),verif("groupe_actif"),verif("categorie_actif"),verif("souscategorie_actif"),verif("produit_actif")),
        "base"=>array(bdd("etat_actif"),bdd("adresse_actif"),bdd("groupe_actif"),bdd("categorie_actif"),bdd("souscategorie_actif"),bdd("produit_actif")),
        "sql"=>array("users","adresses","groupes","categories","souscategories","produits"),
        "urn"=>array("utilisateurs","adresses","groupes","categories","souscategories","produits")
    );
    for($i=0;$i<=count($lien["form"])-1;$i++) {
        if($lien["base"][$i]==1) {$lien["base"][$i]=0;} else {$lien["base"][$i]=1;}
        if($lien["form"][$i]) {
            mysqli_query($connect,"UPDATE ".$lien["sql"][$i]." SET actif='".$lien["base"][$i]."' WHERE ".substr($lien["sql"][$i],0,-1)."_id='$id_etat_bdd' AND ".substr($lien["sql"][$i],0,-1)."_id<>1;");
            mysqli_close($connect);
            if($id_aff) {
                header("Location:".$lien["urn"][$i].".php?id_aff=$id_aff");
            } else {
                header("Location:".$lien["urn"][$i].".php");
            }
        }
    }
} else {header('Location:login.php');}
