<?php
include($_SERVER["DOCUMENT_ROOT"] . "/_bo/_blocks/doctype.php");
include($_SERVER['DOCUMENT_ROOT'] . '/_bo/_blocks/menu.php');
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

// Fetch HP models
$selectHpModels = $db->prepare('SELECT * FROM bi_hp');
$selectHpModels->execute();

// Fetch Lenovo models
$selectLenovoModels = $db->prepare('SELECT * FROM bi_lenovo');
$selectLenovoModels->execute();

// Update process for HP
$isUpdateHp = isset($_GET['action']) && $_GET['action'] == 'update_hp';
if ($isUpdateHp) {
    $id = $_GET['id'];
    $fetchHpModel = $db->prepare('SELECT * FROM bi_hp WHERE id_hp = ?');
    $fetchHpModel->execute([$id]);
    $hp = $fetchHpModel->fetch(PDO::FETCH_OBJ);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_hp'])) {
    $dataHp = [
        $_POST['hp_modele'],
        $_POST['hp_grade'],
        $_POST['hp_processeur'],
        $_POST['hp_memoire'],
        $_POST['hp_disque_dur'],
        $_POST['hp_ecran'],
        $_POST['hp_clavier'],
        $_POST['hp_connectique'],
        $_POST['hp_sorties'],
        $_POST['hp_systeme_exploitation'],
        $_POST['hp_batterie'],
        $_POST['hp_prix'],
        $_POST['hp_livraison'],
        $_POST['hp_garantie'],
        $_POST['hp_carte_graphique'],
        $_POST['bi_etat'],
        $_POST['bi_port_usb'],
        $_POST['hp_img'],
        $_GET['id']
    ];

    $updateHp = $db->prepare("UPDATE bi_hp SET 
        hp_modele = ?, 
        hp_grade = ?, 
        hp_processeur = ?, 
        hp_memoire = ?, 
        hp_disque_dur = ?, 
        hp_ecran = ?, 
        hp_clavier = ?, 
        hp_connectique = ?, 
        hp_sorties = ?, 
        hp_systeme_exploitation = ?, 
        hp_batterie = ?, 
        hp_prix = ?, 
        hp_livraison = ?, 
        hp_garantie = ?, 
        hp_carte_graphique = ?, 
        bi_etat = ?, 
        bi_port_usb = ?, 
        hp_img = ? 
        WHERE id_hp = ?");
    
    $updateHp->execute($dataHp);

    $_SESSION['flash']['success'] = "Les informations du modèle HP ont été mises à jour";
    echo '<script>document.location.replace("?action=Pc-portable.php");</script>';
    exit;
}

// Update process for Lenovo
$isUpdateLenovo = isset($_GET['action']) && $_GET['action'] == 'update_lenovo';
if ($isUpdateLenovo) {
    $id = $_GET['id'];
    $fetchLenovoModel = $db->prepare('SELECT * FROM bi_lenovo WHERE id_lenovo = ?');
    $fetchLenovoModel->execute([$id]);
    $lenovo = $fetchLenovoModel->fetch(PDO::FETCH_OBJ);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_lenovo'])) {
    $dataLenovo = [
        $_POST['lenovo_modele'],
        $_POST['lenovo_grade'],
        $_POST['lenovo_processeur'],
        $_POST['lenovo_memoire'],
        $_POST['lenovo_disque_dur'],
        $_POST['lenovo_ecran'],
        $_POST['lenovo_clavier'],
        $_POST['lenovo_connectique'],
        $_POST['lenovo_sorties'],
        $_POST['lenovo_systeme_exploitation'],
        $_POST['lenovo_carte_graphique'],
        $_POST['lenovo_batterie'],
        $_POST['lenovo_prix'],
        $_POST['lenovo_livraison'],
        $_POST['lenovo_garantie'],
        $_POST['lenovo_img'],
        $_GET['id']
    ];

    $updateLenovo = $db->prepare("UPDATE bi_lenovo SET 
        lenovo_modele = ?, 
        lenovo_grade = ?, 
        lenovo_processeur = ?, 
        lenovo_memoire = ?, 
        lenovo_disque_dur = ?, 
        lenovo_ecran = ?, 
        lenovo_clavier = ?, 
        lenovo_connectique = ?, 
        lenovo_sorties = ?, 
        lenovo_systeme_exploitation = ?, 
        lenovo_carte_graphique = ?, 
        lenovo_batterie = ?, 
        lenovo_prix = ?, 
        lenovo_livraison = ?, 
        lenovo_garantie = ?, 
        lenovo_img = ?
        WHERE id_lenovo = ?");
    
    $updateLenovo->execute($dataLenovo);

    $_SESSION['flash']['success'] = "Les informations du modèle Lenovo ont été mises à jour";
    echo '<script>document.location.replace("?action=Pc-portable.php");</script>';
    exit;
}
?>

<?php if (isset($_SESSION['flash']['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['flash']['success']; unset($_SESSION['flash']['success']); ?>
    </div>
<?php endif; ?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <?php if (!$isUpdateHp && !$isUpdateLenovo): ?>
                <div class="col-12">
                    <h1 class="text-center">Liste des modèles et prix de HP</h1>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Modèle</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($hp = $selectHpModels->fetch(PDO::FETCH_OBJ)): ?>
                                <tr>
                                    <td><?php echo $hp->hp_modele; ?></td>
                                    <td><?php echo $hp->hp_prix; ?> €</td>
                                    <td>
                                        <a href="?action=update_hp&id=<?php echo $hp->id_hp; ?>" class="btn btn-warning">Mettre à jour</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-5">
                    <h1 class="text-center">Liste des modèles et prix de Lenovo</h1>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Modèle</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($lenovo = $selectLenovoModels->fetch(PDO::FETCH_OBJ)): ?>
                                <tr>
                                    <td><?php echo $lenovo->lenovo_modele; ?></td>
                                    <td><?php echo $lenovo->lenovo_prix; ?> €</td>
                                    <td>
                                        <a href="?action=update_lenovo&id=<?php echo $lenovo->id_lenovo; ?>" class="btn btn-warning">Mettre à jour</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($isUpdateHp): ?>
                <div class="col-12">
                    <form method="post" action="?action=update_hp&id=<?php echo $_GET['id']; ?>">
                        <h1 class="text-center">Mettre à jour le modèle HP</h1>
                        <div class="mb-3">
                            <label for="hp_modele" class="form-label">Modèle</label>
                            <input type="text" class="form-control" id="hp_modele" name="hp_modele" value="<?php echo isset($hp->hp_modele) ? $hp->hp_modele : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_grade" class="form-label">Grade</label>
                            <input type="text" class="form-control" id="hp_grade" name="hp_grade" value="<?php echo isset($hp->hp_grade) ? $hp->hp_grade : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_processeur" class="form-label">Processeur</label>
                            <input type="text" class="form-control" id="hp_processeur" name="hp_processeur" value="<?php echo isset($hp->hp_processeur) ? $hp->hp_processeur : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_memoire" class="form-label">Mémoire</label>
                            <input type="text" class="form-control" id="hp_memoire" name="hp_memoire" value="<?php echo isset($hp->hp_memoire) ? $hp->hp_memoire : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_disque_dur" class="form-label">Disque dur</label>
                            <input type="text" class="form-control" id="hp_disque_dur" name="hp_disque_dur" value="<?php echo isset($hp->hp_disque_dur) ? $hp->hp_disque_dur : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_ecran" class="form-label">Écran</label>
                            <input type="text" class="form-control" id="hp_ecran" name="hp_ecran" value="<?php echo isset($hp->hp_ecran) ? $hp->hp_ecran : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_clavier" class="form-label">Clavier</label>
                            <input type="text" class="form-control" id="hp_clavier" name="hp_clavier" value="<?php echo isset($hp->hp_clavier) ? $hp->hp_clavier : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_connectique" class="form-label">Connectique</label>
                            <input type="text" class="form-control" id="hp_connectique" name="hp_connectique" value="<?php echo isset($hp->hp_connectique) ? $hp->hp_connectique : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_sorties" class="form-label">Sorties</label>
                            <input type="text" class="form-control" id="hp_sorties" name="hp_sorties" value="<?php echo isset($hp->hp_sorties) ? $hp->hp_sorties : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_systeme_exploitation" class="form-label">Système d'exploitation</label>
                            <input type="text" class="form-control" id="hp_systeme_exploitation" name="hp_systeme_exploitation" value="<?php echo isset($hp->hp_systeme_exploitation) ? $hp->hp_systeme_exploitation : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_batterie" class="form-label">Batterie</label>
                            <input type="text" class="form-control" id="hp_batterie" name="hp_batterie" value="<?php echo isset($hp->hp_batterie) ? $hp->hp_batterie : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_prix" class="form-label">Prix</label>
                            <input type="text" class="form-control" id="hp_prix" name="hp_prix" value="<?php echo isset($hp->hp_prix) ? $hp->hp_prix : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_livraison" class="form-label">Livraison</label>
                            <input type="text" class="form-control" id="hp_livraison" name="hp_livraison" value="<?php echo isset($hp->hp_livraison) ? $hp->hp_livraison : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_garantie" class="form-label">Garantie</label>
                            <input type="text" class="form-control" id="hp_garantie" name="hp_garantie" value="<?php echo isset($hp->hp_garantie) ? $hp->hp_garantie : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp_carte_graphique" class="form-label">Carte Graphique</label>
                            <input type="text" class="form-control" id="hp_carte_graphique" name="hp_carte_graphique" value="<?php echo isset($hp->hp_carte_graphique) ? $hp->hp_carte_graphique : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="bi_etat" class="form-label">État</label>
                            <input type="text" class="form-control" id="bi_etat" name="bi_etat" value="<?php echo isset($hp->bi_etat) ? $hp->bi_etat : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="bi_port_usb" class="form-label">Port USB</label>
                            <input type="text" class="form-control" id="bi_port_usb" name="bi_port_usb" value="<?php echo isset($hp->bi_port_usb) ? $hp->bi_port_usb : ''; ?>" required>
                        </div>
                        <button type="submit" name="update_hp" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($isUpdateLenovo): ?>
                <div class="col-12">
                    <form method="post" action="?action=update_lenovo&id=<?php echo $_GET['id']; ?>">
                        <h1 class="text-center">Mettre à jour le modèle Lenovo</h1>
                        <div class="mb-3">
                            <label for="lenovo_modele" class="form-label">Modèle</label>
                            <input type="text" class="form-control" id="lenovo_modele" name="lenovo_modele" value="<?php echo isset($lenovo->lenovo_modele) ? $lenovo->lenovo_modele : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_grade" class="form-label">Grade</label>
                            <input type="text" class="form-control" id="lenovo_grade" name="lenovo_grade" value="<?php echo isset($lenovo->lenovo_grade) ? $lenovo->lenovo_grade : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_processeur" class="form-label">Processeur</label>
                            <input type="text" class="form-control" id="lenovo_processeur" name="lenovo_processeur" value="<?php echo isset($lenovo->lenovo_processeur) ? $lenovo->lenovo_processeur : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_memoire" class="form-label">Mémoire</label>
                            <input type="text" class="form-control" id="lenovo_memoire" name="lenovo_memoire" value="<?php echo isset($lenovo->lenovo_memoire) ? $lenovo->lenovo_memoire : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_disque_dur" class="form-label">Disque dur</label>
                            <input type="text" class="form-control" id="lenovo_disque_dur" name="lenovo_disque_dur" value="<?php echo isset($lenovo->lenovo_disque_dur) ? $lenovo->lenovo_disque_dur : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_ecran" class="form-label">Écran</label>
                            <input type="text" class="form-control" id="lenovo_ecran" name="lenovo_ecran" value="<?php echo isset($lenovo->lenovo_ecran) ? $lenovo->lenovo_ecran : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_clavier" class="form-label">Clavier</label>
                            <input type="text" class="form-control" id="lenovo_clavier" name="lenovo_clavier" value="<?php echo isset($lenovo->lenovo_clavier) ? $lenovo->lenovo_clavier : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_connectique" class="form-label">Connectique</label>
                            <input type="text" class="form-control" id="lenovo_connectique" name="lenovo_connectique" value="<?php echo isset($lenovo->lenovo_connectique) ? $lenovo->lenovo_connectique : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_sorties" class="form-label">Sorties</label>
                            <input type="text" class="form-control" id="lenovo_sorties" name="lenovo_sorties" value="<?php echo isset($lenovo->lenovo_sorties) ? $lenovo->lenovo_sorties : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_systeme_exploitation" class="form-label">Système d'exploitation</label>
                            <input type="text" class="form-control" id="lenovo_systeme_exploitation" name="lenovo_systeme_exploitation" value="<?php echo isset($lenovo->lenovo_systeme_exploitation) ? $lenovo->lenovo_systeme_exploitation : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_carte_graphique" class="form-label">Carte Graphique</label>
                            <input type="text" class="form-control" id="lenovo_carte_graphique" name="lenovo_carte_graphique" value="<?php echo isset($lenovo->lenovo_carte_graphique) ? $lenovo->lenovo_carte_graphique : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_batterie" class="form-label">Batterie</label>
                            <input type="text" class="form-control" id="lenovo_batterie" name="lenovo_batterie" value="<?php echo isset($lenovo->lenovo_batterie) ? $lenovo->lenovo_batterie : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_prix" class="form-label">Prix</label>
                            <input type="text" class="form-control" id="lenovo_prix" name="lenovo_prix" value="<?php echo isset($lenovo->lenovo_prix) ? $lenovo->lenovo_prix : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_livraison" class="form-label">Livraison</label>
                            <input type="text" class="form-control" id="lenovo_livraison" name="lenovo_livraison" value="<?php echo isset($lenovo->lenovo_livraison) ? $lenovo->lenovo_livraison : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lenovo_garantie" class="form-label">Garantie</label>
                            <input type="text" class="form-control" id="lenovo_garantie" name="lenovo_garantie" value="<?php echo isset($lenovo->lenovo_garantie) ? $lenovo->lenovo_garantie : ''; ?>" required>
                        </div>
                        <button type="submit" name="update_lenovo" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

