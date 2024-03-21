<?php
session_start();
require_once 'connection_database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['first_name', 'last_name', 'email', 'password', 'confirm_password', 'username'];


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
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Vérifier si le pseudo est déjà utilisé
                $stmt_check_username = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE username = :username");
                $stmt_check_username->bindParam(':username', $username);
                $stmt_check_username->execute();
                $username_exists = $stmt_check_username->fetch(PDO::FETCH_ASSOC)['count'];

                if ($username_exists == 0) {
                    // Le pseudo n'existe pas encore dans la base de données, procéder à l'inscription de l'utilisateur
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $created_at = date('Y-m-d H:i:s');

                    try {
                        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, created_at, username) VALUES (:first_name, :last_name, :email, :password, :created_at, :username)");
                        $stmt->execute([':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':password' => $hashed_password, ':created_at' => $created_at, ':username' => $username]);

                        // Après l'insertion réussie des données dans la base de données
                        $_SESSION['message_success'] = "Inscription réussie ! Bienvenue sur la page d'accueil.";

                        // Redirection vers la page d'accueil après l'inscription
                        header("Location:../Index.php");
                        exit;


                    } catch (PDOException $e) {
                        // En cas d'erreur lors de l'insertion dans la base de données
                        $_SESSION['message_error'] = "Erreur lors de l'inscription : " . $e->getMessage();
                    }
                } else {
                    // Le pseudo est déjà utilisé, afficher un message d'erreur à l'utilisateur
                    $_SESSION['message_error'] = "Le pseudo est déjà utilisé. Veuillez en choisir un autre.";
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

    // Redirection vers la page d'inscription après le traitement
    header("Location: sign_up.php");
    exit;
}
?>