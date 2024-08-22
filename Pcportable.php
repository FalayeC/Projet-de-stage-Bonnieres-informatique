<?php
// Inclure le doctype de base du site
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");

// Inclure le menu de navigation du site
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');

// Inclure le fichier de connexion à la base de données
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

// Sélectionner toutes les données pour les produits HP
$SelectVitreHp = $db->prepare("SELECT * FROM bi_hp");
$SelectVitreHp->execute();
$vitreHp = $SelectVitreHp->fetchAll(PDO::FETCH_OBJ);

// Sélectionner toutes les données pour les produits Lenovo
$SelectVitreLenovo = $db->prepare("SELECT * FROM bi_lenovo");
$SelectVitreLenovo->execute();
$vitreLenovo = $SelectVitreLenovo->fetchAll(PDO::FETCH_OBJ);
?>

<!-- Titre principal de la page -->
<div class="title">
    <h1>PC Portable</h1>
    <p>Nous vendons quelques PC, n'hésitez pas à nous contacter pour en savoir plus !</p>
</div>

<!-- Filtres pour les produits -->
<div class="filters">
    <button class="filter-button" data-category="all">Tous</button>
    <button class="filter-button" data-category="LENOVO">LENOVO</button>
    <button class="filter-button" data-category="HP">HP</button>
</div>

<!-- Conteneur des produits -->
<div class="products-container">
    <?php foreach ($vitreLenovo as $lenovo): ?>
        <div class="product LENOVO">
            <img src="/_imgs/_pc-portable/<?php echo $lenovo->lenovo_img; ?>" alt="Image de PC LENOVO">
            <h2><?php echo $lenovo->lenovo_modele; ?></h2>
            <button class="description-button" onclick="toggleDescription(this)">Voir la description</button>
            <div class="product-description">
                <p>Description détaillée du produit</p>
                <ul>
                    <li>Grade : <?php echo $lenovo->lenovo_grade; ?></li>
                    <li>Processeur : <?php echo $lenovo->lenovo_processeur; ?></li>
                    <li>Mémoire : <?php echo $lenovo->lenovo_memoire; ?></li>
                    <li>Disque dur : <?php echo $lenovo->lenovo_disque_dur; ?></li>
                    <li>Écran : <?php echo $lenovo->lenovo_ecran; ?></li>
                    <li>Clavier : <?php echo $lenovo->lenovo_clavier; ?></li>
                    <li>Connectique : <?php echo $lenovo->lenovo_connectique; ?></li>
                    <li>Sorties : <?php echo $lenovo->lenovo_sorties; ?></li>
                    <li>Système d'exploitation : <?php echo $lenovo->lenovo_systeme_exploitation; ?></li>
                    <li>Carte graphique : <?php echo $lenovo->lenovo_carte_graphique; ?></li>
                    <li>Batterie : <?php echo $lenovo->lenovo_batterie; ?></li>
                    <li>Prix : <?php echo $lenovo->lenovo_prix; ?> euros</li>
                    <li>Livraison : <?php echo $lenovo->lenovo_livraison; ?> euros</li>
                    <li>Garantie : <?php echo $lenovo->lenovo_garantie; ?></li>
                </ul>
            </div>
            <button onclick="buyProduct('<?php echo $lenovo->lenovo_modele; ?>')">Acheter</button>
        </div>
    <?php endforeach; ?>

    <?php foreach ($vitreHp as $hp): ?>
        <div class="product HP">
            <img src="/_imgs/_pc-portable/<?php echo $hp->hp_img; ?>" alt="Image de PC HP">
            <h2><?php echo $hp->hp_modele; ?></h2>
            <button class="description-button" onclick="toggleDescription(this)">Voir la description</button>
            <div class="product-description">
                <p>Description détaillée du produit</p>
                <ul>
                    <li>Grade : <?php echo $hp->hp_grade; ?></li>
                    <li>Processeur : <?php echo $hp->hp_processeur; ?></li>
                    <li>Mémoire : <?php echo $hp->hp_memoire; ?></li>
                    <li>Disque dur : <?php echo $hp->hp_disque_dur; ?></li>
                    <li>Écran : <?php echo $hp->hp_ecran; ?></li>
                    <li>Clavier : <?php echo $hp->hp_clavier; ?></li>
                    <li>Connectique : <?php echo $hp->hp_connectique; ?></li>
                    <li>Sorties : <?php echo $hp->hp_sorties; ?></li>
                    <li>Système d'exploitation : <?php echo $hp->hp_systeme_exploitation; ?></li>
                    <li>Carte graphique : <?php echo $hp->hp_carte_graphique; ?></li>
                    <li>Batterie : <?php echo $hp->hp_batterie; ?></li>
                    <li>Prix : <?php echo $hp->hp_prix; ?> euros</li>
                    <li>Livraison : <?php echo $hp->hp_livraison; ?> euros</li>
                    <li>Garantie : <?php echo $hp->hp_garantie; ?></li>
                </ul>
            </div>
            <button onclick="buyProduct('<?php echo $hp->hp_modele; ?>')">Acheter</button>
        </div>
    <?php endforeach; ?>
</div>


<?php 
// Inclure le pied de page du site
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/footer.php");
?>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-button');
    const descriptionButtons = document.querySelectorAll('.description-button');

    function filterProducts(category) {
        const products = document.querySelectorAll('.product');
        products.forEach(product => {
            if (category === 'all' || product.classList.contains(category)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });

        filterButtons.forEach(button => {
            button.classList.remove('selected');
            if (button.getAttribute('data-category') === category) {
                button.classList.add('selected');
            }
        });
    }

    filterProducts('all');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const category = this.getAttribute('data-category');
            filterProducts(category);
        });
    });

    function toggleDescription(button) {
        const product = button.closest('.product');
        const description = product.querySelector('.product-description');
        const isVisible = description.classList.contains('visible');

        if (!isVisible) {
            description.style.maxHeight = description.scrollHeight + 'px';
            description.classList.add('visible');
            button.textContent = 'Masquer la description';
        } else {
            description.style.maxHeight = '0';
            description.classList.remove('visible');
            button.textContent = 'Voir la description';
        }
    }

    descriptionButtons.forEach(button => {
        button.addEventListener('click', function () {
            const visibleDescriptions = document.querySelectorAll('.product-description.visible');

            visibleDescriptions.forEach(description => {
                if (description !== this.parentElement.querySelector('.product-description')) {
                    description.style.maxHeight = '0';
                    description.classList.remove('visible');
                    description.previousElementSibling.textContent = 'Voir la description';
                }
            });

            toggleDescription(this);
        });
    });
});

</script>
