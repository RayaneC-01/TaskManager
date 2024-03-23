<?php
session_start();

// Vérifie si l'utilisateur est connecté et récupérez son nom
$user_name = isset ($_SESSION['username']) ? $_SESSION['username'] : 'Utilisateur';

// Déconnexion de l'utilisateur pour éviter tout accès non autorisé à cette page
unset($_SESSION['username']); // supprimer toute information sensible de la session

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réinitialisation de mot de passe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/styles.css" />

</head>

<body>
    <div class="container">
        <div class="centered-card">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        <h1 class="h4">Confirmation de réinitialisation de mot de passe</h1><br>
                        <p class="h3"> Bonjour
                            <?php echo $user_name; ?>,
                        </p>
                        <p class="text-success h5">Votre mot de passe a été réinitialisé avec succès ! </p>

                        <a href="sign_in.php" class="btn btn-primary btn-lg active" role="button"
                            aria-pressed="true">Revenir page
                            Connexion</a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>