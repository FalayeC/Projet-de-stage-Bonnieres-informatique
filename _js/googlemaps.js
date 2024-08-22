function initMap() {
    // Centre de la carte : Bonnieres sur Seine, France
    const center = { lat: 49.036996, lng: 1.576529 };

    // Initialisation de la carte
    const map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 11, // Zoom ajusté pour bien voir le cercle de 15 km
        mapTypeId: 'roadmap'
    });

    // Dessiner un cercle avec un rayon de 15 km
    const circle = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map: map,
        center: center,
        radius: 15000 // Rayon en mètres (15 km)
    });
}