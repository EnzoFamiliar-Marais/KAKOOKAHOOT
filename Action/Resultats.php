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
</body>
<?php
session_start(); // Démarrer la session

require_once '../Classes/Form/Database.php';
use Classes\Form\Database;

if ($_SESSION['name'] == null){
    header("Location: ../index.php");
    exit();
} 
// Vérifier si le score est défini dans la session
$score = $_SESSION['score'] ?? 0;

$name = $_SESSION['name'] ?? 'Anonyme';

$db = new Classes\Form\Database('../Data/database.sqlite');

?>

<body>

    <div class="content">
        <h1 class="title">Vos résultats</h1>
        <p>Nom du joueur : <?php echo htmlspecialchars($name); ?></p>
        <p>Votre score est : <?php echo $db->getScore($name); ?></p>
        <a class="back-home" href="../index.php">Retour à l'accueil</a>
    </div>
</body>
</html>