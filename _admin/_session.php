			<div class="tab-content">
				<section class="col-sm-4">
					<h2 class="text-center">Compte</h2>
					<address class="thumbnail text-left">
						<p><strong>Identification</strong><a href="../index.php" class="pull-right btn btn-info" title="Accéder au FrontOffice (site public)"><span class="glyphicon glyphicon-open"></span></a><br><?php echo $_SESSION["nom"]."&nbsp;".$_SESSION["prenom"]; ?></p>
						<p><strong>Contact</strong><br><?php echo $_SESSION["email"]; ?></p>
						<p><strong>Statut</strong><br><?php echo $_SESSION["groupe_nom"]; ?></p>
						<p><strong>Age</strong><br><?php echo $_SESSION["age"]; ?>&nbsp;an<?php if($_SESSION["age"]>1) echo"s"; ?></p>
						<p class="text-center"><a href="http://validator.w3.org/check?uri=referer" title="Validation HTML5" target="_blank"><i class="fa fa-html5 fa-3x"></i></a></p>
					</address>
				</section>
			</div>