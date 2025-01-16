<?php
session_start(); // Démarrer la session

// Vérifier si le score est défini dans la session
$score = $_SESSION['score'] ?? 0;
$name = $_SESSION['name'] ?? 'Anonyme';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - QCM en Ligne</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
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