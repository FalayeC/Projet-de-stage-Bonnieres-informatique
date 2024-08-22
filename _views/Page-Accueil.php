<?php

// Inclusion des fichiers nécessaires
include($_SERVER["DOCUMENT_ROOT"] . "/_bo/_blocks/doctype.php");
include($_SERVER["DOCUMENT_ROOT"] . "/_bo/_blocks/menu.php");
include($_SERVER["DOCUMENT_ROOT"] . "/host.php");

// Inclure l'autoloader de Composer
require __DIR__ . '/../App/Autoloader.php';
\App\Autoloader::register();

use App\Models\UserModel;

// Instanciation du modèle UserModel
$userModel = new UserModel();

// Initialisation des variables d'action et d'ID
$action = $_GET['action'] ?? 'list_imgs';
$id = $_GET['id'] ?? null;

// Récupération des horaires et des images d'accueil depuis le modèle UserModel
$horaires = $userModel->findAllHoraires();
$images = $userModel->findAllAccueilImages();

// Traitement des différentes actions
if ($action == 'list_imgs') {
    ?>

<div class="article-list">
    <h1>Modifier mes images d'accueil</h1>

    <?php if ($images): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="table-header">
                        <th>#</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($images as $image): ?>
                        <tr>
                            <td><?php echo $image->id_accueil; ?></td>
                            <td><img src="../_imgs/_accueil/<?php echo $image->accueil_image; ?>" alt="Image" class="img-thumbnail"></td>
                            <td>
                                <a href="?action=insert_img&id=<?php echo $image->id_accueil; ?>" class="btn btn-warning">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Aucune image trouvée.</p>
    <?php endif; ?>

    <h1>Modifier mes horaires</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr class="table-header">
                    <th>#</th>
                    <th>Horaire</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $horaire): ?>
                    <tr>
                        <td><?php echo $horaire->id_horaire; ?></td>
                        <td><?php echo $horaire->horaire_description; ?></td>
                        <td>
                            <a href="?action=insert_horaire&id=<?php echo $horaire->id_horaire; ?>" class="btn btn-warning">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

    <?php
} elseif ($action == 'insert_img') {
    // Récupération de l'image spécifique à modifier
    $image = $userModel->findAccueilImage($id);

    if ($image) {
        if (isset($_POST['add_img'])) {
            $img = $_FILES['accueil_image']['tmp_name'];
            $error = $_FILES['accueil_image']['error'];
            $verif = $_FILES['accueil_image']['size'];
            $type = $_FILES['accueil_image']['type'];
            $return = explode("/", $type);
            $ext = $return[1];

            $imgName = $id . '.' . $ext;

            if ($verif) {
                if ($error != 1) {
                    move_uploaded_file($img, '../_imgs/_accueil/' . $imgName);

                    $userModel->updateAccueilImage($id, $imgName);

                    $_SESSION['flash']['success'] = "L'image a bien été modifiée";

                    echo '<script language="Javascript">document.location.replace("?action=list_imgs");</script>';
                    exit;
                } else {
                    $_SESSION['flash']['error'] = "Une erreur est survenue";
                }
            } else {
                $_SESSION['flash']['danger'] = "Le champ ne doit pas être vide";

                echo '<script language="Javascript">document.location.replace("?action=insert_img&id=' . $id . '");</script>';
                exit;
            }
        }
        ?>

        <div class="edit-article">
            <h1>Modifier l'image d'accueil</h1>
            <form action="?action=insert_img&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="accueil_image">Image actuelle:</label>
                    <div>
                        <img src="../_imgs/_accueil/<?php echo $image->accueil_image; ?>" alt="Image actuelle" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                    <label for="accueil_image">Nouvelle image:</label>
                    <input type="file" class="form-control" id="accueil_image" name="accueil_image">
                </div>
                <button type="submit" class="btn btn-warning" name="add_img">Modifier</button>
            </form>
        </div>

        <?php
    }
} elseif ($action == 'insert_horaire') {
    // Récupération de l'horaire spécifique à modifier
    $horaire = $userModel->findHoraire($id);

    if ($horaire) {
        if (isset($_POST['update_horaire'])) {
            $description = $_POST['horaire_description'];

            if ($description) {
                $userModel->updateHoraireDescription($id, $description);

                $_SESSION['flash']['success'] = "L'horaire a bien été modifié";

                echo '<script language="Javascript">document.location.replace("?action=list_imgs");</script>';
                exit;
            } else {
                $_SESSION['flash']['danger'] = "Le champ ne doit pas être vide";

                echo '<script language="Javascript">document.location.replace("?action=insert_horaire&id=' . $id . '");</script>';
                exit;
            }
        }
        ?>

        <div class="edit-article">
            <h1>Modifier l'horaire</h1>
            <form action="?action=insert_horaire&id=<?php echo $id; ?>" method="post">
                <div class="form-group">
                    <label for="horaire_description">Description:</label>
                    <input type="text" class="form-control" id="horaire_description" name="horaire_description" value="<?php echo $horaire->horaire_description; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="update_horaire">Modifier</button>
            </form>
        </div>

        <?php
    }
}
?>