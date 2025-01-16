<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - QCM en Ligne</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php


require_once '../Classes/autoloader.php';
require_once '../Classes/Form/QuestionProvider.php';
require_once '../Action/Questions.php';
require_once '../Action/Reponses.php';

$question_total = 0;
$question_correct = 0;
$score_total = 0;
$score_correct = 0;

$provider = new Classes\Form\QuestionProvider('../Data/questions.JSON');
$questions = $provider->getQuestions();

switch ($action) {
    case "submit": 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<h1>Résultats</h1>";
            verifier_reponses($questions, $_POST);
        } else {
            echo "Aucune réponse";
        }
        break;
    
    default: 
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            afficher_questions($questions);
        }
        break;
}

?>
</body>
</html>