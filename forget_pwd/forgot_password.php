<?php
// Inclusion des fichiers de configuration et de menu
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');
include($_SERVER['DOCUMENT_ROOT'].'/host.php');
?>

<div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Mot de passe oublié</h3>
                <form method="POST" action="/forget_pwd/reset_lien_password.php">
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre e-mail" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>