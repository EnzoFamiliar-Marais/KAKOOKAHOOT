

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - QCM en Ligne</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
</html>

<?php
function answer_text($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q->getScore();
    if (is_null($v)) return;
    if ($q->getAnswer() == $v) {
        $question_correct += 1;
        $score_correct += $q->getScore();
    }
}

function answer_radio($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q->getScore();
    if (is_null($v)) return;
    if ($q->getAnswer() == $v) {
        $question_correct += 1;
        $score_correct += $q->getScore();
    }
}

function answer_checkbox($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q->getScore();
    if (is_null($v)) return;
    $diff1 = array_diff($q->getAnswer(), $v);
    $diff2 = array_diff($v, $q->getAnswer());
    if (count($diff1) == 0 && count($diff2) == 0) {
        $question_correct += 1;
        $score_correct += $q->getScore();
    }
}

$answer_handlers = array(
    "text" => "answer_text",
    "radio" => "answer_radio",
    "checkbox" => "answer_checkbox"
);

session_start();

function verifier_reponses($questions, $post_data) {
    global $question_correct, $score_total, $score_correct, $answer_handlers;
    $question_total = 0;

    $_SESSION['score'] = 0;
    $question_correct = 0;
    $score_total = 0;
    $score_correct = 0;

    foreach ($questions as $q) {
        $question_total += 1;
        $answer_handlers[$q->getType()]($q, $post_data[$q->getName()] ?? NULL);
        if ($post_data[$q->getName()] == $q->getAnswer()) {
            $question_correct += 1;
            $score_correct += $q->getScore();
        }
        $score_total += $q->getScore();
    }

    $_SESSION['score'] = $score_correct;

    reponses_questions($questions, $post_data);
    echo "Réponses correctes: $question_correct/$question_total<br>";
    echo "Votre score: $score_correct/$score_total<br>";
}

function reponses_questions($questions, $post_data) {
    global $answer_handlers;
    foreach ($questions as $q) {
        $post_value = $post_data[$q->getName()] ?? NULL;

        $answer_handlers[$q->getType()]($q, $post_value);

        echo "Question: " . $q->getText() . "<br>";
        if (is_array($post_value)) {
            echo "Votre réponse: " . implode(", ", $post_value) . "<br>";
        } else {
            echo "Votre réponse: " . ($post_value ?? "Aucune réponse") . "<br>";
        }
        echo "Réponse correcte: " . implode(", ", (array)$q->getAnswer()) . "<br><br>";
    }
}

?>
