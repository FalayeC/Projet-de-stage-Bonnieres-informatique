<?php
// Inclusion des fichiers de structure de la page
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'].'/_blocks/menu.php');
include($_SERVER['DOCUMENT_ROOT'].'/host.php');
?>

<?php
// Sélectionner toutes les données pour les produits HP
$SelectVitreHp = $db->prepare("SELECT * FROM bi_hp");
$SelectVitreHp->execute();
$vitreHp = $SelectVitreHp->fetchAll(PDO::FETCH_OBJ);

// Sélectionner toutes les données pour les produits Lenovo
$SelectVitreLenovo = $db->prepare("SELECT * FROM bi_lenovo");
$SelectVitreLenovo->execute();
$vitreLenovo = $SelectVitreLenovo->fetchAll(PDO::FETCH_OBJ);
?>
<div class="map-container">
    <!-- Intégration de Google Maps -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2615.61147028578!2d1.5765295765059304
        !3d49.03699617135698!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6c7fc6d891033%3A0x617bc4dde5b18b56!2sBONNIERES%20INFORMATIQUE
        !5e0!3m2!1sfr!2sfr!4v1717406145948!5m2!1sfr!2sfr" 
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" alt="Google Maps"></iframe>
</div>
<!-- Section de contact -->
<div class="contact">
    <h2>Nous contacter</h2>
    <div class="contact-map">
        <!-- Informations de contact -->
        <div class="adresse">
            <ul>
                <li>Magasin d'informatique à Bonnières-sur-Seine.</li>
                <li>Téléphone : 09 80 57 91 29</li>
                <li>Adresse : 12 Rue Georges Herrewyn, 78270 Bonnières-sur-Seine.</li> 
                <li>❌ Lun fermé</li>
                <li>✔️ Mar 10h00 - 12h30, 16h00 - 19h00</li>
                <li>✔️ Mer 10h00 - 12h30, 16h00 - 19h00</li>
                <li>✔️ Jeudi 10h00 - 12h30, 16h00 - 19h00</li>
                <li>✔️ Vendredi 10h00 - 12h30, 16h00 - 19h00</li>
                <li>✔️ Samedi 10h00 - 12h30, 16h00 - 19h00</li>
                <li>❌ Dimanche fermé</li>                     
            </ul>
        </div>
    </div>
    <div class="container mt-5">
        <!-- Formulaire de contact -->
        <div class="contact-form">
            <form action="submit_form.php" method="post">
                <div class="form-row">
                    <!-- Champ de saisie pour le prénom -->
                    <div class="form-group col-md-6">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <!-- Champ de saisie pour le nom -->
                    <div class="form-group col-md-6">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="form-row">
                    <!-- Champ de saisie pour l'email -->
                    <div class="form-group col-md-6">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Champ de saisie pour le téléphone -->
                    <div class="form-group col-md-6">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                    </div>
                </div>
                <!-- Sélection du sujet de la demande -->
                <div class="form-group">
                    <label for="sujet">Sujet</label>
                    <select class="form-control" id="sujet" name="sujet">
                        <option value="devis">Demande de devis</option>
                        <option value="info">Demande d'informations</option>
                        <option value="ordinateur" selected>Demande d'ordinateur</option>
                        <option value="prestation">Demande de prestation</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <!-- Champ de saisie pour le message -->
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : ''; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>
</div>

<!-- Inclusion du pied de page -->
<?php 
include($_SERVER["DOCUMENT_ROOT"]."/_blocks/footer.php");
?>
