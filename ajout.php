<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $titre = $_POST['title'];

    try {
        // Préparer la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->bindParam(':title', $titre);

        // Exécuter la requête
        $stmt->execute();

        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>