<?php
// Inclusion des fichiers de configuration et de menu
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

// Selection de  toutes les images d'accueil depuis la base de données
$ImgAccueil = $db->prepare("SELECT * FROM bi_accueil");
$ImgAccueil->execute();
$images = $ImgAccueil->fetchAll(PDO::FETCH_OBJ);

// selection de  toutes les descriptions d'horaires depuis la base de données
$HorDesc = $db->prepare("SELECT * FROM bi_horaire");
$HorDesc->execute();
$horaires = $HorDesc->fetchAll(PDO::FETCH_OBJ);
?>

<div class="Section">
    <!-- Affichage de la première image d'accueil -->
    <img src="/_imgs/_accueil/<?php echo $images[0]->accueil_image; ?>" id="image1" alt="Image de la page d'accueil">
    <div class="text-over-image">
        <h1>BIENVENUE CHEZ Bonnière Informatiques</h1>
        <!-- Affichage la descriptions d'horaires -->
        <?php foreach ($horaires as $horaire): ?> 
            <p><?php echo ($horaire->horaire_description); ?></p>
        <?php endforeach; ?>
        <p id="bottom-p">Le changement de votre vitre en 1h !</p>
        <a href="/Vitre-telephone.php"><button>Voir les prix</button></a>
    </div>
</div>

<div class="Section">
    <div class="text">
        <!-- Section de don pour l'Afrique -->
        <h2>Un don pour l'Afrique</h2>
        <p>L'association pour une Afrique Numérique sollicite votre aide pour munir les élèves africains d'outils informatiques essentiels.</p>
        <p>Notre mission est de combler le fossé numérique et de fournir aux jeunes les ressources nécessaires pour réussir dans un monde de plus en plus technologique.</p>
    </div>
    <!-- Affichage des images liées au don pour l'Afrique -->
    <img src="/_imgs/_accueil/<?php echo $images[1]->accueil_image; ?>" alt="Image de l'école privée du Mali">
    <div class="row">
        <img src="/_imgs/_accueil/<?php echo $images[2]->accueil_image; ?>" alt="Image d'enfants utilisant des ordinateurs">
        <img src="/_imgs/_accueil/<?php echo $images[3]->accueil_image; ?>" alt="Deuxième image d'enfants utilisant des ordinateurs">
    </div>
    <div class="text">
        <p>Vous avez un ordinateur de plus de 10 ans ? Ne le jetez plus !</p>
    </div>
    <div class="text">
        <p>Plus d'informations sur <a href="https://www.pourunafrique-numerique.org" target="_blank">www.pouruneafrique-numerique.org</a>. Vous pouvez aussi nous contacter au : 06 51 77 69 92. Le dépôt est situé au 12 Rue Georges Herrewyn, 78270 Bonnières-sur-Seine.</p>
    </div>
</div>

<?php 
// Inclusion du pied de page
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/footer.php");
?>
