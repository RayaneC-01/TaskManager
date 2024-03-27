<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management_app";

try {
    // Créer une nouvelle connexion PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurer le mode d'erreur PDO pour générer des exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_SESSION['message_success'] = "Connexion réussie à la Base de donnée. ";

    // Paramétrer l'encodage des caractères
    $conn->exec("SET NAMES utf8");
} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher un message d'erreur
    $_SESSION['message_error'] = "La connexion a échoué: " . $e->getMessage();
}

?>