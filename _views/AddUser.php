<?php
// Inclusion des fichiers nécessaires
ob_start(); // Commence la mise en tampon de sortie
include($_SERVER["DOCUMENT_ROOT"] . "/_bo/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'].'../_bo/_blocks/menu.php');

// Inclure l'autoloader de Composer
require __DIR__ . '/../App/Autoloader.php';
\App\Autoloader::register();

use App\Models\UserModel;

// Instanciation du modèle UserModel
$userModel = new UserModel();

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'select_user':
            if (isset($_GET['id'])) {
                $user = $userModel->find($_GET['id']);
                ?>
                <div class="Contain-Center">
                    <h1>Profil de <?php echo htmlspecialchars($user['user_surname'] . ' ' . $user['user_name']); ?></h1>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td><?php echo htmlspecialchars($user['id_user']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Rôle</th>
                                <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Civilité</th>
                                <td><?php echo htmlspecialchars($user['civility_name']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td><?php echo htmlspecialchars($user['user_email']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            break;

        case 'update_user':
            if (isset($_GET['id'])) {
                $user = $userModel->find($_GET['id']);
                $civilityOptions = $userModel->getCivility();
                $roleOptions = $userModel->getRoles();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $userData = [
                        'user_name' => $_POST['user_name'],
                        'user_surname' => $_POST['user_surname'],
                        'user_email' => $_POST['user_email'],
                        'id_civility' => $_POST['id_civility'],
                        'id_role' => $_POST['id_role'],
                    ];
                    if (!empty($_POST['user_password']) && $_POST['user_password'] === $_POST['conf_pwd']) {
                        $userData['user_password'] = password_hash($_POST['user_password'], PASSWORD_BCRYPT);
                    }
                    $userModel->update($_GET['id'], $userData);
                    header('Location: ?action=list_users');
                    exit;
                }
                ?>
                <div class="Contain-Center">
                    <h1>Mise à jour des informations de l'utilisateur</h1>
                    <form action="?action=update_user&id=<?php echo htmlspecialchars($_GET['id']); ?>" method="POST">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_surname" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="user_surname" name="user_surname" value="<?php echo htmlspecialchars($user['user_surname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="user_password" name="user_password">
                        </div>
                        <div class="mb-3">
                            <label for="conf_pwd" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="conf_pwd" name="conf_pwd">
                        </div>
                        <div class="mb-3">
                            <label for="id_civility" class="form-label">Civilité</label>
                            <select class="form-control" id="id_civility" name="id_civility" required>
                                <?php foreach ($civilityOptions as $civility) : ?>
                                    <option value="<?php echo htmlspecialchars($civility['id_civility']); ?>" <?php echo ($civility['id_civility'] === $user['id_civility']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($civility['civility_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_role" class="form-label">Rôle</label>
                            <select class="form-control" id="id_role" name="id_role" required>
                                <?php foreach ($roleOptions as $role) : ?>
                                    <option value="<?php echo htmlspecialchars($role['id_role']); ?>" <?php echo ($role['id_role'] === $user['id_role']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($role['role_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
                <?php
            }
            break;

        case 'delete_user':
            if (isset($_GET['id'])) {
                $userModel->delete($_GET['id']);
                header('Location: ?action=list_users');
                exit;
            }
            break;

        case 'add_user':
            $civilityOptions = $userModel->getCivility();
            $roleOptions = $userModel->getRoles();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userData = [
                    'user_name' => $_POST['user_name'],
                    'user_surname' => $_POST['user_surname'],
                    'user_email' => $_POST['user_email'],
                    'id_civility' => $_POST['id_civility'],
                    'id_role' => $_POST['id_role'],
                    'user_password' => password_hash($_POST['user_password'], PASSWORD_BCRYPT)
                ];
                $userModel->create($userData);
                header('Location: ?action=list_users');
                exit;
            }
            ?>
            <div class="Contain-Center">
                <h1>Ajouter un nouvel utilisateur</h1>
                <form action="?action=add_user" method="POST">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_surname" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="user_surname" name="user_surname" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="user_password" name="user_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="conf_pwd" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="conf_pwd" name="conf_pwd" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_civility" class="form-label">Civilité</label>
                        <select class="form-control" id="id_civility" name="id_civility" required>
                            <?php foreach ($civilityOptions as $civility) : ?>
                                <option value="<?php echo htmlspecialchars($civility['id_civility']); ?>">
                                    <?php echo htmlspecialchars($civility['civility_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_role" class="form-label">Rôle</label>
                        <select class="form-control" id="id_role" name="id_role" required>
                            <?php foreach ($roleOptions as $role) : ?>
                                <option value="<?php echo htmlspecialchars($role['id_role']); ?>">
                                    <?php echo htmlspecialchars($role['role_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Ajouter</button>
                </form>
            </div>
            <?php
            break;

        case 'list_users':
        default:
            // Liste des utilisateurs par défaut
            $users = $userModel->findAll();
            ?>
            <div class="Contain-Center">
                <h1>Liste des utilisateurs</h1>
                <!-- Bouton d'ajout d'utilisateur -->
                <div class="flexRow flexEnd">
                    <a href="?action=add_user" class="btn btn-warning">Ajouter un utilisateur</a>
                </div>
                <hr>
                <!-- Tableau affichant la liste des utilisateurs -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Rôle</th>
                            <th scope="col">Civilité</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <th scope="row"><?php echo htmlspecialchars($user['id_user']); ?></th>
                                <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['civility_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_surname']); ?></td>
                                <td>
                                    <div class="flexRow">
                                        <a href="?action=select_user&id=<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-warning">Afficher</a>
                                        <a href="?action=update_user&id=<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-warning">Mettre à jour</a>
                                        <a href="?action=delete_user&id=<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-danger">Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
            break;
    }
} else {
    // Action par défaut : liste des utilisateurs
    $users = $userModel->findAll();
    ?>
    <div class="Contain-Center">
        <h1>Liste des utilisateurs</h1>
        <!-- Bouton d'ajout d'utilisateur -->
        <div class="flexRow flexEnd">
            <a href="?action=add_user" class="btn btn-warning">Ajouter un utilisateur</a>
        </div>
        <hr>
        <!-- Tableau affichant la liste des utilisateurs -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Civilité</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($user['id_user']); ?></th>
                        <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['civility_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['user_surname']); ?></td>
                        <td>
                            <div class="flexRow">
                                <a href="?action=select_user&id=<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-warning">Afficher</a>
                                <a href="?action=update_user&id=<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-warning">Mettre à jour</a>
                                <a href="?action=delete_user&id=<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-danger">Supprimer</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    
}
?>
