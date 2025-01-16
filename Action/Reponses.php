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

    echo '<div class="result">'; // Bloc des résultats
    foreach ($questions as $q) {
        $question_total += 1;
        $answer_handlers[$q->getType()]($q, $post_data[$q->getName()] ?? NULL);
    }

    echo "<p class='result-correct'>Réponses correctes : $question_correct / $question_total</p>";
    echo "<p class='result-score'>Votre score : $score_correct / $score_total</p>";
    echo '</div>';
    
    reponses_questions($questions, $post_data); // Affiche les détails des réponses
}

function reponses_questions($questions, $post_data) {
    global $answer_handlers;

    echo '<div class="content">'; // Bloc contenant les questions et réponses
    foreach ($questions as $q) {
        $post_value = $post_data[$q->getName()] ?? NULL;

        echo '<div class="question-block">';
        echo "<p class='question'>" . htmlspecialchars($q->getText()) . "</p>";

        if (is_array($post_value)) {
            echo "<p class='your-answer'>Votre réponse : " . implode(", ", array_map('htmlspecialchars', $post_value)) . "</p>";
        } else {
            echo "<p class='your-answer'>Votre réponse : " . htmlspecialchars($post_value ?? "Aucune réponse") . "</p>";
        }

        echo "<p class='correct-answer'>Réponse correcte : " . implode(", ", array_map('htmlspecialchars', (array)$q->getAnswer())) . "</p>";
        echo '</div>';
    }
    echo '</div>';
}

?>
