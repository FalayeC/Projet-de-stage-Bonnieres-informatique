<?php 
    include($_SERVER['DOCUMENT_ROOT'].'../_blocks/doctype.php');
    session_start();
    unset($_SESSION['auth']);
    $_SESSION['flash']['success'] = "vous êtes maintenant déconnecté.";
    echo"<script language='javascript'>
    document.location.replace('../../Accueil.php')
    </script>";
?>
