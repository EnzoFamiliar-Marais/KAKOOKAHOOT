<?php
function question_text($q) {
    echo ($q["text"] . "<br><input type='text' name='$q[name]'><br>");
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
        $question_handlers[$q["type"]]($q);
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
}
?>
