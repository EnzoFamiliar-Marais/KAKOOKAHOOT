<!doctype html>
<html>
<head>
<title>Quiz</title>
</head>
<body>
<?php

require_once 'Classes/autoloader.php';
require_once 'Classes/Form/Provider.php';

$question_total = 0;
$question_correct = 0;
$score_total = 0;
$score_correct = 0;

$provider = new Classes\Form\QuestionProvider('Data/questions.JSON');
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
        $html .= "<label for='$q[name]-$i'>$c[text]</label>";
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
        $html .= "<label for='$q[name]-$i'>$c[text]</label>";
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
    echo "<form method='POST' action='index.php'><ol>";
    foreach ($questions as $q) {
        echo "<li>";
        $question_handlers[$q["type"]]($q);
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

    
    $id = 0;
    $reponse = "";
    foreach ($answer_handlers as $q) {
        if (is_array($questions[$id]["answer"])){
            foreach ($questions[$id]["answer"] as $q) {
                $reponse .= $q . " ";
            }
            echo "Reponse à la question  : " . $reponse . "<br>";
        }
        else {
            echo "Reponse à la question  : " . $questions[$id]["answer"] . "<br>";
        }
        
        $id ++ ;
    }
    echo "Réponses correctes: " . $question_correct . "/" . $question_total . "<br>";
    echo "Votre score: " . $score_correct . "/" . $score_total . "<br>";
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