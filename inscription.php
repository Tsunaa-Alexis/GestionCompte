<!DOCTYPE html>
<html>
    <head>
        <title>PhotoForYou</title>
        <?php include ("header.php"); ?>
        <script language="javascript" type="text/javascript" src="js/inscription.min.js"></script>
    </head>
    <body>  
        <div class="main">
            <?php include ("sideBar.php"); ?>
            <div class="container">
                <div class="jumbotron">
                    <h1 class="display-4">Inscription</h1>
                    <p class="lead">Merci de remplir ce formulaire d'inscription.</p>
                    <hr class="my-4">
                        <p>Vous ferez bientôt parti de nos membres. Vous avez fait le bon choix ;-)</p>
                    </hr>
                </div>
                <form method="POST" oninput='motdepasse2.setCustomValidity(motdepasse2.value != motdepasse1.value ?  "Mot de passe non identique" : "")' onsubmit="return verifForm(this)" id="form" novalidate>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="prenom">Prénom *</label>
                            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prénom" required>
                            <div class="invalid-feedback">
                                Le champ prénom est obligatoire
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="nom">Nom *</label>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="Votre nom" required>
                            <div class="invalid-feedback">
                                Le champ nom est obligatoire
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="email">Adresse électronique *</label>
                            <input type="email" class="form-control" name="mail" id="mail" placeholder="E-mail" required>
                            <small id="emailHelp" class="form-text text-muted">Nous ne partagerons votre email.</small>
                            <div class="email invalid-feedback">
                                Vous devez fournir un email valide.
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="prenom">Num. Tel</label>
                            <input type="text" class="form-control" name="numTel" id="numTel" placeholder="Votre numéro de téléphone">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="motDePasse1">Votre mot de passe *</label>
                            <input type="password" class="form-control" name="motdepasse1" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="motDePasse2">Confirmation du mot de passe *</label>
                            <input type="password" class="form-control" name="motdepasse2" required>
                            <div name="message" class="invalid-feedback">
                                Mot de passe invalide
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary"/>
                </form>
            </div>
        </div>
    </body>
</html>