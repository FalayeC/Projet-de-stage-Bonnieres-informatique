<?php
// Connectez-vous à ma base de données
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

// Activez les erreurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifiez si le jeton est valide et n'a pas expiré
    $stmt = $db->prepare("SELECT * FROM bi_password_resets WHERE reset_token = ? AND reset_expire_at > NOW()");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        // Update du mot de passe de l'utilisateur
        $stmt = $db->prepare("UPDATE bi_users SET user_password = ? WHERE user_email = ?");
        $result = $stmt->execute([$password, $reset['reset_email']]);

        if ($result) {
            echo 'Votre mot de passe a été réinitialisé avec succès vous pouvez retourner dans votre page de connexion.';
        } else {
            echo 'Erreur lors de la mise à jour du mot de passe : ' . implode(", ", $stmt->errorInfo());
        }
    } else {
        echo 'Le lien de réinitialisation est invalide ou a expiré.';
    }
}
?>
