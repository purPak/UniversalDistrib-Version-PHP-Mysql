<section id="identification">

    <div class="row justify-content-center">

        <div class="inscription col-lg-5 col-10">
            <form method="post" action="_veriflog.php">
                <h4>CRÉER VOTRE COMPTE</h4>
                <hr>
                <p>Saisissez votre adresse e-mail pour créer votre compte :</p>
                <div class="form-group">
                    <label for="NewUserEmail">Adresse E-mail</label>
                    <input type="email" class="form-control col-7" id="NewUserEmail" placeholder="Entrer votre E-mail">
                </div>
                <br>
                <div class="col-12">
                    <a  href="<?php if($e==2){echo "commande-seconnecter.php?auth=1";} else{echo "authentification.php";}?>" class="btn btn-dark col-auto">
                        <i class="fa fa-user"></i>&nbsp;S'inscrire
                    </a>
                </div>
            </form>
        </div>

        <div class="connection col-lg-5 col-10">
            <form method="post" action="_veriflog.php">
                <h4>DÉJÀ INSCRIT ?</h4>
                <hr>
                <div class="form-group row">
                    <label for="login" class="col-form-label col-4">Identifiant:</label>
                    <input class="form-control col-7" type="text" name="login" id="login" placeholder="Entrer votre E-mail">
                </div>
                <br>
                <div class="form-group row">
                    <label for="password" class="col-form-label col-4">Mot de passe:</label>
                    <input class="form-control col-7" type="password" name="password" id="password" placeholder="Entrer votre mot de passe">
                </div>
                <br>
                <div class="col-12">
                    <button type="submit" class="btn btn-dark col-auto" name="connection" id="connection" value="Identifier">
                        <i class="fa fa-lock"></i>&nbsp;Se connecter
                    </button>
                    <a class="col-6" href="#">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>

</section>