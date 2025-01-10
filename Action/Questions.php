<?php


function question_text($q) {
    echo ($q->getText() . "<br><input type='text' name='" . $q->getName() . "'><br>");
}

function question_radio($q) {
    $html = $q->getText() . "<br>";
    $i = 0;
    foreach ($q->getChoices() as $c) {
        $i += 1;
        $html .= "<input type='radio' name='" . $q->getName() . "' value='" . $c["value"] . "' id='" . $q->getName() . "-$i'>";
        $html .= "<label for='" . $q->getName() . "-$i'>" . $c["text"] . "</label><br>";
    }
    echo $html;
}

function question_checkbox($q) {
    $html = $q->getText() . "<br>";
    $i = 0;
    foreach ($q->getChoices() as $c) {
        $i += 1;
        $html .= "<input type='checkbox' name='" . $q->getName() . "[]' value='" . $c["value"] . "' id='" . $q->getName() . "-$i'>";
        $html .= "<label for='" . $q->getName() . "-$i'>" . $c["text"] . "</label><br>";
    }
    echo $html;
}

$question_handlers = array(
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
);

function afficher_questions($questions) {
    global $question_handlers;
    echo "<form method='POST' action='index.php'><ol>";
    foreach ($questions as $q) {
        echo "<li>";
        if (isset($question_handlers[$q->getType()])) {
            $question_handlers[$q->getType()]($q);
        } else {
            echo "Type de question inconnu : " . htmlspecialchars($q->getType());
        }
        echo "</li>";
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
}
