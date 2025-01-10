<!doctype html>
<html>
<head>
<title>Quiz</title>
</head>
<body>
<?php


require_once 'Classes/autoloader.php';
require_once 'Classes/Form/QuestionProvider.php';
require_once 'Action/Questions.php';
require_once 'Action/Reponses.php';

$question_total = 0;
$question_correct = 0;
$score_total = 0;
$score_correct = 0;

$provider = new Classes\Form\QuestionProvider('Data/questions.JSON');
$questions = $provider->getQuestions();
$action = $_GET['action'] ?? null;



?>
</body>
</html>