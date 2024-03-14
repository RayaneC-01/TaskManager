<?php
// Vérifier si l'utilisateur est connecté avant d'afficher cette page
session_start();
if (!isset($_SESSION['utilisateur_connecte']) || !$_SESSION['utilisateur_connecte']) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

$pageTitle = "Page d'accueil Gestionnaire de tâches";
require_once 'header.php'; ?>

<div class="container">
    <h2 class="title_center">Gestionnaire de tâches</h2>
    <h2>Liste des tâches : </h2>
    <ul>
        <?php
        // Afficher les tâches depuis la base de données
        require 'connexion_database.php';
        try {
            // Préparer la requête de sélection des tâches
            $stmt = $conn->query("SELECT * FROM tasks");

            // Parcourir les résultats et afficher chaque tâche
            while ($row = $stmt->fetch()) {
                echo "<li class='task-item added-task d-flex justify-content-between align-items-center'>";
                echo "<span>{$row['title']}</span>";

                // Vérifier si la tâche est marquée comme terminée ou non
                if ($row['completed'] == 1) {
                    echo "<span class='completed-task'>Tâche terminée</span>";
                } else {
                    // Afficher la date d'échéance si elle est définie
                    if ($row['due_date'] === null) {
                        echo "<span>Aucune date d'échéance définie</span>";
                    } else {
                        echo "<span>Date d'échéance : {$row['due_date']}</span>";
                    }
                }

                // Déterminer la classe CSS en fonction de l'état de la tâche (terminée ou non)
                $taskClass = ($row['completed'] == 1) ? 'completed-task' : '';

                // Bouton "Supprimer"
                echo "<form action='suppression.php' method='post'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<button type='submit' class='btn btn-outline-danger btn-xl'>Supprimer</button>";
                echo "</form>";

                // Bouton "Terminé"
                echo "<form action='task_done.php' method='post'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<button type='submit' class='btn btn-outline-success btn-xl'>Terminé</button>";
                echo "</form>";

                // Lien "Modifier" vers modification_tache.php avec l'ID de la tâche comme paramètre
                echo "<a href='modification_tache.php?id={$row['id']}'>Modifier</a>";
                echo "</li>";
            }

        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur
            echo "Erreur : " . $e->getMessage();
        }
        ?>

    </ul>
    <h4>Ajouter une tâche </h4>
    <form action="ajout.php" method="post" id="task_form">
        <input type="text" name="title" placeholder="Titre de la tâche" required>
        <div class="date-wrapper">
            <select name="due_date" id="due_date_select">
                <option value="today">Aujourd'hui</option>
                <option value="tomorrow">Demain</option>
                <option value="next_week">La semaine prochaine</option>
                <option value="in_2_week">Dans 2 semaines</option>
                <option value="choose_date">Choisir une date</option>
            </select>
            <input type="text" id="custom_due_date" name="custom_due_date" placeholder="D-M-Y" style="display: none;">
        </div>
        <button class="bouton-requiert-connexion" type="submit">Ajouter une tache</button>
        <?php
        // Afficher un message de succès s'il existe
        if (isset($_SESSION['message_success'])) {
            echo "<div class='alert alert-success'>{$_SESSION['message_success']}</div>";
            unset($_SESSION['message_success']); // Effacer le message après l'avoir affiché
        }

        // Afficher un message d'erreur s'il existe
        if (isset($_SESSION['message_error'])) {
            echo "<div class='alert alert-danger'>{$_SESSION['message_error']}</div>";
            unset($_SESSION['message_error']); // Effacer le message après l'avoir affiché
        }
        ?>

    </form>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

<script src="/script/script.js">
</script>

</html>