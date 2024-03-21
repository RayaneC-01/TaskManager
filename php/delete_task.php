<?php
require_once 'connection_database.php';

//Fichier pour supprimer une tache.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['id'])) {
    $id = $_POST['id'];
    try {
        // Préparer la requête de suppression
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id=:id");
        $stmt->bindParam(':id', $id);

        // Exécuter la requête
        $stmt->execute();

        // Rediriger vers la page d'accueil si la tache est correctement supprimée
        header("Location: Index.php");
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>