<?php
session_start();

// Vérifie si le formulaire de réinitialisation a été soumis
if (isset ($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
    // Récupère les données soumises
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifie si les mots de passe correspondent
    if ($password === $confirm_password) {
        // Les mots de passe correspondent, procède à la réinitialisation

        // Hasher le nouveau mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparez et exécutez une requête SQL pour mettre à jour le mot de passe dans la base de données
        require 'connection_database.php';
        $update_stmt = $conn->prepare("UPDATE users SET password = :password WHERE reset_token = :token");
        $update_stmt->bindParam(':password', $hashed_password);
        $update_stmt->bindParam(':token', $token);
        $update_stmt->execute();
        var_dump($update_stmt);
        // Rediriger l'utilisateur vers une page de connexion
        //header("Location: sign_in.php");
        header("Location: password_reset_confirmation.php");

        exit;
    } else {
        // Les mots de passe ne correspondent pas, afficher un message d'erreur
        $_SESSION['error'] = "Les mots de passe ne correspondent pas. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Réinitialiser Mot de passe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- Bootstrap icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style_forms.css" />
</head>

<body>
    <section class="form-02-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="_lk_de">
                        <div class="form-03-main">
                            <h1>Réinitialiser le mot de passe</h1>
                            <?php if (isset ($_SESSION['error'])): ?>
                            <div>
                                <?php echo $_SESSION['error']; ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            <form action="" method="post">
                                <div class="form-group">

                                    <label for="password">Nouveau mot de passe :</label>
                                    <input type="hidden" name="token"
                                        value="<?php echo isset ($_POST['token']) ? $_POST['token'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control check-input" type="password" id="password"
                                        name="password" required><br>
                                    <label for="confirm_password">Confirmez le nouveau
                                        mot de passe :</label><br>
                                    <input class="form-control check-input" type="password" id="confirm_password"
                                        name="confirm_password" required><br><br>
                                    <button type="submit" class='btn btn-primary btn-lg'>Réinitialiser le mot de
                                        passe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>