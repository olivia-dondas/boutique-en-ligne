<?php
session_start();

// Détruire toutes les sessions
session_unset();

// Détruire la session
session_destroy();

// Retour à la connexion
header('Location: ../public/login.php');
exit();
?>