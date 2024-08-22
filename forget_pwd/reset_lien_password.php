<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/_libs/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/_libs/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/_libs/PHPMailer/src/SMTP.php';


include($_SERVER['DOCUMENT_ROOT'].'/host.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Vérifiez si l'e-mail existe
    $stmt = $db->prepare("SELECT * FROM bi_users WHERE user_email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    date_default_timezone_set('Europe/Paris');

    if ($user) {
        $token = bin2hex(random_bytes(50));

        // Enregistrez le jeton avec une expiration de 10 minutes
        $stmt = $db->prepare("INSERT INTO bi_password_resets (reset_email, reset_token, reset_expire_at, reset_created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $token, date('Y-m-d H:i:s', strtotime('+10 minutes')), date('Y-m-d H:i:s')]);

        $resetLink = "http://localhost/forget_pwd/reset_password.php?token=" . $token;
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href=\"$resetLink\">$resetLink</a>";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'zerkodu28@gmail.com'; // Remplacez par le adresse email
            $mail->Password = 'jshv zztu artw hhrm'; // Remplacez par le mot de passe d'application
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('votre_email@gmail.com', 'Votre Nom');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            
            echo 'Le lien de réinitialisation a été envoyé à votre adresse e-mail vous pouvez fermer cette page.'
            ;
        } catch (Exception $e) {
            echo "L'e-mail n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cette adresse e-mail.";
    }
}
?>
