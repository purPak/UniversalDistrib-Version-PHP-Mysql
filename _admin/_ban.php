		<nav class="navbar navbar-inverse">
			<div class="navbar-header">  
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<ul class="nav navbar-nav">
					<li<?php if($a===1) {echo' class="active"';}?>><a class="navbar-brand" href="index.php"><img class="img-responsive" src="../img/ud-logo/ud-logo.png" alt="Image Logo Universal Distrib"></a></li>
				</ul>

			</div>
			<div class="collapse navbar-collapse">
                <?php if(isset($_SESSION["user_id"])&&isset($_SESSION["groupe_id"])) : ?>
				<ul class="nav navbar-nav">
                    <li class="dropdown<?php if($a>2&&$a<3) {echo' active';}?>"><a data-toggle="dropdown" href="#">Utilisateurs<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li<?php if($a===2.1) {echo' class="active"';}?>><a href="utilisateurs.php">Liste des utilisateurs</a></li>
                            <li<?php if($a===2.2) {echo' class="active"';}?>><a href="utilisateurs_ajout.php">Ajouter un utilisateur</a></li>
                        </ul>
                    </li>
                    <li class="dropdown<?php if($a>3&&$a<4) {echo' active';}?>"><a data-toggle="dropdown" href="#">Groupes<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li<?php if($a===3.1) {echo' class="active"';}?>><a href="groupes.php">Liste des groupes</a></li>
                            <li<?php if($a===3.2) {echo' class="active"';}?>><a href="groupes_ajout.php">Ajouter un groupe</a></li>
                        </ul>
                    </li>
					<li class="dropdown<?php if($a>4&&$a<5) {echo' active';}?>"><a data-toggle="dropdown" href="#">Produits<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li<?php if($a===4.1) {echo' class="active"';}?>><a href="produits.php">Liste des produits</a></li>
                            <li<?php if($a===4.2) {echo' class="active"';}?>><a href="produits_ajout.php">Ajouter un produit</a></li>
						</ul>
					</li>
                    <li class="dropdown<?php if($a>5&&$a<6) {echo' active';}?>"><a data-toggle="dropdown" href="#">Catégories<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li<?php if($a===5.1) {echo' class="active"';}?>><a href="categories.php">Liste des catégories</a></li>
                            <li<?php if($a===5.2) {echo' class="active"';}?>><a href="categories_ajout.php">Ajouter une catégorie</a></li>
                        </ul>
                    </li>
                    <li class="dropdown<?php if($a>6&&$a<7) {echo' active';}?>"><a data-toggle="dropdown" href="#">Sous-Catégories<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li<?php if($a===6.1) {echo' class="active"';}?>><a href="souscategories.php">Liste des sous-catégories</a></li>
                            <li<?php if($a===6.2) {echo' class="active"';}?>><a href="souscategories_ajout.php">Ajouter une sous-catégorie</a></li>
                        </ul>
                    </li>
                    <li><a href="commandes.php">Commande</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
					<li><a href="../_bye.php?deconnect=change">Changer d'utilisateur</a></li>
					<li><a href="../_bye.php?deconnect=ok">Déconnexion</a></li>
				</ul>
                <?php endif; ?>
				<form class="navbar-form navbar-right inline-form" method="post" action="../search.php">
					<div class="form-group">
						<input type="search" class="input-sm form-control" placeholder="Recherche" name="search" id="search">
						<button type="submit" name="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chercher</button>
					</div>
				</form>
			</div>
		</nav>

























