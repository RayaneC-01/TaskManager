<?php
// Inclure le fichier de connexion à la base de données
require 'connexion.php';

// Vérifier si l'ID de la tâche a été envoyé via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Récupérer l'ID de la tâche
    $id = $_POST['id'];

    try {
        // Préparer la requête pour marquer la tâche comme terminée
        $stmt = $conn->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);

        // Exécuter la requête
        $stmt->execute();

        // Rediriger l'utilisateur vers la page d'accueil
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Si l'ID de la tâche n'a pas été envoyé, rediriger l'utilisateur vers une autre page
    header('Location: error.php');
    exit;
}
?>