<?php
require 'connexion_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Préparer la requête de suppression
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id=:id");
        $stmt->bindParam(':id', $id);

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