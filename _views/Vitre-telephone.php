<?php
include($_SERVER["DOCUMENT_ROOT"] . "../_bo/_blocks/doctype.php");
include($_SERVER["DOCUMENT_ROOT"] . "/_bo/_blocks/menu.php");
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

// Inclure l'autoloader de Composer
require __DIR__ . '/../App/Autoloader.php';
\App\Autoloader::register();

use App\Models\UserModel;

// Créer une instance de UserModel
$userModel = new UserModel();

// Vérifier l'action et la méthode
$isUpdateIphone = isset($_GET['action']) && $_GET['action'] == 'update_iphone';
$isUpdateSamsung = isset($_GET['action']) && $_GET['action'] == 'update_samsung';

// Récupérer l'ID depuis la requête GET si disponible
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Traitement des formulaires de mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($id !== null) {
        if (isset($_POST['update_iphone'])) {
            $modele = $_POST['iphone_modele'];
            $prix = $_POST['iphone_prix'];
            $userModel->updateIPhone($id, $modele, $prix);
            $_SESSION['flash']['success'] = "Les informations de l'iPhone ont été mises à jour";
            header('Location: ?action=Vitre-telephone.php');
            exit;
        }

        if (isset($_POST['update_samsung'])) {
            $modele = $_POST['samsung_modele'];
            $prix = $_POST['samsung_prix'];
            $userModel->updateSamsung($id, $modele, $prix);
            $_SESSION['flash']['success'] = "Les informations de Samsung ont été mises à jour";
            header('Location: ?action=Vitre-telephone.php');
            exit;
        }
    }
}
?>

<?php if (isset($_SESSION['flash']['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['flash']['success']; unset($_SESSION['flash']['success']); ?>
    </div>
<?php endif; ?>

<div class="Contain-Center" <?php if ($isUpdateIphone || $isUpdateSamsung) echo 'style="display:none;"'; ?>>
    <h1>Liste des modèles et prix de smartphones</h1>

    <hr>

    <div id="accordion">
        <!-- Accordéon pour les iPhones -->
        <div class="card">
            <div class="card-header" id="iphoneHeading">
                <h5 class="mb-0">
                    <button class="btn btn-warning" data-toggle="collapse" data-target="#collapseiPhone" aria-expanded="true" aria-controls="collapseiPhone">
                        iPhones
                    </button>
                </h5>
            </div>

            <div id="collapseiPhone" class="collapse show" aria-labelledby="iphoneHeading" data-parent="#accordion">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Modèle</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userModel->findAllIPhoneModels() as $iphone): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($iphone->iphone_modele); ?></td>
                                    <td><?php echo htmlspecialchars($iphone->iphone_prix); ?></td>
                                    <td>
                                        <div class="flexRow">
                                            <a href="?action=update_iphone&id=<?php echo $iphone->id_iphone; ?>" class="btn btn-warning">Mettre à jour</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Accordéon pour les Samsungs -->
        <div class="card">
            <div class="card-header" id="samsungHeading">
                <h5 class="mb-0">
                    <button class="btn btn-warning" data-toggle="collapse" data-target="#collapseSamsung" aria-expanded="false" aria-controls="collapseSamsung">
                        Samsungs
                    </button>
                </h5>
            </div>

            <div id="collapseSamsung" class="collapse" aria-labelledby="samsungHeading" data-parent="#accordion">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Modèle</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userModel->findAllSamsungModels() as $samsung): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($samsung->samsung_modele); ?></td>
                                    <td><?php echo htmlspecialchars($samsung->samsung_prix); ?></td>
                                    <td>
                                        <div class="flexRow">
                                            <a href="?action=update_samsung&id=<?php echo $samsung->id_samsung; ?>" class="btn btn-warning">Mettre à jour</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($isUpdateIphone || $isUpdateSamsung): ?>
    <?php
    // Récupérer les données de l'élément à mettre à jour
    $item = null;
    if ($id !== null) {
        if ($isUpdateIphone) {
            $item = $userModel->findIPhoneById($id);
        } elseif ($isUpdateSamsung) {
            $item = $userModel->findSamsungById($id);
        }
    }
    ?>
    <div class="container">
        <h2>Mettre à jour les informations</h2>
        <form method="post">
            <?php if ($isUpdateIphone && $item): ?>
                <div class="form-group">
                    <label for="iphone_modele">Modèle iPhone</label>
                    <input type="text" id="iphone_modele" name="iphone_modele" class="form-control" value="<?php echo htmlspecialchars($item->iphone_modele); ?>" required>
                </div>
                <div class="form-group">
                    <label for="iphone_prix">Prix</label>
                    <input type="number" id="iphone_prix" name="iphone_prix" class="form-control" value="<?php echo htmlspecialchars($item->iphone_prix); ?>" required>
                </div>
                <button type="submit" name="update_iphone" class="btn btn-primary">Mettre à jour</button>
            <?php elseif ($isUpdateSamsung && $item): ?>
                <div class="form-group">
                    <label for="samsung_modele">Modèle Samsung</label>
                    <input type="text" id="samsung_modele" name="samsung_modele" class="form-control" value="<?php echo htmlspecialchars($item->samsung_modele); ?>" required>
                </div>
                <div class="form-group">
                    <label for="samsung_prix">Prix</label>
                    <input type="number" id="samsung_prix" name="samsung_prix" class="form-control" value="<?php echo htmlspecialchars($item->samsung_prix); ?>" required>
                </div>
                <button type="submit" name="update_samsung" class="btn btn-warning">Mettre à jour</button>
            <?php endif; ?>
        </form>
    </div>
<?php endif; ?>
