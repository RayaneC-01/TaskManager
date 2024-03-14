<?php
// Inclure le fichier de connexion à la base de données
require 'connexion_database.php';

// Vérifier si l'ID de la tâche a été envoyé via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Récupérer l'ID de la tâche
    $id = $_POST['id'];

    try {
        // Récupérer l'état actuel de la tâche
        $stmt = $conn->prepare("SELECT completed FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $task = $stmt->fetch();

        // Basculer entre terminé et non terminé
        $completed = $task['completed'] ? 0 : 1;

        // Mettre à jour l'état de la tâche dans la base de données
        $stmt = $conn->prepare("UPDATE tasks SET completed = :completed WHERE id = :id");
        $stmt->bindParam(':completed', $completed);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Rediriger l'utilisateur vers la page d'accueil
        header('Location: accueil.php');
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