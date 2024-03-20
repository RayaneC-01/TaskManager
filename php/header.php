<?php
// Fonction pour obtenir le nom de la page actuelle sans l'extension
function getCurrentPageName()
{
    return basename($_SERVER['PHP_SELF'], '.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle; ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/style_forms.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="Index.php"><img src="/Images/logo_icon.png" alt="" class="img_nav"></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 h4">
                    <li class="nav-item">
                        <a class="nav-link active bouton-requiert-connexion" aria-current="page"
                            href="Index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Tableau de Bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="deleted_task.php" aria-disabled="false">Historique</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" style="margin-right: 70px;" action="search.php" method="post">
                    <input class="form-control me-3" type="search" name="query" placeholder="Search"
                        aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>


                <button type="button" class="btn btn-outline-danger btn-lg" style="margin-right: 10px;"
                    onclick="window.location.href='sign_in.php'">Déconnexion</button>
            </div>
        </div>
    </nav>