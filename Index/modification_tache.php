<?php
// Démarrer la session
session_start();

// Vérifier si l'ID de la tâche à modifier est présent dans le formulaire
if (!isset($_POST['id'])) {
    // Rediriger vers la page d'accueil si aucun ID n'est fourni
    $_SESSION['message_error'] = "Aucun ID de tâche fourni.";
    header('Location: accueil.php');
    exit;
}

// Récupérer l'ID de la tâche depuis le formulaire
$id_tache = $_POST['id'];

// Connexion à la base de données
require 'connexion_database.php';

try {
    // Préparer la requête pour récupérer les données de la tâche à modifier
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id_tache);
    $stmt->execute();

    // Récupérer les données de la tâche
    $tache = $stmt->fetch();

    // Vérifier si la tâche existe
    if (!$tache) {
        $_SESSION['message_error'] = "La tâche avec l'ID $id_tache n'existe pas.";
        header('Location: accueil.php');
        exit;
    }

    // Si la tâche existe, continuer avec la mise à jour
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message d'erreur
    $_SESSION['message_error'] = "Erreur lors de la récupération de la tâche : " . $e->getMessage();
    // Rediriger vers la page d'accueil
    header('Location: accueil.php');
    exit;
}

// Si nous sommes arrivés jusqu'ici, cela signifie que les données de la tâche ont été récupérées avec succès

// Vérifier si des données de formulaire ont été soumises pour la mise à jour de la tâche
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
?>

<?php
$pageTitle = "Modifier la tâche";
require_once 'Index/header.php';
?>

<body>
    <div class="container">
        <h1>Modifier la tâche</h1>
        <form action="modification_traitement.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id_tache; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titree de la tâche</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $tache['title']; ?>">
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Date d'échéance</label>
                <input type="date" class="form-control" id="due_date" name="due_date"
                    value="<?php echo $tache['due_date']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Modifier la tâche</button>
        </form>
    </div>
</body>

</html>