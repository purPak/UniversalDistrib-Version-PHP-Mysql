<section class="authentification">
    <div class="container">
        <h5>VOS INFORMATION PERSONNELLES</h5><hr>
        <form autocomplete="on" method="post" action="authentification.php">
            <div class="form-row">
                <div class="offset-1 col-md-10">
                    <label for="email"><span class="text-danger">*</span>Email :</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Votre email" <?php if(isset($_POST['email'])) {echo 'value="'.$_POST['email'].'"';} ?>>
                </div>
                <?php if(isset($erreur_email)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Email" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="password"><span class="text-danger">*</span>Mot de passe :</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" <?php if(isset($_POST['password'])) {echo 'value="'.$_POST['password'].'"';} ?>>
                </div>
                <?php if(isset($erreur_password)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "mot de passe" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="sexe" >Civilité :</label>
                    <select name="sexe" id="sexe" class="form-control">
                        <option>Monsieur</option>
                        <option>Madame</option>
                    </select>
                </div>

                <div class="offset-1 col-md-10">
                    <label for="nom"><span class="text-danger">*</span>Nom :</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Votre nom" <?php if(isset($_POST['nom'])) {echo 'value="'.$_POST['nom'].'"';} ?>>
                </div>
                <?php if(isset($erreur_nom)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Nom" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="prenom"><span class="text-danger">*</span>Prénom :</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prénom"  <?php if(isset($_POST['prenom'])) {echo 'value="'.$_POST['prenom'].'"';} ?>>
                </div>
                <?php if(isset($erreur_prenom)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Prenom" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="date_naissance"><span class="text-danger">*</span>Date de naissance :</label>
                    <input type="text" class="form-control" name="date_naissance" id="date_naissance"  <?php if(isset($_POST['date_naissance'])) {echo 'value="'.$_POST['date_naissance'].'"';} ?>>
                </div>
                <?php if(isset($erreur_date)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Date de naissance" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="tel"><span class="text-danger">*</span>Numero de Télephone :</label>
                    <input type="number" class="form-control" name="tel" id="tel" placeholder="Votre numero de telephone" <?php if(isset($_POST['tel'])) {echo 'value="'.$_POST['tel'].'"';} ?>>
                </div>
                <?php if(isset($erreur_tel)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Telephone" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="adress"><span class="text-danger">*</span>Adresse :</label>
                    <input type="text" class="form-control" name="adresse" id="adress" placeholder="Votre adresse" <?php if(isset($_POST['adresse'])) {echo 'value="'.$_POST['adresse'].'"';} ?>>
                </div>
                <?php if(isset($erreur_adresse)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Adresse" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="form-group offset-1 col-md-10">
                    <label for="adressecpt">Complément d'adresse :<br>(Batiment,digicode,numero de porte etc...)</label>
                    <textarea class="form-control" name="adressecpt" id="adressecpt" rows="2"></textarea>
                </div>

                <div class="offset-1 col-md-10">
                    <label for="societe">Nom de Société:</label>
                    <input type="text" class="form-control" name="societe" id="societe" placeholder="Nom de votre société" <?php if(isset($_POST['societe'])) {echo 'value="'.$_POST['societe'].'"';} ?>>
                </div>
                <?php if(isset($erreur_societe)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Société" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="cp"><span class="text-danger">*</span>Code Postal:</label>
                    <input type="number" class="form-control" name="cp" id="cp" placeholder="Code postal de la ville" <?php if(isset($_POST['cp'])) {echo 'value="'.$_POST['cp'].'"';} ?>>
                </div>
                <?php if(isset($erreur_cp)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Code Postal" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="ville"><span class="text-danger">*</span>Ville:</label>
                    <input type="text" class="form-control" name="ville" id="ville" placeholder="Nom de la ville" <?php if(isset($_POST['ville'])) {echo 'value="'.$_POST['ville'].'"';} ?>>
                </div>
                <?php if(isset($erreur_ville)) : ?>
                    <div class="alert alert-danger offset-1 col-md-5" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        &nbsp;Attention, le champs "Ville" n'est pas valide.
                    </div>
                <?php endif; ?>

                <div class="offset-1 col-md-10">
                    <label for="pay">Pays :</label>
                    <select name="pay" id="pay" class="form-control">
                        <option>France</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary offset-lg-9 offset-md-9 offset-sm-9 offset-5 " name="valider" id="valider" value="Valider" type="submit">valider</button>
        </form>
    </div>
</section>