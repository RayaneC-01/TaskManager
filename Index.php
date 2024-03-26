<?php
// Vérifier si l'utilisateur est connecté avant d'afficher cette page
session_start();

// Vérifier s'il y a un message d'erreur
if (isset ($_SESSION['message_error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['message_error']}</div>";
    unset($_SESSION['message_error']); // Supprimer le message d'erreur après l'avoir affiché
}

// Vérifier s'il y a un message de succès
if (isset ($_SESSION['message_success'])) {
    echo "<div class='alert alert-success'>{$_SESSION['message_success']}</div>";
    unset($_SESSION['message_success']); // Supprimer le message de succès après l'avoir affiché
}

if (!isset ($_SESSION['utilisateur_connecte'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: php/sign_in.php');
    exit;
}

$pageTitle = "Page d'accueil Gestionnaire de tâches";
require_once 'php/header.php';
?>

<div class="container">
    <h2 class="title_center">Gestionnaire de tâches</h2>
    <h2>Liste des tâches : </h2>
    <ul>
        <?php
        // Afficher les tâches depuis la base de données
        require_once 'php/connection_database.php';

        try {
            if (isset ($_SESSION['utilisateur_connecte'])) {

                // Récupérez l'identifiant de l'utilisateur depuis la session
                $username = $_SESSION['utilisateur_connecte'];

                // Préparez et exécutez une requête SQL pour sélectionner l'identifiant de l'utilisateur
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                // Récupérez l'identifiant de l'utilisateur
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $user_id = $row['id'];

                // Préparez et exécutez une requête SQL pour sélectionner les tâches de l'utilisateur
                $stmt_tasks = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
                $stmt_tasks->bindParam(':user_id', $user_id);
                $stmt_tasks->execute();



                // Parcourir les résultats et afficher chaque tâche
                while ($row = $stmt_tasks->fetch()) {
                    echo "<li class='task-item added-task d-flex justify-content-between align-items-center'>";
                    //echo "<span class='h4'>{$row['title']}</span>";
        
                    // Affichage du titre
                    if ($row['completed'] == 1) {
                        echo "<span class='h4 completed-task'>{$row['title']} (Terminé)</span>";
                    } else {
                        echo "<span class='h4'>{$row['title']}</span>";
                    }

                    // Vérifier si la tâche est marquée comme terminée ou non
                    if ($row['completed'] == 1) {
                        echo "<span class='completed-task h4'>Tâche terminée</span>";
                    } else {
                        // Afficher la date d'échéance si elle est définie
                        if ($row['due_date'] === null) {
                            echo "<span class='h4'>Aucune date d'échéance définie</span>";
                        } else {
                            echo "<span class='h4'>Date d'échéance : {$row['due_date']}</span>";
                        }
                    }
                    // Déterminer la classe CSS en fonction de l'état de la tâche (terminée ou non)
                    $taskClass = ($row['completed'] == 1) ? 'completed-task' : '';

                    // Bouton "Supprimer"
                    echo "<form action='php/delete_task.php' method='post'>";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<button type='submit' class='btn btn-outline-danger btn-xl'>Supprimer</button>";
                    echo "</form>";

                    // Bouton "Terminé"
                    echo "<form action='php/task_done.php' method='post'>";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";

                    switch ($row['completed']) {
                        case 0:
                            echo "<button type='submit' class='btn btn-outline-secondary btn-xl' name='task_undone'>Terminer</button>";
                            break;
                        case 1:
                            echo "<button type='submit' class='btn btn-success btn-xl' name='task_done'>Terminé</button>";
                            break;
                    }

                    echo "</form>";

                    // Formulaire caché pour envoyer l'ID de la tâche à change_task.php anciennement modification_tache.php
                    // Formulaire pour modifier la tâche
                    echo "<form action='php/change_task.php' method='post'>";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<input type='hidden' name='title' value='{$row['title']}'>";
                    echo "<input type='hidden' name='priority' value='{$row['priority']}'>";
                    echo "<input type='hidden' name='due_date' value='{$row['due_date']}'>";
                    echo "<button type='submit' class='btn btn-outline-primary'>Modifier</button>";
                    echo "</form>";


                    // Balise aside pour afficher la priorité
                    echo "<aside class='priority-container'>";
                    $priorityText = '';
                    switch ($row['priority']) {
                        case 1:
                            $priorityText = 'Faible';
                            $priorityClass = 'low-priority';
                            break;
                        case 2:
                            $priorityText = 'Moyenne';
                            $priorityClass = 'medium-priority';
                            break;
                        case 3:
                            $priorityText = 'Élevée';
                            $priorityClass = 'high-priority';
                            break;
                        default:
                            $priorityText = 'Inconnue';
                            $priorityClass = 'Inconnue';
                            break;
                    }
                    echo "<span class='priority $priorityClass'>Priorité : $priorityText</span>";
                    echo "</aside>";

                }
            }

        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur
            echo "Erreur : " . $e->getMessage();
        }
        ?>

    </ul>
    <h4>Ajouter une tâche </h4>
    <form action="php/add_task.php" method="post" id="task_form">
        <input type="text" name="title" placeholder="Titre de la tâche" required>
        <div>
            <label for="priority">Priorité :</label>
            <select name="priority" id="priority" class="priority-select">
                <option value="1">1 - Faible</option>
                <option value="2">2 - Moyenne</option>
                <option value="3">3 - Élevée</option>
            </select>
            <span>Note : 1 est le plus faible et 3 est le plus élevé.</span>
        </div>
        <br>
        <div class="date-wrapper">
            <label for="priority">Choisir une Date :</label>
            <select name="due_date" id="due_date_select" class="priority-select">
                <option value="">-- Choisir une date --</option>
                <option value="today">Aujourd'hui</option>
                <option value="tomorrow">Demain</option>
                <option value="next_week">La semaine prochaine</option>
                <option value="in_2_week">Dans 2 semaines</option>
                <option value="choose_date">Choisir une date</option>
            </select>
        </div>
        <input type="text" id="custom_due_date" name="custom_due_date" placeholder="D-M-Y" style="display: none;">
        <button class="bouton-requiert-connexion" type="submit">Ajouter</button>
    </form>
</div>
<footer class="py-3 ">
    <ul class="nav justify-content-center border-bottom ">
        <li class=" nav-item"><a href="Index.php" class="nav-link px-2 text-body-secondary">Home</a></li>
        <li class="nav-item"><a href="about.php" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">© 2024 All rights reserved, Rayane Chaabane</p>
</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

<script src="/js/script.js">
</script>

</html>