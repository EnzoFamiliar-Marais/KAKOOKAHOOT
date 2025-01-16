<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement - QCM en Ligne</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../Templates/header.php'; ?>
    <div class="content">
        <h1 class="title">Classement des joueurs</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '/../../Data/database.sqlite' ;
                require_once '/../../Data/database.sqlite';
                
                $db = new \Classes\Form\Database('/../../Data/database.sqlite');
                $scores = $db->getScores();
                foreach ($scores as $row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['score']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <a class="back-home" href="../index.php">Retour à l'accueil</a>
    </div>
</body>
</html>