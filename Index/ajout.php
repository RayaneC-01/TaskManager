<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset ($_SESSION['utilisateur_connecte'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

require_once '../config/connexion_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['title'])) {
    // Récupérer l'identifiant unique de l'utilisateur connecté
    $username = $_SESSION['utilisateur_connecte'];
    $stmt_user_id = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt_user_id->bindParam(':username', $username);
    $stmt_user_id->execute();
    $user_id_row = $stmt_user_id->fetch();
    $user_id = $user_id_row['id'];

    // Validation et nettoyage du titre de la tâche
    $titre = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);

    // Vérifier si le titre est vide après le nettoyage
    if (empty ($titre)) {
        $_SESSION['message_error'] = "Erreur : Le titre de la tâche est requis.";
        header('Location: accueil.php');
        exit;
    }

    // Définir la date d'échéance en fonction de l'option choisie
    $due_date = '';

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
            // Si une date personnalisée est sélectionnée, récupérer la valeur du champ personnalisé
            $custom_due_date = $_POST['custom_due_date'];

            // Vérifier si aucune date n'a été sélectionnée
            if (empty ($custom_due_date)) {
                $_SESSION['message_error'] = "Erreur : Une date d'échéance personnalisée est requise.";
                header('Location: accueil.php');
                exit;
            }

            // Valider la date personnalisée et la formater en format YYYY-MM-DD
            if (strtotime($custom_due_date) === false) {
                $_SESSION['message_error'] = "Erreur : Format de date personnalisée invalide.";
                header('Location: accueil.php');
                exit;
            }

            $due_date = date('Y-m-d', strtotime($custom_due_date));
            break;
        default:
            $_SESSION['message_error'] = "Erreur : Option de date d'échéance non reconnue.";
            header('Location: accueil.php');
            exit;
    }

    // Définir la priorité
    $priority = $_POST['priority'];

    try {
        // Insérer la tâche dans la base de données avec la priorité spécifiée
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, due_date, priority) VALUES (:user_id, :title, :due_date, :priority)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $titre,
            ':due_date' => $due_date,
            ':priority' => $priority
        ]);
        var_dump($stmt);
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