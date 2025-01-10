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

function verifier_reponses($questions, $post_data) {
    global $question_correct, $score_total, $score_correct, $answer_handlers;
    $question_total = 0;

    foreach ($questions as $q) {
        $question_total += 1;
        $answer_handlers[$q->getType()]($q, $post_data[$q->getName()] ?? NULL);
    }

    reponses_questions($questions, $post_data);
    echo "Réponses correctes: $question_correct/$question_total<br>";
    echo "Votre score: $score_correct/$score_total<br>";
}

function reponses_questions($questions, $post_data) {
    global $answer_handlers;
    foreach ($questions as $q) {
        $answer_handlers[$q->getType()]($q, $post_data[$q->getName()] ?? NULL);
        echo "Question: " . $q->getText() . "<br>";
        if (is_array($post_data[$q->getName()])) {
            echo "Votre réponse: " . implode(", ", $post_data[$q->getName()]) . "<br>";
        } else
        echo "Votre réponse: " . ($post_data[$q->getName()] ?? "Aucune réponse") . "<br>";
        echo "Réponse correcte: " . implode(", ", (array)$q->getAnswer()) . "<br><br>";
    }
}

?>
