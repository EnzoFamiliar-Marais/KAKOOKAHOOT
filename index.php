<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - QCM en Ligne</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur notre plateforme de QCM en ligne</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="../Action/Quiz.php">Participer à un QCM</a>
            <a href="../Action/Resultats.php">Voir mes résultats</a>
        </nav>
    </header>
    <div class="content">
        <h2>Bienvenue sur la page d'accueil</h2>
        <p>Vous pouvez participer à un QCM ou consulter vos résultats à tout moment.</p>
    </div>
    <?php 
    session_start();

    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }

    if (isset($_SESSION['name'])) {
        echo '<p>Vous êtes déjà inscrit !</p>';
        echo '<p>Vous pouvez soit aller voir vos résultats, soit vous pouvez créer un nouveau QCM ou y participer.</p>';
    } else {
        echo '<p>Vous n\'êtes pas inscrit</p>';
        echo '<form action="" method="post">';
        echo '<label for="name">Entrez votre nom :</label>';
        echo '<input type="text" id="name" name="name" required>';
        echo '<button type="submit">Soumettre</button>';
        echo '</form>';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
            $_SESSION['name'] = htmlspecialchars($_POST['name']);
            header('Location: index.php');
            exit();
        }
    }

    echo '<footer>Vous pouvez vous désinscrire juste ici <a href="./index.php?action=logout">cliquez ici</a></footer>';
    ?>
 

</body>
</html>
