document.addEventListener('DOMContentLoaded', function () {
    // Sélection des éléments DOM nécessaires
    const barBurger = document.getElementById('bar-burger'); // Le menu à afficher/cacher
    const menuButton = document.querySelector('.menu-button a'); // Le bouton d'ouverture du menu
    const closeButton = document.querySelector('.close-button a'); // Le bouton de fermeture du menu

    // Fonction pour basculer l'affichage du menu
    function toggleMenu() {
        if (barBurger.style.display === 'flex') {
            barBurger.style.display = 'none'; // Cache le menu s'il est visible
        } else {
            barBurger.style.display = 'flex'; // Affiche le menu s'il est caché
        }
    }

    // Fonction pour fermer le menu
    function closeMenu() {
        barBurger.style.display = 'none'; // Cache toujours le menu
    }

    // Assurez-vous que le menu est fermé initialement lors du chargement de la page
    closeMenu();

    // Gestionnaire d'événement pour ouvrir le menu
    menuButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche la propagation de l'événement pour éviter que le document ne soit cliqué
        toggleMenu();
    });

    // Gestionnaire d'événement pour fermer le menu
    closeButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche la propagation de l'événement pour éviter que le document ne soit cliqué
        closeMenu();
    });

    // Gestionnaire d'événement global pour fermer le menu lors du clic en dehors du menu
    document.addEventListener('click', function (event) {
        // Vérifie si l'élément cliqué n'est ni dans le menu ni sur le bouton d'ouverture
        if (!barBurger.contains(event.target) && !menuButton.contains(event.target)) {
            closeMenu(); // Si c'est le cas, ferme le menu
        }
    });

    // Gestionnaire d'événement pour gérer les clics sur les liens à l'intérieur du menu
    barBurger.addEventListener('click', function (event) {
        if (event.target.tagName === 'A') { // Si le clic est sur un lien <a>
            event.preventDefault(); // Empêche le comportement par défaut de suivre le lien
            const url = event.target.href; // Récupère l'URL du lien
            closeMenu(); // Ferme le menu
            setTimeout(function () {
                window.location.href = url; // Navigue vers l'URL après un court délai pour l'animation de fermeture
            }, 300); // Délai de 300 ms (peut être ajusté selon les besoins)
        }
    });
});
