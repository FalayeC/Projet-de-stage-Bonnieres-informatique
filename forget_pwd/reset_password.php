<?php
// Inclusion des fichiers de configuration et de menu
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');
include($_SERVER['DOCUMENT_ROOT'].'/host.php');
?>
  
  <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Réinitialiser le mot de passe</h3>
                <form method="POST" action="/forget_pwd/update_password.php">
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmez votre mot de passe" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
