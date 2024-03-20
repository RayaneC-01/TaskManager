<?php
// Connectez-vous à votre base de données
require_once '../config/connexion_database.php';

// Démarrer la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset ($_SESSION['utilisateur_connecte'])) {
    // Récupérez l'identifiant de l'utilisateur depuis la session
    $username = $_SESSION['utilisateur_connecte'];
    $message = $username;

    // Préparez et exécutez une requête SQL pour sélectionner le prénom de l'utilisateur
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, created_at, last_connexion FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();


    // Récupérez le résultat de la requête
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifiez si le résultat est non vide et que la clé 'id' est définie
    if ($row && isset ($row['id'])) {
        // Récupérez le prénom de l'utilisateur
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $created_at = $row['created_at'];
        $last_connexion = $row['last_connexion'];

        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $row['id'];

        // Récupérer les tâches de l'utilisateur connecté
        $stmt_tasks = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
        $stmt_tasks->bindParam(':user_id', $user_id);
        $stmt_tasks->execute();

    } else {
        // Gérer le cas où l'utilisateur n'est pas trouvé dans la base de données ou l'ID n'est pas défini
        echo "<div class='alert alert-danger'>Utilisateur introuvable ou ID non défini.</div>";
    }

} else {
    // Gérer le cas où l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit();
}
?>

<?php
$pageTitle = "Tableau de Bord Gestionnaire de tâches";
require_once 'header.php'; ?>

<body>

    <div class="container">

        <p class="h3">
            Bonjour, <strong>
                <?php echo $message ?>
            </strong>!
        </p>
        <div class="centered-card">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item h4">Nom:
                            <strong>
                                <?php echo $last_name; ?>
                            </strong>
                        </li>
                        <li class="list-group-item h4">Prénom: <strong>
                                <?php echo $first_name; ?>
                            </strong>
                        </li>
                        <li class="list-group-item h4">Email: <strong>
                                <?php echo $email; ?>
                            </strong></li>
                        <li class="list-group-item h4">Date de création du compte: <strong>
                                <?php echo $created_at; ?>
                            </strong></li>
                        <li class="list-group-item h4">Dernière Connexion est le:
                            <strong>
                                <?php echo $last_connexion; ?>
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Afficher les tâches de l'utilisateur -->
        <div class="task-list">
            <h4>Vos Tâches:</h4>
            <ul class="list-group">
                <?php while ($task = $stmt_tasks->fetch(PDO::FETCH_ASSOC)): ?>
                    <li class="list-group-item h4">
                        <strong>
                            <?php echo $task['title']; ?>
                        </strong>
                        est de niveau
                        <?php echo $task['priority']; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

</body>

</html>