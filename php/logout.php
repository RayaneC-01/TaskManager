<?php
// Démarrez la session
session_start();

// destruction données de la session 
session_destroy();

// Redirigez l'utilisateur vers la page de connexion
header('Location: php/sign_in.php');
exit;
?>