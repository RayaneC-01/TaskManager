<?php
// Vérifier si l'utilisateur est connecté avant d'afficher cette page
session_start();
// if (!isset($_SESSION['utilisateur_connecte']) || !$_SESSION['utilisateur_connecte']) {
//     // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
//     header('Location: index.php');
//     exit;
// }

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Gestionnaire de tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/style/styles.css">
</head>

<body>
    <h1> Bienvenue ! </h1>
</body>

</html>