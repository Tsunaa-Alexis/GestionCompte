<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <?php include ("header.php"); ?>
        <script language="javascript" type="text/javascript" src="js/login.min.js"></script>
        <link rel="stylesheet" href="./css/login.min.css">
    </head>
    <body>
        <div class="main">
            <?php include ("sideBar.php"); ?>
            <div class="container">
                <div class="jumbotron">
                    <h1 class="display-4">Connexion</h1>
                    <p class="lead">Merci de vous identifier</p>
                </div>
                <div class="popUp hide">
                    <div class="messageAlerte">Identifiants incorrect</div>
                </div>
                <form method="post" id="formId"  onsubmit="return verifForm(this)" novalidate>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="email">Adresse électronique : </label>
                            <input type="email" class="form-control" name="mail" id="email" placeholder="E-mail" required>
                            <div class="invalid-feedback">
                                Le champ email est obligatoire
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="motDePasse1">Mot de passe :</label>
                            <input type="password" class="form-control" name="motdepasse" required>
                        </div>
                        <div class="invalid-feedback">
                            Vous devez fournir un mot de passe.
                        </div>
                    </div>
                    <input type="submit" value="Valider" class="btn btn-primary" name="identifier" />
                </form>
            </div>
        </div>
    </body>
</html>