<?php
session_start();

// Vérifier si les champs requis sont renseignés
if (isset ($_POST['identifier'], $_POST['password'])) {
    // Connexion à la base de données
    require_once '../php/connection_database.php';

    try {
        // Préparer la requête SQL pour récupérer les informations de l'utilisateur
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :identifier OR email = :identifier");
        $stmt->bindParam(':identifier', $_POST['identifier']);
        $stmt->execute();

        // Vérifier si l'utilisateur existe
        if ($stmt->rowCount() > 0) {
            // Récupérer les données de l'utilisateur
            $row = $stmt->fetch();
            $hashed_password = $row['password'];

            // Vérifier si le mot de passe est correct
            if (password_verify($_POST['password'], $hashed_password)) {

                $_SESSION['utilisateur_connecte'] = $row['username']; // Identifiant de l'utilisateur

                // Récupérer la date de création du compte depuis la base de données
                $last_connexion = $row['last_connexion'];

                // Mettre à jour la colonne last_connexion avec la date et l'heure actuelles
                $update_stmt = $conn->prepare("UPDATE users SET last_connexion = NOW() WHERE username = :identifier");
                $update_stmt->bindParam(':identifier', $row['username']);
                $update_stmt->execute();
                var_dump($update_stmt);
                // Rediriger l'utilisateur vers la page d'accueil
                header("Location: ../Index.php");
                exit;
            } else {
                // Mot de passe incorrect
                $_SESSION['error'] = "Mot de passe incorrect ! ";
            }

        } else {
            // Utilisateur non trouvé
            $_SESSION['error'] = "Nom d'utilisateur ou adresse e-mail invalide.";
        }
        $conn = null;
    } catch (PDOException $e) {
        // Erreur de base de données
        $_SESSION['error'] = "Une erreur s'est produite lors de la connexion. Veuillez réessayer ! ";
        // Afficher le message d'erreur spécifique renvoyé par PDO pour le débogage
        $_SESSION['error'] = "Erreur de base de données : " . $e->getMessage();
    }
} else {
    // Champs non renseignés
    $_SESSION['error'] = "Veuillez saisir votre nom d'utilisateur ou votre adresse e-mail, ainsi que votre mot de passe.";
}

// Rediriger vers la page de connexion en cas d'erreur
header("Location: sign_in.php");
exit;

?>