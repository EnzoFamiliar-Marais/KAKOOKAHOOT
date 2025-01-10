<?php
namespace Classes\Form\Type;


use Classes\Form\Type\Choices;

require_once __DIR__ . '/Choices.php';
var_dump(class_exists('Classes\Form\Type\Choices'));
var_dump(__DIR__ . '/Choices.php');

class Question {
    private $name;
    private $type;
    private $text;
    private $choices;
    private $answer;
    private $score;

    public function __construct($name, $type, $text, $answer, $score, array $choices = []) {
        $this->name = $name;
        $this->type = $type;
        $this->text = $text;
        $this->choices = new Choices($choices);
        $this->answer = $answer;
        $this->score = $score;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getText() {
        return $this->text;
    }

    public function getChoices() {
        return $this->choices;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getScore() {
        return $this->score;
    }
}
?>
