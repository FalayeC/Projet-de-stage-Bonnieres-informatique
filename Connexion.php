<?php
// Démarrage de la session pour gérer les variables de session
session_start();

// Inclusion du fichier de connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

// Vérification si le formulaire de connexion a été soumis
if (isset($_POST['connect'])) {
    // Vérification si les champs utilisateur et mot de passe ne sont pas vides
    if (!empty($_POST['user']) && !empty($_POST['pwd'])) {
        // Préparation de la requête pour récupérer les informations de l'utilisateur par email
        $req = $db->prepare('SELECT * FROM bi_users WHERE user_email = :user');
        $req->execute(['user' => $_POST['user']]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($_POST['pwd'], $user['user_password'])) {
            // Stockage des informations de l'utilisateur dans la session
            $_SESSION['auth'] = [
                'id_user' => $user['id_user'],
                'id_role' => $user['id_role'],
            ];
            // Message de bienvenue
            $_SESSION['flash']['success'] = "Bienvenue";
            // Redirection vers la page d'accueil du back-office
            echo '<script>document.location.replace("/_bo/Accueil.php")</script>';
        } else {
            // Message d'erreur en cas d'identifiants incorrects
            $_SESSION['flash']['danger'] = "Erreur.";
            // Redirection vers la page de connexion
            echo '<script>document.location.replace("Connexion.php")</script>';
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $recaptchaResponse = $_POST['recaptchaResponse'];
    
        // Clé secrète reCAPTCHA
        $secretKey = '6LcCcA4qAAAAANhJHdLh-0Cm3Uu8h0Snu9MUgK24';
    
        // Faire une requête POST pour vérifier la réponse du CAPTCHA
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
    
        $responseKeys = json_decode($response, true);
    
        // Si la validation échoue
        if (!$responseKeys['success']) {
            die('La vérification du reCAPTCHA a échoué. Veuillez réessayer.');
        }
    
        // Continuer le traitement du formulaire si la validation est réussie
    }
    
}

// Inclusion des fichiers de menu et de structure de la page
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
?>

<!-- Section centrale de la page contenant le formulaire de connexion -->
<div class="centre">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <!-- En-tête de la carte avec le titre de la page -->
                    <div class="card-header text-center">
                        <h2>Connexion</h2>
                    </div>
                    <div class="card-body">
                        <!-- Formulaire de connexion -->
                        <form method="POST">
                            <div class="form-group">
                                <label for="emailLogin">Email</label>
                                <input type="email" class="form-control" id="emailLogin" placeholder="Entrez votre email" name="user" required>
                            </div>
                            <div class="form-group">
                                <label for="passwordLogin">Mot de passe</label>
                                <input type="password" class="form-control" id="passwordLogin" name="pwd" placeholder="Entrez votre mot de passe" required>
                            </div>
                            
                            <!-- reCAPTCHA -->
                            <div class="g-recaptcha" data-sitekey="6LcCcA4qAAAAANhJHdLh-0Cm3Uu8h0Snu9MUgK24" data-action="LOGIN"></div>
                            <input type="hidden" id="recaptchaResponse" name="recaptchaResponse">
                            <!-- Bouton de soumission du formulaire -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="connect">Se connecter</button>
                            </div>
                        </form>
                        <!-- Lien pour la récupération du mot de passe oublié -->
                        <div class="text-center mt-3">
                            <a href="/forget_pwd/forgot_password.php">Mot de passe oublié ?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclusion des scripts de la page -->
<script>
        function recaptchaCallback(response) {
            document.getElementById('recaptchaResponse').value = response;
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            if (!document.getElementById('recaptchaResponse').value) {
                alert('Veuillez compléter le reCAPTCHA');
                event.preventDefault();
            }
        });
    </script>

<script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
<!-- Inclusion du pied de page -->
<?php 
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/footer.php");
?>
