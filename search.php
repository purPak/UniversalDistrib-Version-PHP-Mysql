<?php
session_start();
require_once("_BDDconnect.php");
require_once("_fonctionsPanier.php");
$id_affc=(int)verif("id_affc");
$id_affsc=(int)verif("id_affsc");
// Requêtes SQL
$connect=mysqli_connect("localhost","root","","ud"); // Connexion à MySQL
mysqli_query($connect,"SET NAMES 'utf8'");
$category=mysqli_query($connect,"SELECT * FROM categories;");
$subcategory=mysqli_query($connect,"SELECT * FROM souscategories;");
$queryProduct="SELECT produit_id, p.nom AS nom_produit, c.categorie_id AS categorie_id, c.nom AS nom_categorie, sc.souscategorie_id AS souscategorie_id, sc.nom AS nom_souscategorie, pu, tva, devise, majeur, description, p.image AS image_produit FROM produits AS p INNER JOIN souscategories AS sc ON p.souscategorie_id=sc.souscategorie_id INNER JOIN categories AS c ON sc.categorie_id=c.categorie_id ";
if($id_affc){$queryProduct.="WHERE c.categorie_id=$id_affc";}
if($id_affsc){$queryProduct.="WHERE c.categorie_id=$id_affsc";}

$where = '';
$search='';
if(isset($_POST['submit']) AND isset($_POST['search']))
{
    $search= mysqli_real_escape_string($connect, htmlspecialchars(trim($_POST['search'])));
}

$search = preg_split('/[ \s \-]/',$search);
$count_keywords=count($search);
foreach($search as $key=>$searches)
{
    $where .= "nom LIKE '%$searches%'";
    if($key !=($count_keywords-1))
    {
        $where .= " AND ";
    }
}


$product = mysqli_query($connect,"$queryProduct WHERE p.$where");

$rows= mysqli_num_rows($product);

/*******************************/
/*       Pagination            */
/*******************************/

//Nombre de resultats par page
$produitParPage=8;

//nombre total de page
$nombreTotalDePages = ceil($rows/$produitParPage);

//detremination de la page actuellement visitées
if(!isset($_GET['page']))
{
    $page=1;
} else {
    $page = $_GET['page'];
}

//determination de la limite dans la requète SQL
 $this_page_first_result = ($page-1)*$produitParPage;

//Reconnexion à la BDD
$product = mysqli_query($connect,"$queryProduct WHERE p.$where LIMIT  $this_page_first_result  ,  $produitParPage");

$pageSuivante = $page+1;
$pagePrecedente = $page-1;

/*Test Liens vers les pages
for($page=1;$page<=$nombreTotalDePages;$page++)
{
    echo '<br>'.'<br>'.'<br>'.'<a href="search.php?page='.$page.'">'.$page.'</a>';
}
*/
 ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Meta -->
        <?php include_once "_meta.php"?>

        <title>Produits - Universal Distrib</title>

        <!-- Stlylesheet CSS -->
        <?php include_once "_stylesheets.php"?>
    </head>

    <body>

    <!-- Navigation Section -->
    <?php include_once "_navbar.php"?>

    <header id="product-header">
        <div class="product-search">
            <form class="form-inline justify-content-center" method="post" action="search.php">
                <input class="form-control" name ="search" type="search" placeholder="Rechercher un produit..." aria-label="ProductSearch">
                <button class="btn btn-secondary" name ="submit" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </header>

    <!-- Produit Section -->
    <?php if($rows) : ?>
        <section id="product">

            <div class="col-12 text-center">
                <div class="product-title">
                     <h2>Produits (<?php echo $rows ?>)</h2>
                </div>

                <div class="product-list row">
                    <?php while($row_product=mysqli_fetch_array($product)) :
                        $position=0;
                        $nbElement=count($_SESSION['panier']['idProduit']);
                        while ($position<$nbElement) :
                            if ($row_product['produit_id']==$_SESSION['panier']['idProduit'][$position]) {
                                $positionProductInCart = $position;
                            } $position+=1;
                        endwhile;
                        ?>
                        <div class="product-item col-xl-3 col-lg-4 col-6">
                            <div class="product-header jumbotron">
                                <?php if (!isset($positionProductInCart)) : ?><?php endif; ?>
                                <div class="counter-img"></div>
                                <div class="counter js-counter">
                                    <div class="counter-item">
                                        <a class="counter-minus js-counter-btn" data-action="minus">
                                            <i class="fa fa-minus js-counter-btn" data-action="minus"></i>
                                        </a>
                                    </div>
                                    <div class="counter-item counter-item-center">
                                        <form method="post">
                                            <input class="counter-value js-counter-value" title="Quantité" name="<?php if (isset($positionProductInCart)) echo "qteModif[$positionProductInCart]"; else echo 'qte'; ?>" type="text" min="0" max="9" value="<?php if (isset($positionProductInCart)) echo $_SESSION['panier']['qteProduit'][$positionProductInCart]; else echo '0'; ?>" tabindex="-1"/>
                                            <button class="counter-valid btn" type="submit" name="action" value="<?php if (isset($positionProductInCart)) echo 'refresh'; else echo 'add'; ?>">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <?php if (!isset($positionProductInCart)) : ?><input type="hidden" name="id" value="<?php echo $row_product['produit_id']; ?>"><?php endif; $positionProductInCart = NULL; ?>
                                        </form>
                                    </div>
                                    <div class="counter-item">
                                        <a class="counter-plus js-counter-btn" data-action="plus">
                                            <i class="fa fa-plus js-counter-btn" data-action="plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-body jumbotron">
                                <div class="product-content">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div>
                                                <a class="portfolio-link" data-toggle="modal" href="#ud-product-<?= $row_product['produit_id']; ?>">
                                                    <h3><?= $row_product['nom_produit']; ?></h3>
                                                </a>
                                                <h4><?= $row_product['pu']; ?>&nbsp;<?= $row_product['devise']; ?></h4>
                                                <p><?= $row_product['description']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div>
                                                <img class="img-fluid" src="img/ud-produit/<?= $row_product['image_produit']; ?>" alt="Image Che">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; mysqli_data_seek($product, 0); ?>
                </div>

                <nav class="product-pager">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagePrecedente <= $nombreTotalDePages AND $pagePrecedente !=0) : ?>
                            <li class="page-item">
                                <a class="page-link" href="search.php?page=<?php echo $pagePrecedente?>">Précédent</a>
                            </li>
                        <?php endif ?>
                        <?php for($i=1;$i<=$nombreTotalDePages;$i++) :?>
                        <li class="page-item">
                            <a class="page-link <?php if($i==$page) echo "pageActuelle"; ?>" href="search.php?page=<?php echo $i?>"><?php echo $i ?></a>
                        </li>
                        <?php endfor ?>
                        <?php if ($pageSuivante == $nombreTotalDePages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="search.php?page=<?php echo $pageSuivante?>">Suivant</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </nav>
            </div>
        </section>
    <?php else : ?>
        <section id="product">
            <div class="col-12 text-center">
            <div class="product-title">
                <h2>Aucun produits ne correspond à votre recherche</h2>
            </div>
        </section>
    <?php endif; ?>

        <!-- Footer Section -->
        <?php include_once "_footer.php"?>

        <!-- Panier Section -->
        <?php include_once "_modalPanier.php"; ?>

        <!-- Products Modals -->
        <?php include_once "_modalProduits.php" ?>

        <!-- Javascript Section -->
        <?php include_once "_scripts.php" ?>

    </body>
</html>
