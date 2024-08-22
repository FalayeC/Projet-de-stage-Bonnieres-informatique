$(document).ready(function() {
    // Fonction pour vérifier si la section est visible
    function isElementInViewport(elem) {
        var rect = elem.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Fonction pour animer les éléments de la section text-over-image
    function animateTextOverImage() {
        $(".text-over-image h1, .text-over-image p, .text-over-image #bottom-p, .text-over-image button").each(function(index) {
            var delay = index * 200; // Décalage progressif pour chaque élément
            $(this).delay(delay).queue(function() {
                $(this).addClass('visible'); // Ajoute une classe pour l'animation CSS
            });
        });
    }

    // Déclencher l'animation lorsque la section devient visible
    $(window).scroll(function() {
        $(".text-over-image").each(function() {
            if (isElementInViewport(this)) {
                animateTextOverImage();
            }
        });
    });

    // Déclencher une fois au chargement initial si la section est déjà visible
    $(window).on('load', function() {
        $(".text-over-image").each(function() {
            if (isElementInViewport(this)) {
                animateTextOverImage();
            }
        });
    });
});