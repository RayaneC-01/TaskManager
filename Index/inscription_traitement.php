<?php
session_start();

// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs requis sont renseignés
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['username'])) {
        // Récupérer les valeurs du formulaire
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $confirm_password = $_POST['confirm_password'];

        // Vérifier si le mot de passe correspond à la confirmation du mot de passe
        if ($password === $confirm_password) {
            // Valider l'e-mail
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Hasher le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Enregistrer la date et l'heure de création du compte
                $created_at = date('Y-m-d H:i:s');

                require 'connexion_database.php';
                try {
                    // Préparer la requête d'insertion
                    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, created_at, username) VALUES (:first_name, :last_name, :email, :password, :created_at, :username)");
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':created_at', $created_at);
                    // Exécuter la requête
                    $stmt->execute();

                    header("Location: accueil.php?signup=success");
                    
                } catch (PDOException $e) {
                    // Gérer les erreurs de base de données
                    $_SESSION['error'] = "Une erreur s'est produite loooors de l'inscription. Veuillez réessayer.";
                }
            } else {
                // Adresse e-mail invalide
                $_SESSION['error'] = "L'adresse e-mail n'est pas valide.";
            }
        } else {
            // Les mots de passe ne correspondent pas
            $_SESSION['error'] = "Le mot de passe et la confirmation du mot de passe ne correspondent pas.";
        }
    } else {
        // Certains champs requis ne sont pas renseignés
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    }
}

// Rediriger vers la page d'inscription en cas d'erreur
header("Location: inscription.php");
exit;
?>