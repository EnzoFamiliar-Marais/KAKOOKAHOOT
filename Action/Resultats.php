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
    <?php include '../Templates/header.php'; ?>
    <div class="content">
        <h1 class="title">Vos résultats</h1>
        <p>Nom du joueur : <?php echo htmlspecialchars($name); ?></p>
        <p>Votre score est : <?php echo htmlspecialchars($score); ?></p>
        <a class="back-home" href="../index.php">Retour à l'accueil</a>
    </div>
</body>
</html>