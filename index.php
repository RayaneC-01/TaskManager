<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/style/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="/Images/logo_icon.png" alt="" class="img_nav"></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">DashBoard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" style="margin-right: 10px;">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">
                        Search
                    </button>
                </form>
                <div class="buttons">
                    <button type="button" class="btn btn-warning">Se connecter</button>
                    <button type="button" class="btn btn-info">S'inscrire</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="title_center">Gestionnaire de tâches</h2>
        <h2>Liste des tâches : </h2>
        <ul>
            <!-- Afficher les tâches depuis la base de données -->
            <?php
            require 'connexion.php';
            try {
                // Préparer la requête de sélection des tâches
                $stmt = $conn->query("SELECT * FROM tasks");

                // Parcourir les résultats et afficher chaque tâche
                while ($row = $stmt->fetch()) {
                    echo "<li class='task-item added-task d-flex justify-content-between align-items-center'>";
                    echo "<span>{$row['title']}</span>";

                    // Vérifier si due_date est NULL
                    if ($row['due_date'] === null) {
                        echo "<span>Aucune date d'échéance définie</span>";
                    } else {
                        echo "<span>Date d'échéance : {$row['due_date']}</span>";
                    }

                    echo "<form action='suppression.php' method='post'>";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<button type='submit' class='btn btn-outline-danger btn-sm'>Supprimer</button>";
                    echo "</form>";
                    echo "</li>";
                }




            } catch (PDOException $e) {
                // En cas d'erreur, afficher un message d'erreur
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </ul>
        <h2>Ajouter une tâche</h2>
        <form action="ajout.php" method="post" id="task_form">
            <input type="text" name="title" placeholder="Titre de la tâche" required>
            <select name="due_date" id="due_date_select">
                <option value="today">Aujourd'hui</option>
                <option value="tomorrow">Demain</option>
                <option value="next_week">La semaine prochaine</option>
                <option value="choose_date">Choisir une date</option>
            </select>
            <input type="text" id="custom_due_date" name="custom_due_date" placeholder="D-M-Y" style="display: none;"
                required>
            <button type="submit">Ajouter</button>
        </form>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<script src="/script/script.js">
</script>


</html>