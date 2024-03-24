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

// Vérification si la méthode de la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si les données nécessaires sont présentes dans la requête
    if (isset ($_POST['id']) && isset ($_POST['title'])) {
        // Récupération des données de la tâche à modifier
        $task_id = $_POST['id'];
        $task_title = $_POST['title'];

        // Récupération du titre actuel de la tâche
        $stmt = $conn->prepare("SELECT title FROM tasks WHERE id = :id");
        $stmt->bindParam(":id", $task_id);
        $stmt->execute();
        $existing_title = $stmt->fetchColumn();

        // Vérification si le titre a été modifié
        if ($existing_title !== $task_title) {
            // Mise à jour du titre de la tâche dans la base de données
            $stmt = $conn->prepare("UPDATE tasks SET title = :title WHERE id = :id");
            $stmt->bindParam(":id", $task_id);
            $stmt->bindParam(":title", $task_title);
            // Exécution de la requête de mise à jour
            $stmt->execute();
            // Mise à jour du message de confirmation
            $message = "Le titre de la tâche a été modifié avec succès.";
        } else {
            // Le titre n'a pas été modifié
            $message = "Aucune modification apportée au titre de la tâche.";
        }
    } else {
        // Redirection de l'utilisateur vers une page d'erreur si les données sont manquantes
        header('Location: ../Index.php');
        exit;
    }
} else {
    // Redirection de l'utilisateur vers une page d'erreur si la méthode de la requête n'est pas POST
    header('Location: error_page.php');
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
                        <!-- Affichage du message de confirmation -->
                        <div class="alert alert-success" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <form action="change_task.php" method="post" class="task-form">
                        <input type="hidden" name="id" value="<?php echo $task_id; ?>">
                        <div class="form-group">
                            <label for="title" class="form-label">Nouveau titre :</label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="<?php echo $task_title; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>