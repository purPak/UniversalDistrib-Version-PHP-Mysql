        <!-- Contact -->
        <section id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="contact-title text-uppercase">Nous contacter</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="contactForm" name="sentMessage" novalidate="novalidate">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="nameContact" type="text" placeholder="Votre Nom *" required="required" data-validation-required-message="Veuillez compléter le champ nom .">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" id="emailContact" type="email" placeholder="Votre Email *" required="required" data-validation-required-message="Veuillez compléter le champ e-mail.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" id="phoneContact" type="tel" placeholder="Votre Téléphone *" required="required" data-validation-required-message="Veuillez compléter le champ téléphone.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <textarea class="form-control" id="messageContact" placeholder="Votre Message *" required="required" data-validation-required-message="Veuillez compléter le champ message."></textarea>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <div id="success"></div>
                                    <button id="sendMessageButton" class="btn btn-contact btn-primary btn-xl text-uppercase" type="submit">Envoyer</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="top-footer row">
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-cc-visa"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
<a href="#">
                                <i class="fa fa-cc-mastercard"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-cc-discover"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-cc-amex"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-cc-paypal"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li class="list-inline-item">
                            <a href="#">Mentions Légales</a>
                        </li>
                        <li class="list-inline-item">
                            |
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Conditions Générales</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-snapchat-ghost"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bottom-footer row">
                <div class="col-md-12 text-center">
                    <span class="copyright">Copyright &copy; Universal Distrib <?php echo date('Y'); ?></span>
                </div>
            </div>
        </footer>