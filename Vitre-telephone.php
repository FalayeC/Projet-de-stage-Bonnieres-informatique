<?php
// Inclure le doctype de base du site
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");

// Inclure le menu de navigation du site
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');

// Inclure le fichier de connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

// Sélectionner toutes les images d'accueil pour iPhone
$SelectVitreIphone = $db->prepare("SELECT * FROM bi_iphone");
$SelectVitreIphone->execute();
$vitreIphone = $SelectVitreIphone->fetchAll(PDO::FETCH_OBJ);

// Sélectionner toutes les images d'accueil pour Samsung
$SelectVitreSamsung = $db->prepare("SELECT * FROM bi_samsung");
$SelectVitreSamsung->execute();
$vitreSamsung = $SelectVitreSamsung->fetchAll(PDO::FETCH_OBJ);
?>

<!-- Titre principal de la page -->
<div class="Title">
    <h1>Vitres téléphone</h1>
    <p>REMPLACEMENT EN 1H SELON STOCK DISPONIBLE !</p>
    <p>N'hésitez pas à nous contacter pour d'autres modèles. Nous réparons d'autres marques et références, (Huawei, Asus, Wiko, etc.).</p>
</div>

<!-- Contenu principal avec des sections pour chaque type de téléphone/tablette -->
<div class="clearfix">
    <div class="content">
        <!-- Section pour les iPhones -->
        <div id="iphone" class="section">
            <h2>iPhone</h2>
            <ul>
                <?php foreach ($vitreIphone as $iphone): ?>
                    <li><?php echo ($iphone->iphone_modele); ?>: <?php echo ($iphone->iphone_prix); ?> €</li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Section pour les Samsung -->
        <div id="samsung" class="section">
            <h2>Samsung</h2>
            <ul>
                <?php foreach ($vitreSamsung as $samsung): ?>
                    <li><?php echo ($samsung->samsung_modele); ?>: <?php echo ($samsung->samsung_prix); ?> €</li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Section pour les iPads -->
        <div id="ipad" class="section">
            <h2>iPad</h2>
            <p>Votre vitre iPad remplacée en 48H selon modèle et stock disponible ! Contactez-nous pour en savoir plus.</p>
        </div>

        <!-- Section pour les Galaxy Tabs -->
        <div id="galaxytab" class="section">
            <h2>Galaxy Tab</h2>
            <p>Votre vitre Galaxy Tab remplacée en 48H selon modèle et stock disponible ! Contactez-nous pour en savoir plus.</p>
        </div>
    </div>
</div>

<?php 
// Inclure le pied de page du site
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/footer.php");
?>
