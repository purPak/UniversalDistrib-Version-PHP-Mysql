<section class="indication" id="adresse">
    <div class="container">
        <ul class="nav nav-pills nav-fill text-center">
            <li class="nav-item col-auto border">
                <a class="nav-link <?php if($e===1) echo "active"; if($e>1) echo " bg-secondary"?>" href="commande-recap.php"><h6>01 - Récapitulatif</h6></a>
            </li>
            <li class="nav-item col-auto border">
                <a class="nav-link <?php if($e===2) echo "active";  if($e>2) echo " bg-secondary"?>" href="commande-seconnecter.php"><h6>02 - Se connecter</h6></a>
            </li>
            <li class="nav-item col-auto border ">
                <a class="nav-link <?php if($e===3) echo "active"; if($e>3) echo " bg-secondary"?>" href="commande-adresse.php"><h6>03 - Adresse</h6></a>
            </li>
            <li class="nav-item col-auto border">
                <a class="nav-link <?php if($e===4) echo "active"?>" href="#"><h6>04 - Paiement</h6></a>
            </li>
            <li class="nav-item col-auto border">
                <a class="nav-link <?php if($e===5) echo "active"?>" href="#"><h6>05 - Confirmation</h6></a>
            </li>
        </ul>
    </div>
</section>