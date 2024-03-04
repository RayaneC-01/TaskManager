<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $titre = $_POST['title'];
    $due_date = null;

    // Vérifier si l'utilisateur a choisi une date personnalisée
    if ($_POST['due_date'] === 'choose_date') {
        // Récupérer la date personnalisée à partir du champ de formulaire
        $due_date = $_POST['custom_due_date'];

        // Vérifier si aucune date n'a été sélectionnée
        if (empty($due_date)) {
            // Afficher un message d'erreur et rediriger vers la page d'accueil
            echo "Erreur : Une date d'échéance est requise.";
            header('Refresh: 2; URL=index.php');
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
        case 'choose_date':
            // Si l'utilisateur a choisi "Choisir une date", je recupere la date à partir du champ de formulaire 
            $due_date = $_POST['custom_due_date'];
            break;
        default:
            // Gérer les cas d'erreur ou par défaut
            "Veuillez choisir une date ! ";
            break;
    }

    try {
        // Préparer la requête d'insertion avec la date d'échéance
        $stmt = $conn->prepare("INSERT INTO tasks (title, due_date) VALUES (:title, :due_date)");
        $stmt->bindParam(':title', $titre);
        $stmt->bindParam(':due_date', $due_date);

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