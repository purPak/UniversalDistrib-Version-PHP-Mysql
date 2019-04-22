        <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">

            <a class="ud-logo navbar-brand" href="index.php"><img class="img-fluid" src="img/ud-logo/ud-logo.png" alt="Logo Universal Distrib"></a>

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <div class="container-fluid">
                    <div class="top-nav row">
                        <div class="col-md-7">
                            <form class="form-inline" method="post" action="search.php">
                                <input class="form-control mr-sm-2" name="search" type="search" placeholder="Rechercher" aria-label="Search">
                                <button class="btn btn-search btn-outline-secondary" name='submit' type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="col-lg-5 col-12">
                            <ul class="navbar-nav text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link promo" href="produits.php"><i class="fa fa-bullhorn"></i><br>Promo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="modal" href="#ud-panier"><i class="fa fa-shopping-bag"></i><br>Panier</a>
                                </li>
                                <?php if(isset($_SESSION["user_id"])&&isset($_SESSION["groupe_id"])) : ?>
                                <li class="nav-item compte-dropdown dropdown">
                                    <a id="compteDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user"></i><br>Compte
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="compteDropdown">
                                        <ul>
                                            <li><a class="dropdown-item" href="myProfil.php">Gérer</a></li>
                                            <li><a class="dropdown-item" href="_bye.php?deconnect=ok">Déconnexion</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="identification.php"><i class="fa fa-user"></i><br>Compte</a>
                                    <a class="ud-pro" href="#"><img class="img-fluid" src="img/ud-logo/ud-pro.png" alt="Logo Universal Distrib Pro"></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="bottom-nav row">
                        <div class="col-12">
                            <ul class="navbar-nav text-uppercase justify-content-center">
                                <?php while($row_category=mysqli_fetch_array($category)) : ?>
                                    <li class="nav-item category-dropdown">
                                        <a id="navbarDropdown<?php echo $row_category['nom']; ?>" class="nav-link btn dropdown-toggle active" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php if($row_category['categorie_id']==$id_affc) :?><img class="griffe" src="img/ud-image/griffes.png"><?php endif; ?>
                                            <?php echo $row_category['nom']; ?>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown<?php echo $row_category['nom']; ?>">
                                            <ul>
                                                <?php while($row_subcategory=mysqli_fetch_assoc($subcategory)) : if($row_category['categorie_id']===$row_subcategory['categorie_id']) :?>
                                                    <li><a class="dropdown-item" href="produits.php?id_affsc=<?php echo $row_subcategory['souscategorie_id']?>"><?php echo $row_subcategory['nom'].'<br>';?></a></li>
                                                <?php endif; endwhile; mysqli_data_seek($subcategory, 0); ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endwhile; mysqli_data_seek($category, 0);?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </nav>