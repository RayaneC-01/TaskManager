<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset ($_SESSION['utilisateur_connecte']) || !$_SESSION['utilisateur_connecte']) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

require_once '../config/connexion_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['title'])) {
    $titre = $_POST['title'];
    $due_date = null;

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
            // Si l'utilisateur a choisi "Choisir une date", je récupère la date à partir du champ de formulaire 
            $due_date = $_POST['custom_due_date'];
            break;
        default:
            // Gérer les cas d'erreur ou par défaut
            $_SESSION['message_error'] = "Veuillez choisir une date ! ";
            break;
    }

    // Rediriger vers la page d'accueil en cas d'erreur
    if (!isset ($due_date)) {
        header('Location: accueil.php');
        exit;
    }
    try {
        // Préparer la requête d'insertion avec l'ID de l'utilisateur connecté et la date d'échéance
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, due_date) VALUES (:user_id, :title, :due_date)");
        $stmt->bindParam(':user_id', $_SESSION['utilisateur_connecte']);
        $stmt->bindParam(':title', $titre);
        $stmt->bindParam(':due_date', $due_date);

        // Exécuter la requête
        $stmt->execute();

        // Rediriger vers la page d'accueil avec un message de succès
        $_SESSION['message_success'] = "La tâche a été ajoutée avec succès.";
        header('Location: accueil.php');
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        $_SESSION['message_error'] = "Erreur : " . $e->getMessage();
        header('Location: accueil.php');
        exit;
    }
} else {
    // Rediriger vers la page d'accueil si les données du formulaire ne sont pas présentes
    header('Location: accueil.php');
    exit;
}
?>