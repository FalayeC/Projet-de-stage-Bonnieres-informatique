p<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Inclure les fichiers PHPMailer
require '_libs/PHPMailer/src/Exception.php';
require '_libs/PHPMailer/src/PHPMailer.php';
require '_libs/PHPMailer/src/SMTP.php';
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);

    // Validation des données
    if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($telephone) && !empty($sujet) && !empty($message)) {
        // Créer une instance de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Remplacez par l'adresse de votre serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'zerkodu28@gmail.com'; // Remplacez par votre adresse email
            $mail->Password = 'jshv zztu artw hhrm'; // Remplacez par votre mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataire et expéditeur
            $mail->setFrom($email, $prenom . ' ' . $nom);
            $mail->addAddress('zerkodu28@gmail.com'); // Remplacez par votre adresse email

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Formulaire de contact: ' . $sujet;
            $mail->Body = "<p>Prénom: $prenom</p><p>Nom: $nom</p><p>Email: $email</p><p>Téléphone: $telephone</p><p>Message:<br>$message</p>";

            // Envoyer l'email
            $mail->send();
            $message = "Merci pour votre message. Nous vous répondrons dès que possible.";
            $status = "success";
        } catch (Exception $e) {
            $message = "Désolé, une erreur s'est produite. Veuillez réessayer plus tard. Erreur de mailer: {$mail->ErrorInfo}";
            $status = "error";
        }

        } else {
            echo "Veuillez remplir tous les champs.";
        }
    } else {
        echo "Méthode de requête non valide.";
    }
?>
    <script>
            setTimeout(function() {
                window.location.href = '../../Accueil.php'; // Redirige vers la page d'accueil après 5 secondes
            }, 3000);
        </script>
    <div class="message-box <?php echo $status; ?>">
        <h2><?php echo $status === 'success' ? 'Merci!' : 'Erreur'; ?></h2>
        <p><?php echo $message; ?></p>
    </div>
