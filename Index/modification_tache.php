<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset ($_SESSION['utilisateur_connecte']) || !$_SESSION['utilisateur_connecte']) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

// Vérifier si l'ID de la tâche à modifier est présent dans les données POST
if (!isset ($_POST['id'])) {
    // Rediriger vers la page d'accueil si aucun ID n'est fourni
    header('Location: accueil.php');
    exit;
}

// Récupérer l'ID de la tâche depuis les données POST
$id_tache = $_POST['id'];

// Connexion à la base de données
require_once '../config/connexion_database.php';

try {
    // Préparer la requête pour récupérer les détails de la tâche à partir de son ID
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id_tache);
    $stmt->execute();

    // Vérifier si la tâche existe
    if ($stmt->rowCount() > 0) {
        // Récupérer les détails de la tâche
        $tache = $stmt->fetch();
    } else {
        // Rediriger vers la page d'accueil si la tâche n'est pas trouvée
        header('Location: accueil.php');
        exit;
    }
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message d'erreur
    $_SESSION['message_error'] = "Erreur lors de la récupération des détails de la tâche : " . $e->getMessage();
    // Rediriger vers la page d'accueil
    header('Location: accueil.php');
    exit;
}

// Vérifier si des données de formulaire ont été soumises pour la mise à jour de la tâche
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset ($_POST['modifier_tache'])) {
    try {
        // Préparer la requête pour mettre à jour la tâche dans la base de données
        $stmt = $conn->prepare("UPDATE tasks SET title = :title, due_date = :due_date WHERE id = :id");
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':due_date', $_POST['due_date']);
        $stmt->bindParam(':id', $id_tache);

        // Exécuter la requête de mise à jour
        $stmt->execute();

        // Rediriger vers la page d'accueil avec un message de succès
        $_SESSION['message_success'] = "La tâche a été modifiée avec succès.";
        header('Location: accueil.php');
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        $_SESSION['message_error'] = "Erreur lors de la modification de la tâche : " . $e->getMessage();
        // Rediriger vers la page d'accueil
        header('Location: accueil.php');
        exit;
    }
}

$pageTitle = "Modifier la tâche";
require_once "header.php";
?>

<body>
    <div class="container">
        <h1>Modifier la tâche</h1>
        <form action="modification_tache.php" method="post">
            <!-- Champ caché pour envoyer l'ID de la tâche -->
            <input type="hidden" name="id" value="<?php echo $id_tache; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre de la tâche</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $tache['title']; ?>">
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Date d'échéance</label>
                <input type="date" class="form-control" id="due_date" name="due_date"
                    value="<?php echo $tache['due_date']; ?>">
            </div>
            <button type="submit" name="modifier_tache" class="btn btn-primary">Modifier la tâche</button>
        </form>
    </div>
</body>

</html>