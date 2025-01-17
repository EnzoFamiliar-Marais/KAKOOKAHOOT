<?php


session_start();

if ($_SESSION['name'] == null){
    header("Location: ../index.php");
    exit();
} 
// Définir le fichier JSON pour stocker les questions
$jsonFile = 'quiz.json';

$questions = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Ajouter une nouvelle question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $type = $_POST['type'] ?? 'text';
    $text = $_POST['text'] ?? 'Nouvelle question';
    $choices = isset($_POST['choices']) ? array_map('trim', explode("\n", $_POST['choices'])) : [];
    $answer = $_POST['answer'] ?? '';

    // Préparer une nouvelle question en fonction du type
    $newQuestion = [
        "name" => "question_" . (count($questions) + 1),
        "type" => $type,
        "text" => $text,
        "answer" => $type === 'checkbox' ? explode(',', $answer) : $answer,
        "score" => (int)($_POST['score'] ?? 1),
    ];

    // Ajouter les choix si c'est une question à choix
    if (in_array($type, ['radio', 'checkbox']) && !empty($choices)) {
        $newQuestion['choices'] = array_map(function ($choice) {
            return ["text" => $choice, "value" => strtolower($choice)];
        }, $choices);
    }

    $questions[] = $newQuestion;
    file_put_contents($jsonFile, json_encode($questions, JSON_PRETTY_PRINT));
}

// Supprimer la dernière question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_question'])) {
    array_pop($questions);
    file_put_contents($jsonFile, json_encode($questions, JSON_PRETTY_PRINT));
}

// Générer le fichier JSON pour téléchargement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_json'])) {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="quiz.json"');
    echo json_encode($questions, JSON_PRETTY_PRINT);
    exit; // Stop further execution to directly download the file
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un quiz</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../Templates/header.php'; ?>
    <h1 class="title">Création d'un quiz</h1>

    <div id="quiz-container">
        <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-block">
                    <h3>Question <?= $index + 1 ?> (<?= htmlspecialchars($question['type']) ?>)</h3>
                    <p><?= htmlspecialchars($question['text']) ?></p>
                    <?php if ($question['type'] === 'text'): ?>
                        <input type="text" placeholder="Votre réponse">
                    <?php elseif (in_array($question['type'], ['radio', 'checkbox'])): ?>
                        <?php foreach ($question['choices'] as $choice): ?>
                            <label>
                                <input type="<?= htmlspecialchars($question['type']) ?>" name="<?= htmlspecialchars($question['name']) ?>" value="<?= htmlspecialchars($choice['value']) ?>">
                                <?= htmlspecialchars($choice['text']) ?>
                            </label><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune question disponible.</p>
        <?php endif; ?>
    </div>

    <form method="POST">
        <h2>Ajouter une nouvelle question</h2>
        <label for="text">Texte de la question :</label><br>
        <textarea name="text" id="text" rows="3" required></textarea><br>

        <label for="type">Type de question :</label><br>
        <select name="type" id="type" required>
            <option value="text">Champ libre</option>
            <option value="radio">Choix unique</option>
            <option value="checkbox">Choix multiple</option>
        </select><br>

        <div id="choices-container" style="display: none;">
            <label for="choices">Choix possibles (un par ligne) :</label><br>
            <textarea name="choices" id="choices" rows="3"></textarea><br>
        </div>

        <label for="answer">Réponse (séparée par des virgules pour choix multiples) :</label><br>
        <input type="text" name="answer" id="answer"><br>

        <label for="score">Score :</label><br>
        <input type="number" name="score" id="score" value="1" min="1"><br><br>

        <button type="submit" name="add_question">Ajouter la question</button>
    </form>

    <!-- Formulaire pour autres actions -->
    <form method="POST" style="margin-top: 20px;">
        <button type="submit" name="remove_question">Enlever une question</button>
        <button type="submit" name="generate_json">Créer un questionnaire JSON</button>
    </form>

    <script>
        // Affiche ou masque le champ des choix selon le type sélectionné
        document.getElementById('type').addEventListener('change', function () {
            const choicesContainer = document.getElementById('choices-container');
            choicesContainer.style.display = this.value === 'text' ? 'none' : 'block';
        });
    </script>
</body>
</html>