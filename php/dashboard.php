<?php
// Connectez-vous à votre base de données
require_once 'connection_database.php';

// Démarrer la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset ($_SESSION['utilisateur_connecte'])) {
    // Récupérez l'identifiant de l'utilisateur depuis la session
    $username = $_SESSION['utilisateur_connecte'];
    $message = $username;

    // Préparez et exécutez une requête SQL pour sélectionner le prénom de l'utilisateur
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, created_at, username, last_connexion FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Récupérez le résultat de la requête
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifiez si le résultat est non vide et que la clé 'id' est définie
    if ($row && isset ($row['id'])) {
        // Récupérez le prénom de l'utilisateur
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $user_username = $row['username'];
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
    header('Location: sign_in.php');
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
                        <li class="list-group-item h4">Nom d'utilisateur: <strong>
                                <?php echo $user_username; ?>
                            </strong>
                        </li>
                        <li class="list-group-item h4">Email: <strong>
                                <?php echo $email; ?>
                                <div class="button-group">
                                    <!-- Lien pour rediriger l'utilisateur vers la page de changement d'e-mail -->
                                    <a href="change_email.php" class="button-text">Changer l'adresse e-mail</a>

                                </div>
                            </strong>
                        </li>
                        <li class="list-group-item h4">
                            <div class="button-group">
                                <!-- Lien pour rediriger l'utilisateur vers la page de changement d'e-mail -->
                                Mot de passe :<a href="change_password.php" class="button-text">Changer le mot de
                                    passe </a>

                            </div>
                        </li>

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
                    <?php
                    $priority_class = '';
                    if ($task['priority'] == 'Faible') {
                        $priority_class = 'bg-info';
                    } elseif ($task['priority'] == 'Moyenne') {

                        $priority_class = 'bg-warning';
                    } elseif ($task['priority'] == 'Haute') {
                        $priority_class = 'bg-danger';
                    }
                    ?>
                    <li class="list-group-item <?php echo $priority_class; ?>">
                        <strong>
                            <?php echo $task['title']; ?>
                        </strong>
                        <span class="badge bg-primary">
                            <?php echo "Priorité : " . $task['priority']; ?>
                        </span>
                    </li>
                <?php endwhile; ?>

            </ul>
        </div>
    </div>

</body>

</html>