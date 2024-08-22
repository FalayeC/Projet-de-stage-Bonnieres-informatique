<?php
 session_start();
include($_SERVER["DOCUMENT_ROOT"]."../_bo/_blocks/doctype.php");
?>

<div class="wrapper">
    <div class="sidebar">
        <h2>Bonnière informatique</h2>
        <ul>
            <li><a href="../_views/Page-Accueil.php"><i class="fas fa-home"></i>Page accueil</a></li>
            <li><a href="../_views/Pc-portable.php"><i class="fas fa-laptop"></i>Page pc-portable</a></li>
            <li><a href="../_views/Vitre-telephone.php"><i class="fas fa-phone"></i>Page vitre téléphone</a></li>
            <?php if(isset($_SESSION['auth']) && $_SESSION['auth']['id_role'] != '2'): ?>
                <li><a href="../_views/AddUser.php"><i class="fas fa-user"></i>Ajouter un modérateur</a></li>
            <?php endif; ?>

            <li>
                <a href="../_functions/logout.php">
                    <span class="text">Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>
</div>
