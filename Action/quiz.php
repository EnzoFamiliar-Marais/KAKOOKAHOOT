<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participer - QCM en Ligne</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<header>
    <h1>Bienvenue sur notre plateforme de QCM en ligne</h1>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="quiz.php">Participer à un QCM</a>
        <a href="resultats.php">Voir mes résultats</a>
    </nav>
</header>
<body>
<?php

require_once '../Classes/autoloader.php';
require_once '../Classes/Form/Provider.php';

$question_total = 0;
$question_correct = 0;
$score_total = 0;
$score_correct = 0;

$provider = new Classes\Form\QuestionProvider('../Data/questions.JSON');
$questions = $provider->getQuestions();

function question_text($q) {
    echo ($q["text"] . "<br><input type='text' name='$q[name]'><br>");
}

function answer_text($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}

function question_radio($q) {
    $html = $q["text"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='radio' name='$q[name]' value='$c[value]' id='$q[name]-$i'>";
        $html .= "<label for='$q[name]-$i'>$c[text]</label><br>";
    }
    echo $html;
}

function answer_radio($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}

function question_checkbox($q) {
    $html = $q["text"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='checkbox' name='$q[name][]' value='$c[value]' id='$q[name]-$i'>";
        $html .= "<label for='$q[name]-$i'>$c[text]</label><br>";
    }
    echo $html;
}

function answer_checkbox($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    $diff1 = array_diff($q["answer"], $v);
    $diff2 = array_diff($v, $q["answer"]);
    if (count($diff1) == 0 && count($diff2) == 0) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}

$question_handlers = array(
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
);

$answer_handlers = array(
    "text" => "answer_text",
    "radio" => "answer_radio",
    "checkbox" => "answer_checkbox"
);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "<form method='POST' action='quiz.php'><ol>";
    foreach ($questions as $q) {
        echo "<li>";
        $question_handlers[$q["type"]]($q);
        echo "</li>";
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
} else {
    $question_total = 0;
    $question_correct = 0;
    $score_total = 0;
    $score_correct = 0;
    foreach ($questions as $q) {
        $question_total += 1;
        $answer_handlers[$q["type"]]($q, $_POST[$q["name"]] ?? NULL);
    }

    // Affichage des réponses et du score final avec style
    echo "<div class='result'>";
    echo "<p>Réponses correctes: <span class='result-correct'>" . $question_correct . "/" . $question_total . "</span></p>";
    echo "<p>Votre score: <span class='result-score'>" . $score_correct . "/" . $score_total . "</span></p>";
    echo "</div>";
}

$action = $_REQUEST["action"] ?? false;
switch ($action) {
    case "submit":
        break;
    default:
        break;
}

?>
</body>
</html>
