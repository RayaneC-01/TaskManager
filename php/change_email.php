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

// Vérifier si le formulaire de changement d'adresse e-mail a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST['new_email'])) {
    // Récupérer la nouvelle adresse e-mail à partir des données POST
    $new_email = $_POST['new_email'];

    // Récupérer l'identifiant de l'utilisateur depuis la session
    $username = $_SESSION['utilisateur_connecte'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['id'];

    // Préparer et exécuter une requête SQL pour mettre à jour l'adresse e-mail de l'utilisateur dans la base de données
    $stmt_update_email = $conn->prepare("UPDATE users SET email = :new_email WHERE id = :user_id");
    $stmt_update_email->bindParam(':new_email', $new_email);
    $stmt_update_email->bindParam(':user_id', $user_id);
    $stmt_update_email->execute();

    // Vérifier si la mise à jour a réussi
    if ($stmt_update_email->rowCount() > 0) {
        // Afficher un message de confirmation
        $message = "Votre adresse e-mail a été mise à jour avec succès.";
    } else {
        // Afficher un message d'erreur
        $error_message = "Une erreur s'est produite lors de la mise à jour de votre adresse e-mail. Veuillez réessayer.";
    }
}
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modification e-mail</title>
</head>

<body>
    <!-- Formulaire de changement d'adresse e-mail -->
    <div class="container">
        <div class="centered-card">
            <div class="card">
                <div class="card-body">
                    <form action="change_email.php" method="post">
                        <?php if (isset ($message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $message;
                                unset($message) ?>
                        </div>
                        <?php elseif (isset ($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message;
                                unset($error_message) ?>

                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="new_email">Nouvelle adresse e-mail :</label>
                            <input type="email" id="new_email" name="new_email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Changer l'adresse e-mail</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>