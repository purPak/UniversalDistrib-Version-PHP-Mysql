<?php
// Verifie si le panier existe, le créé sinon

function creationPanier(){
    if (!isset($_SESSION['panier'])){

        // Création du panier vide
        $_SESSION['panier']=array();
        $_SESSION['panier']['idProduit'] = array();
        $_SESSION['panier']['nomProduit'] = array();
        $_SESSION['panier']['catProduit'] = array();
        $_SESSION['panier']['subcatProduit'] = array();
        $_SESSION['panier']['prixProduit'] = array();
        $_SESSION['panier']['deviseProduit'] = array();
        $_SESSION['panier']['qteProduit'] = array();
        $_SESSION['panier']['imageProduit'] = array();
        $_SESSION['panier']['verrou'] = false;

        // Remplie le panier si un cookie existe
        if (isset($_COOKIE['panierListId']) && isset($_COOKIE['panierListId'])) {
            $listIdProduit = explode('-', $_COOKIE['panierListId']);
            $listQteProduit = explode('-', $_COOKIE['panierListQte']);
            foreach ($listIdProduit as $idProduit) {
                $qte = 1;
                $connect = mysqli_connect("localhost", "root", "", "ud");
                mysqli_query($connect,"SET NAMES 'utf8'");
                $queryProduit = "SELECT produit_id, p.nom AS nom_produit, c.categorie_id AS categorie_id, c.nom AS nom_categorie, sc.souscategorie_id AS souscategorie_id, sc.nom AS nom_souscategorie, pu, tva, devise, majeur, description, p.image AS image_produit FROM produits AS p INNER JOIN souscategories AS sc ON p.souscategorie_id=sc.souscategorie_id INNER JOIN categories AS c ON sc.categorie_id=c.categorie_id WHERE produit_id=$idProduit;";
                $dataProduit = mysqli_fetch_array(mysqli_query($connect, $queryProduit));
                ajouterProduit($idProduit, $qte, $dataProduit);
            }
            foreach ($listQteProduit as $i => $qteProduit) {
                modifierQteProduit($_SESSION['panier']['idProduit'][$i], $qteProduit);
            }
        }
    }
    return true;
}

// Sauvegarde le panier de l'utilisateur dans un COOKIE

function sauvegardePanier(){
    $listIdProduit = implode('-',$_SESSION['panier']['idProduit']);
    $listQteProduit = implode('-',$_SESSION['panier']['qteProduit']);
    setcookie('panierListId', $listIdProduit, time() + 182 * 24 * 3600, null, null, false, true);
    setcookie('panierListQte', $listQteProduit, time() + 182 * 24 * 3600, null, null, false, true);
}


// Ajoute un article dans le panier

function ajouterProduit($idProduit,$qteProduit, $arrayProduct){

    // Si le panier existe
    if (creationPanier() && !isLocked())
    {
        // Si le produit existe déjà on ajoute seulement la quantité
        $positionProduit = array_search($idProduit,  $_SESSION['panier']['idProduit']);

        if ($positionProduit !== false) {
            $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
        } else {
            // Sinon on ajoute le produit
            array_push( $_SESSION['panier']['idProduit'],intval($idProduit));
            array_push( $_SESSION['panier']['nomProduit'],$arrayProduct['nom_produit']);
            array_push( $_SESSION['panier']['catProduit'],$arrayProduct['nom_categorie']);
            array_push( $_SESSION['panier']['subcatProduit'],$arrayProduct['nom_souscategorie']);
            array_push( $_SESSION['panier']['prixProduit'],$arrayProduct['pu']);
            array_push( $_SESSION['panier']['deviseProduit'],$arrayProduct['devise']);
            array_push( $_SESSION['panier']['qteProduit'],intval($qteProduit));
            array_push( $_SESSION['panier']['imageProduit'],$arrayProduct['image_produit']);
        }
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


// Modifie la quantité d'un article

function modifierQteProduit($idProduit,$qteProduit){
    // Si le panier existe
    if (creationPanier() && !isLocked())
    {
        // Si la quantité est positive on modifie sinon on supprime l'article
        if ($qteProduit > 0)
        {
            // Recherche du produit dans le panier
            $positionProduit = array_search($idProduit,  $_SESSION['panier']['idProduit']);

            if ($positionProduit !== false)
            {
                $_SESSION['panier']['qteProduit'][$positionProduit] = intval($qteProduit) ;
            }
        } else {
            supprimerProduit($idProduit);
        }
    }
    else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


// Supprime un article du panier

function supprimerProduit($idProduit){
    // Si le panier existe
    if (creationPanier() && !isLocked())
    {
        // Nous allons passer par un panier temporaire
        $tmp=array();
        $tmp['idProduit'] = array();
        $tmp['nomProduit'] = array();
        $tmp['catProduit'] = array();
        $tmp['subcatProduit'] = array();
        $tmp['prixProduit'] = array();
        $tmp['deviseProduit'] = array();
        $tmp['qteProduit'] = array();
        $tmp['imageProduit'] = array();
        $tmp['verrou'] = $_SESSION['panier']['verrou'];

        for($i = 0; $i < count($_SESSION['panier']['idProduit']); $i++)
        {
            if ($_SESSION['panier']['idProduit'][$i] != $idProduit)
            {
                array_push( $tmp['idProduit'],$_SESSION['panier']['idProduit'][$i]);
                array_push( $tmp['nomProduit'],$_SESSION['panier']['nomProduit'][$i]);
                array_push( $tmp['catProduit'],$_SESSION['panier']['catProduit'][$i]);
                array_push( $tmp['subcatProduit'],$_SESSION['panier']['subcatProduit'][$i]);
                array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
                array_push( $tmp['deviseProduit'],$_SESSION['panier']['deviseProduit'][$i]);
                array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
                array_push( $tmp['imageProduit'],$_SESSION['panier']['imageProduit'][$i]);
            }

        }
        // On remplace le panier en session par notre panier temporaire à jour
        $_SESSION['panier'] =  $tmp;
        // On efface notre panier temporaire
        unset($tmp);
    }
    else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


// Montant total du panier

function MontantTotal(){
    $total=0;
    for($i = 0; $i < count($_SESSION['panier']['idProduit']); $i++)
    {
        $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
    }
    return $total;
}


// Fonction de suppression du panier

function supprimePanier(){
    unset($_SESSION['panier']);
}


// Permet de savoir si le panier est verrouillé

function isLocked(){
    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
        return true;
    else
        return false;
}


// Compte le nombre d'articles différents dans le panier

function compterProduits(){
    if (isset($_SESSION['panier']))
        return count($_SESSION['panier']['idProduit']);
    else
        return 0;
}