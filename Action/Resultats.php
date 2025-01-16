<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - QCM en Ligne</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
</body>
<?php
session_start(); // Démarrer la session

// Vérifier si le score est défini dans la session
$score = $_SESSION['score'] ?? 0;

$name = $_SESSION['name'] ?? 'Anonyme';
if ($name == 'Anonyme') {
    echo '<form method="post" action="">
            <label for="name">Entrez votre nom :</label>
            <input type="text" id="name" name="name" required>
            <button type="submit">Soumettre</button>
          </form>';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name'])) {
        $_SESSION['name'] = htmlspecialchars($_POST['name']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    exit();
}

?>

<body>
    <header>
        <h1>Vos résultats</h1>
    </header>
    <div class="content">
        <p>Nom du joueur : <?php echo htmlspecialchars($name); ?></p>
        <p>Votre score est : <?php echo htmlspecialchars($score); ?></p>
        <a href="../index.php">Retour à l'accueil</a>
    </div>
</body>
</html>