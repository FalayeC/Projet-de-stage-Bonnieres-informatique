<?php

// Inclusions des fichiers nécessaires
require_once __DIR__ . '/../_bo/_blocks/doctype.php';
require_once __DIR__ . '/../_bo/_blocks/menu.php';

// Utilisation de l'Autoloader pour charger automatiquement les classes PHP
use App\Db\Db;
use App\Autoloader;

// Inclusion de l'Autoloader
require_once __DIR__ . '/../App/Autoloader.php';
Autoloader::register(); // Enregistrement de l'Autoloader

// Vérification de l'authentification de l'utilisateur
if (!isset($_SESSION['auth'])) {
    header('Location: /Connexion.php');
    exit();
}

// Récupération de l'ID de l'utilisateur depuis la session
$id_user = $_SESSION['auth']['id_user'];

// Instance de la classe Db pour gérer la base de données
$db = Db::getInstance();

// Préparation et exécution de la requête pour récupérer les informations de l'utilisateur
$selectUser = $db->prepare('SELECT * FROM bi_users WHERE id_user = ?');
$selectUser->execute([$id_user]);
$user = $selectUser->fetch(PDO::FETCH_OBJ); // Récupération des résultats sous forme d'objet PDO

?>

<?php if ($user): ?>
    <!-- Affichage des informations de l'utilisateur-->
    <div class="container">
        <div class="Title">
            <h1>Bienvenue <?php echo htmlspecialchars($user->user_surname); ?> sur votre back office</h1>
            <p>Ici vous pouvez voir vos pages mises en ligne, les mettre à jour, les supprimer ou rajouter un élément.</p>
        </div>
    </div>
<?php endif; ?>
