<?php
session_start();

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs requis sont renseignés
    if (isset($_POST['identifier'], $_POST['password'])) {
        // Récupérer les informations d'identification
        $identifier = $_POST['identifier'];
        $password = $_POST['password'];

        // Connexion à la base de données
        require 'connexion_database.php';

        try {
            // Préparer la requête SQL pour récupérer les informations de l'utilisateur
            $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = :identifier OR email = :identifier");
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();

            // Vérifier si l'utilisateur existe
            if ($stmt->rowCount() > 0) {
                // Récupérer les données de l'utilisateur
                $row = $stmt->fetch();
                $user_id = $row['user_id'];
                $hashed_password = $row['password'];

                // Vérifier si le mot de passe est correct
                if (password_verify($password, $hashed_password)) {
                    // Authentification réussie, enregistrer l'identifiant de l'utilisateur dans la session
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['utilisateur_connecte'] = true; // Définir l'utilisateur comme connecté


                    // Rediriger l'utilisateur vers la page d'accueil ou une autre page protégée
                    header("Location: accueil.php");
                    exit;
                } else {
                    // Mot de passe incorrect
                    $_SESSION['error'] = "Mot de passe incorrect.";
                }
            } else {
                // Utilisateur non trouvé
                $_SESSION['error'] = "Nom d'utilisateur ou adresse e-mail invalide.";
            }
        } catch (PDOException $e) {
            // Erreur de base de données
            $_SESSION['error'] = "Une erreur s'est produite lors de la connexion. Veuillez réessayer.";
        }
    } else {
        // Champs non renseignés
        $_SESSION['error'] = "Veuillez saisir votre nom d'utilisateur ou votre adresse e-mail, ainsi que votre mot de passe.";
    }
}

// Rediriger vers la page de connexion en cas d'erreur
header("Location: connexion.php");
exit;
?>