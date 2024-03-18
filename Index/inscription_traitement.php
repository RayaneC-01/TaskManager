<?php
session_start();
require_once '../config/connexion_database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['first_name', 'last_name', 'email', 'password', 'confirm_password', 'username'];


    // array_intersect() compare deux tableaux et retourne les éléments communs entre eux
    // Ici, elle est utilisée pour vérifier si toutes les clés des champs requis sont présentes dans les données POST
    // array_keys() est utilisée pour extraire les clés des données POST (noms des champs soumis dans le formulaire)
    // La fonction count() est utilisée pour compter le nombre d'éléments communs entre les clés des champs requis et les clés des données POST
    // Si ce nombre est égal au nombre total des champs requis, cela signifie que tous les champs requis ont été soumis

    // Vérifier si tous les champs requis sont renseignés
    if (count(array_intersect($required_fields, array_keys($_POST))) === count($required_fields)) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $username = $_POST['username'];

        // Vérifier si le mot de passe correspond à la confirmation du mot de passe
        if ($password === $confirm_password) {
            // Vérifier si l'e-mail est valide
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Vérifier si l'e-mail existe déjà dans la base de données
                $stmt_check_email = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = :email");
                $stmt_check_email->bindParam(':email', $email);
                $stmt_check_email->execute();
                $email_exists = $stmt_check_email->fetch(PDO::FETCH_ASSOC)['count'];

                // Vérifier si le pseudo existe déjà dans la base de données
                $stmt_check_username = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE username = :username");
                $stmt_check_username->bindParam(':username', $username);
                $stmt_check_username->execute();
                $username_exists = $stmt_check_username->fetch(PDO::FETCH_ASSOC)['count'];

                if ($username_exists > 0) {
                    $_SESSION['message_error'] = "Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.";
                    header("Location: inscription.php");
                    exit;
                }

                if ($email_exists == 0) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $created_at = date('Y-m-d H:i:s');

                    try {
                        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, created_at, username) VALUES (:first_name, :last_name, :email, :password, :created_at, :username)");
                        $stmt->execute([':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':password' => $hashed_password, ':created_at' => $created_at, ':username' => $username]);

                        var_dump($stmt);
                        // Après l'insertion réussie des données dans la base de données
                        $_SESSION['message_success'] = "Inscription réussie ! Bienvenue sur la  page d'accueil.";

                        // Redirection vers la page d'accueil après l'inscription
                        header("Location: ../Index/accueil.php");
                        exit;

                    } catch (PDOException $e) {
                        // En cas d'erreur lors de l'insertion dans la base de données
                        $_SESSION['message_error'] = "Erreur lors de l'inscription : " . $e->getMessage();
                    }
                } else {
                    $_SESSION['message_error'] = "L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
                }
            } else {
                $_SESSION['message_error'] = "L'adresse e-mail n'est pas valide.";
            }
        } else {
            $_SESSION['message_error'] = "Le mot de passe et la confirmation du mot de passe ne correspondent pas.";
        }
    } else {
        $_SESSION['message_error'] = "Veuillez remplir tous les champs.";
    }
}

header("Location: inscription.php");
exit;
?>