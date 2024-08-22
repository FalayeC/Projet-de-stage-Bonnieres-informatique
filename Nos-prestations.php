<?php include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php'); ?>

<div class="header">
    <h1>Prestations à domicile</h1>
    <p>Intervention géographique de 15 KMS</p>
</div>

<div class="map-container">
    <div class="map-ball">
    <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1CFgkNHC19vyPT-1k529pbZMl9_AX6ho&ehbc=2E312F&noprof=1" width="640" height="480"></iframe>
    </div>
</div>


<div class="prestation">
    <h2>Nos prix de devis et d'installation</h2>
    <p>- DEVIS INFORMATIQUE 20 € - </p>
    <p>ALIMENTATION 480W: 50 € AVEC MONTAGE</p>
    <p>CLAVIER ORDINATEUR PORTABLE: 49 € à 99 € AVEC MONTAGE</p>
    <p>CHARGEUR ORDINATEUR PORTABLE: 30 € à 99 € SELON MODÈLE</p>
    <p>SACOCHE OCCASION: 10 €</p>
    <p>BATTERIE ORDINATEUR PORTABLE: 39 € à 99 € SELON MODÈLE</p>
</div>

<div class="prices">
    <h2>Nos prix d'Installation</h2>
    <div class="service">
        <img src="/_imgs/_prestations/LogoWindows.png" alt="Logo Windows">
        <p>Installation Windows: 50 €</p>
    </div>
    <div class="service">
        <img src="/_imgs/_prestations/logoApple.png" alt="Logo Apple">
        <p>Installation Mac: 70 €</p>
    </div>
    <div class="service">
        <p>Récupération Données Disque Dur -100Go: 50 €</p>
    </div>
    <div class="service">
        <p>Installation Remplacement Écrans Ordinateur Portable Cassé:</p>
        <p>15.6 pouces: 120 €</p>
        <p>17.3 pouces: 150 €</p>
    </div>
</div>


<script>
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
</script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/_blocks/footer.php"); ?>