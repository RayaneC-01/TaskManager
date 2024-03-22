<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset ($_SESSION['utilisateur_connecte'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: sign_in.php');
    exit;
}

// Récupérer l'identifiant de l'utilisateur connecté
$user_id = $_SESSION['utilisateur_connecte'];

require_once 'connection_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['id'], $_POST['title'], $_POST['priority'])) {
    // Validation et nettoyage des données
    $id = $_POST['id'];
    $titre = htmlspecialchars(trim($_POST['title']));
    $priority = intval($_POST['priority']);

    // Valider la priorité
    if ($priority < 1 || $priority > 5) {
        $_SESSION['message_error'] = "Erreur : La priorité doit être un entier entre 1 et 5.";
        header("Location: ../Index.php");
        exit;
    }

    // Traitement de la date en fonction de l'option choisie
    switch ($_POST['due_date']) {
        case 'today':
            $due_date = date('Y-m-d');
            break;
        case 'tomorrow':
            $due_date = date('Y-m-d', strtotime('+1 day'));
            break;
        case 'next_week':
            $due_date = date('Y-m-d', strtotime('+1 week'));
            break;
        case 'in_2_week':
            $due_date = date('Y-m-d', strtotime('+2 week'));
            break;
        case 'choose_date':
            // Vérifier si la date personnalisée est fournie et dans un format valide
            if (isset ($_POST['custom_due_date']) && strtotime($_POST['custom_due_date']) !== false) {
                $due_date = $_POST['custom_due_date'];
            } else {
                $_SESSION['message_error'] = "Erreur : Une date d'échéance valide est requise.";
                header("Location: ../Index.php");
                exit;
            }
            break;
        default:
            $_SESSION['message_error'] = "Erreur : Veuillez choisir une date.";
            header("Location: ../Index.php");
            exit;
    }

    try {
        // Mettre à jour la tâche dans la base de données avec la priorité spécifiée
        $stmt = $conn->prepare("UPDATE tasks SET title = :title, due_date = :due_date, priority = :priority WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $titre);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':priority', $priority);
        $stmt->execute();

        // Redirection vers la page d'accueil avec un message de succès
        $_SESSION['message_success'] = "La tâche a été modifiée avec succès.";
        header("Location: ../Index.php");
        exit; // Assurez-vous d'ajouter exit après la redirection pour arrêter l'exécution du script
    } catch (PDOException $e) {
        // En cas d'erreur lors de la mise à jour dans la base de données
        $_SESSION['message_error'] = "Erreur lors de la modification de la tâche : " . $e->getMessage();
        header("Location: ../Index.php");
        exit;
    }
} else {
    // Si tous les champs requis ne sont pas soumis, redirigez avec un message d'erreur
    $_SESSION['message_error'] = "Erreur : Veuillez fournir les données nécessaires pour modifier la tâche.";
    header("Location: ../Index.php");
    exit;
}
?>