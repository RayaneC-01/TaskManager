<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset ($_SESSION['identifier'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

// Récupérer l'identifiant de l'utilisateur connecté
$user_id = $_SESSION['utilisateur_connecte'];

require_once '../config/connexion_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['title'])) {
    // Validation et nettoyage du titre de la tâche
    $titre = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);

    // Vérifier si le titre est vide après le nettoyage
    if (empty ($titre)) {
        $_SESSION['message_error'] = "Erreur : Le titre de la tâche est requis.";
        header('Location: accueil.php');
        exit;
    }

    $due_date = null;
    $priority = $_POST['priority']; // Récupération de la priorité depuis le formulaire

    // priorité est un entier
    $priority = intval($priority);

    // Vérifier si l'utilisateur a choisi une date personnalisée
    if ($_POST['due_date'] === 'choose_date') {
        // Récupérer la date personnalisée à partir du champ de formulaire
        $due_date = $_POST['custom_due_date'];

        // Vérifier si aucune date n'a été sélectionnée
        if (empty ($due_date)) {
            // Afficher un message d'erreur et rediriger vers la page d'accueil
            $_SESSION['message_error'] = "Erreur : Une date d'échéance est requise.";
            header('Location: accueil.php');
            exit;
        }
    } else {
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
            default:
                // Gérer les cas d'erreur ou par défaut
                $_SESSION['message_error'] = "Veuillez choisir une date ! ";
                header('Location: accueil.php');
                exit;
        }
    }

    // Rediriger vers la page d'accueil en cas d'erreur
    if (!isset ($due_date)) {
        header('Location: accueil.php');
        exit;
    }

    try {
        // Insérer la tâche dans la base de données avec la priorité spécifiée
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, due_date, priority) VALUES (:user_id, :title, :due_date, :priority)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $titre,
            ':due_date' => $due_date,
            ':priority' => $priority
        ]);

        // Rediriger vers la page d'accueil avec un message de succès
        $_SESSION['message_success'] = "La tâche a été ajoutée avec succès.";
        header("Location: accueil.php");
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur lors de l'insertion dans la base de données
        $_SESSION['message_error'] = "Erreur lors de l'ajout de la tâche : " . $e->getMessage();
        header("Location: accueil.php");
        exit;
    }
} else {
    // Si tous les champs requis ne sont pas soumis, rediriger avec un message d'erreur
    $_SESSION['message_error'] = "Veuillez remplir tous les champs.";
    header("Location: accueil.php");
    exit;
}
?>