<?php
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
?>

<nav>
    <ul class="nav-header">
        <li><a href="../Accueil.php"><img src="../_imgs/_accueil/Logo.png" alt="Logo du site"></a></li>
        <li class="hideOnMobile"><a href="../Accueil.php">Accueil</a></li>
        <li class="hideOnMobile"><a href="../Pcportable.php">PC Portable</a></li>
        <li class="hideOnMobile"><a href="../Vitre-telephone.php">Vitres téléphone</a></li>
        <li class="hideOnMobile"><a href="../Nos-prestations.php">Prestation informatique</a></li>
        <li class="hideOnMobile"><a href="../Contact.php">Nous contacter</a></li>
        <li class="hideOnMobile"><a href="../Connexion.php">Connexion</a></li>
        <li class="menu-button"><a href="#">☰</a></li>
    </ul>
    <ul class="bar-burger" id="bar-burger">
        <li class="close-button"><a href="#">×</a></li>
        <li><a href="../Accueil.php">Accueil</a></li>
        <li><a href="../Pcportable.php">PC portable</a></li>
        <li><a href="../Vitre-telephone.php">Vitres téléphone</a></li>
        <li><a href="../Nos-prestations.php">Prestation informatique</a></li>
        <li><a href="../Contact.php">Nous contacter</a></li>
        <li><a href="../Connexion.php">Connexion</a></li>
    </ul>
    <div class="indicator"></div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sélectionne tous les liens de la barre de navigation
    const navLinks = document.querySelectorAll('.nav-header a');
    // Sélectionne l'élément indicateur
    const indicator = document.querySelector('.indicator');

    // Ajoute des événements à chaque lien de navigation
    navLinks.forEach(link => {
        // Lorsque la souris survole un lien
        link.addEventListener('mouseover', function () {
            const rect = this.getBoundingClientRect(); // Obtient la position et la taille du lien
            indicator.style.width = `${rect.width}px`; // Ajuste la largeur de l'indicateur
            indicator.style.left = `${rect.left}px`;   // Ajuste la position de l'indicateur
        });

        // Lorsque la souris quitte le lien
        link.addEventListener('mouseout', function () {
            indicator.style.width = '0'; // Réinitialise la largeur de l'indicateur
        });
    });

    // Gestion du menu mobile
    const barBurger = document.getElementById('bar-burger');
    const menuButton = document.querySelector('.menu-button a');
    const closeButton = document.querySelector('.close-button a');

    function toggleMenu() {
        if (barBurger.style.display === 'flex') {
            barBurger.style.display = 'none';
        } else {
            barBurger.style.display = 'flex';
        }
    }

    function closeMenu() {
        barBurger.style.display = 'none';
    }

    // Assurez-vous que le menu est fermé initialement
    closeMenu();

    menuButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche l'événement de clic du document
        toggleMenu();
    });

    closeButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche l'événement de clic du document
        closeMenu();
    });

    document.addEventListener('click', function (event) {
        if (!barBurger.contains(event.target) && !menuButton.contains(event.target)) {
            closeMenu();
        }
    });

    barBurger.addEventListener('click', function (event) {
        if (event.target.tagName === 'A') {
            event.preventDefault();
            const url = event.target.href;
            closeMenu();
            setTimeout(function () {
                window.location.href = url;
            }, 300); // Délai de 300 ms pour permettre l'animation de fermeture du menu
        }
    });
});
</script>
