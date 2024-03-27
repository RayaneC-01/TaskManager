<?php
// Inclure les fichiers nécessaires et démarrer la session
require_once 'connection_database.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset ($_SESSION['utilisateur_connecte'])) {
    // Rediriger l'utilisateur vers la page de connexion si ce n'est pas le cas
    header('Location: sign_in.php');
    exit();
}

// Vérifier si le formulaire de changement de mot de passe a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST['new_password'])) {
    // Récupérer le nouveau mot de passe à partir des données POST
    $new_password = $_POST['new_password'];
    $username = $_POST['username'];

    // Récupérer l'identifiant de l'utilisateur depuis la session
    $login_identifier = $_SESSION['utilisateur_connecte'];

    // Vérifier si l'entrée de connexion est un e-mail
    if (filter_var($login_identifier, FILTER_VALIDATE_EMAIL)) {
        // L'entrée de connexion est un e-mail ou mdp
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :login_identifier OR email = :login_identifier");

    }
    // Lier le paramètre
    $stmt->bindParam(':login_identifier', $login_identifier);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $user_id = $row['id'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Préparer la requête SQL pour mettre à jour le mot de passe de l'utilisateur dans la base de données
        $stmt_update_password = $conn->prepare("UPDATE users SET password = :hashed_password WHERE id = :user_id");
        // Lier les valeurs aux paramètres
        $stmt_update_password->bindParam(':hashed_password', $hashed_password);
        $stmt_update_password->bindParam(':user_id', $user_id);

        // Exécuter la requête SQL
        if ($stmt_update_password->execute([':hashed_password' => $hashed_password, ':user_id' => $user_id])) {
            // Afficher un message de confirmation
            $message = "Votre mot de passe a été mis à jour avec succès enregistrez le dans vote téléphone!";
        } else {
            // Afficher un message d'erreur
            $error_message = "Une erreur s'est produite lors de la mise à jour de votre mot de passe. Veuillez réessayer.";
        }

    } else {
        // Utilisateur non trouvé dans la base de données
        $error_message = "Utilisateur introuvable.";
    }
}

require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modification du mot de passe</title>
</head>

<body>
    <!-- Formulaire de changement de mot de passe -->
    <div class="container">
        <div class="centered-card">
            <div class="card">
                <div class="card-body">
                    <form action="change_password.php" method="post">
                        <?php if (isset ($message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $message; ?>
                        </div>
                        <?php elseif (isset ($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="username">Nom d'utilisateur ou email :</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe :</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Changer de mot de passe</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>