<?php
session_start(); // Démarrage de la session

// Vérification de l'authentification de l'utilisateur
if (!isset ($_SESSION['utilisateur_connecte'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: sign_in.php');
    exit;
}

// Inclusion du fichier de connexion à la base de données
require_once "connection_database.php";

// Initialisation de la variable de confirmation
$message = "";

// Fonction de validation de la date au format YYYY-MM-DD
function validateDate($date, $format = 'Y-m-d')
{
    $dateTime = \DateTime::createFromFormat($format, $date);
    return $dateTime && $dateTime->format($format) === $date;
}

// Vérification si la méthode de la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si les données nécessaires sont présentes dans la requête
    if (isset ($_POST['id'], $_POST['title'], $_POST['priority'], $_POST['due_date'])) {
        // Récupération des données de la tâche à modifier
        $task_id = $_POST['id'];
        $task_title = $_POST['title'];
        $task_priority = $_POST['priority'];
        $task_due_date = $_POST['due_date'];

        // Vérification si la priorité est valide
        if ($task_priority < 1 || $task_priority > 3) {
            $message = "La priorité doit être comprise entre 1 et 3.";
        } elseif (!validateDate($task_due_date)) {
            $message = " le Format de la date doit être YYYY-MM-DD (Année - Mois - Jour). ";
        } else {
            // Récupération du titre actuel de la tâche
            $stmt = $conn->prepare("SELECT title, priority, due_date FROM tasks WHERE id = :id");
            $stmt->bindParam(":id", $task_id);
            $stmt->execute();
            $task_data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Assignation des valeurs récupérées aux variables correspondantes
            $existing_title = $task_data['title'];
            $existing_priority = $task_data['priority'];
            $existing_due_date = $task_data['due_date'];

            // Vérification si le titre, la priorité ou la date d'échéance ont été modifiés
            if (($existing_title !== $task_title) || ($existing_priority !== $task_priority) || ($existing_due_date !== $task_due_date)) {
                // Mise à jour du titre, de la priorité et de la date d'échéance de la tâche dans la base de données
                $stmt = $conn->prepare("UPDATE tasks SET title = :title, priority = :priority, due_date = :due_date WHERE id = :id");
                $stmt->bindParam(":id", $task_id);
                $stmt->bindParam(":title", $task_title);
                $stmt->bindParam(":priority", $task_priority);
                $stmt->bindParam(":due_date", $task_due_date);
                // Exécution de la requête de mise à jour
                $stmt->execute();
                // Mise à jour du message de confirmation
                $message = "Les informations de la tâche ont été modifiées avec succès.";
            } else {
                // Aucune modification n'a été apportée à la tâche
                $message = "Aucune modification n'a été apportée à la tâche.";
            }
        }
    } else {
        // Redirection de l'utilisateur vers une page d'erreur si les données sont manquantes
        header('Location: ../Index.php');
        exit;
    }
} else {
    // Redirection de l'utilisateur vers une page d'erreur si la méthode de la requête n'est pas POST
    header('Location: ../Index.php');
    exit;
}

require_once 'header.php';
?>

<body>

    <h1>Modifier le titre de la tâche</h1>
    <div class="container">
        <div class="centered-card">
            <div class="card">
                <div class="card-body">
                    <?php if (!empty ($message)): ?>
                        <!-- Affichage du message de confirmation ou d'erreur -->
                        <?php if (strpos($message, "succès") !== false): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <form action="change_task.php" method="post" class="task-form">
                        <input type="hidden" name="id" value="<?php echo $task_id; ?>">
                        <div class="form-group">
                            <label for="title" class="form-label">Nouveau titre :</label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="<?php echo $task_title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="priority" class="form-label">Nouvelle priorité :</label>
                            <input type="text" id="priority" name="priority" class="form-control"
                                value="<?php echo $task_priority; ?>">
                        </div>
                        <div class="form-group">
                            <label for="due_date" class="form-label">Nouvelle date d'échéance :</label>
                            <input type="text" id="due_date" name="due_date" class="form-control"
                                value="<?php echo $task_due_date; ?>">
                        </div>

                        <div class="btn_change-task">
                            <button type="submit" class="btn btn-primary">Modifier</button>

                            <button type="button" class="btn btn-primary" style="margin-right: 10px;"
                                onclick="window.location.href='../Index.php'">Retour Page d'accueil</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body