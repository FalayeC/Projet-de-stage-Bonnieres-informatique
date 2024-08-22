$(document).ready(function(){
    // Gestion de l'ouverture et de la fermeture des sections de l'accordéon
    $('#accordion .btn-link').click(function(){
        var target = $(this).data('target');
        
        // Si la section est déjà ouverte, la fermer
        if($(target).hasClass('show')) {
            $(target).collapse('hide');
        } else {
            // Fermer toutes les sections ouvertes
            $('#accordion .collapse').collapse('hide');
            // Ouvrir la section ciblée
            $(target).collapse('show');
        }
    });
});