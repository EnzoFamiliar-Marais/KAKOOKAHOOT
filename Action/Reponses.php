<?php
function answer_text($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
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
        $answer_handlers[$q["type"]]($q, $post_data[$q["name"]] ?? NULL);
    }

    echo "Réponses correctes: $question_correct/$question_total<br>";
    echo "Votre score: $score_correct/$score_total<br>";
}
?>
