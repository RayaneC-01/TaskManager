<?php
// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
require_once '../config/connexion_database.php';

// Vérifier si l'ID de la tâche a été envoyé via POST et s'il est valide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['id']) && is_numeric($_POST['id'])) {
    // Récupérer l'ID de la tâche
    $id = $_POST['id'];

    try {
        // Vérifier si l'utilisateur a le droit de modifier cette tâche (ajoutez votre logique ici)

        // Récupérer l'état actuel de la tâche
        $stmt = $conn->prepare("SELECT completed FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $task = $stmt->fetch();

        if ($task) {
            // Basculer entre terminé et non terminé
            $completed = $task['completed'] ? 0 : 1;

            // Mettre à jour l'état de la tâche dans la base de données
            $stmt = $conn->prepare("UPDATE tasks SET completed = :completed WHERE id = :id");
            $stmt->bindParam(':completed', $completed);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Stocker un message de succès dans la session
            $_SESSION['success_message'] = 'L\'état de la tâche a été mis à jour avec succès.';

            // Rediriger l'utilisateur vers la page d'accueil
            header('Location: accueil.php');
            exit;
        } else {
            // La tâche avec cet ID n'existe pas, stocker un message d'erreur dans la session
            $_SESSION['error_message'] = 'La tâche avec cet ID n\'existe pas.';

            // Rediriger l'utilisateur vers une autre page
            header('Location: error.php');
            exit;
        }
    } catch (PDOException $e) {
        // En cas d'erreur, stocker un message d'erreur dans la session
        $_SESSION['error_message'] = 'Une erreur est survenue : ' . $e->getMessage();

        // Rediriger l'utilisateur vers une autre page
        header('Location: error.php');
        exit;
    }
} else {
    // Si l'ID de la tâche n'a pas été envoyé ou s'il est invalide, rediriger l'utilisateur avec un message d'erreur
    $_SESSION['error_message'] = 'ID de tâche invalide.';

    // Rediriger l'utilisateur vers une autre page
    header('Location: error.php');
    exit;
}
?>