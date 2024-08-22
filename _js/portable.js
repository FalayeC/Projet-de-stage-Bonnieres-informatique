document.addEventListener('DOMContentLoaded', function () {
    const barBurger = document.getElementById('bar-burger'); // Sélectionne l'élément du menu burger
    const menuButton = document.querySelector('.menu-button a'); // Sélectionne le bouton d'ouverture du menu
    const closeButton = document.querySelector('.close-button a'); // Sélectionne le bouton de fermeture du menu

    function toggleMenu() {
        if (barBurger.style.display === 'flex') {
            barBurger.style.display = 'none'; // Cache le menu s'il est visible
        } else {
            barBurger.style.display = 'flex'; // Affiche le menu s'il est caché
        }
    }

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

    // Fonction pour filtrer les produits par marque
    function filterProducts(brand) {
        const allProducts = document.querySelectorAll('.product'); // Sélectionne tous les produits
        allProducts.forEach(product => {
            if (brand === 'all') {
                product.classList.add('show'); // Affiche tous les produits si la marque est 'all'
            } else {
                if (product.classList.contains(brand)) {
                    product.classList.add('show'); // Affiche le produit s'il correspond à la marque sélectionnée
                } else {
                    product.classList.remove('show'); // Cache le produit s'il ne correspond pas à la marque sélectionnée
                }
            }
        });
    }

    // Fonction pour basculer l'affichage de la description du produit
    function toggleDescription(button) {
        const productDescription = button.parentElement.parentElement.nextElementSibling; // Sélectionne la description du produit
        if (productDescription.style.display === "none" || productDescription.style.display === "") {
            productDescription.style.display = "block"; // Affiche la description si elle est cachée ou non définie
            button.innerHTML = "&#x25B2;"; // Flèche vers le haut pour indiquer la fermeture de la description
        } else {
            productDescription.style.display = "none"; // Cache la description si elle est visible
            button.innerHTML = "&#x25BC;"; // Flèche vers le bas pour indiquer l'ouverture de la description
        }
    }

    // Filtrer initialement pour afficher tous les produits
    filterProducts('all');

    // Attache les fonctions filterProducts et toggleDescription à window pour les rendre accessibles globalement
    window.filterProducts = filterProducts;
    window.toggleDescription = toggleDescription;

    // Redirection vers la page de contact avec pré-remplissage des champs
    window.buyProduct = function(productName) {
        // Construit l'URL avec les paramètres nécessaires
        const url = "/contact.php?sujet=Demande d'ordinateur&message=" + encodeURIComponent("Je veux acheter ce PC: " + productName);
        
        // Redirige vers la page de contact
        window.location.href = url;

        // Attend 500 ms pour s'assurer que la page est chargée et que le défilement est possible
        setTimeout(function() {
            // Fait défiler jusqu'au formulaire de contact de manière fluide
            const contactForm = document.querySelector('.contact-form');
            contactForm.scrollIntoView({ behavior: 'smooth' });
        }, 500);
    };
});
