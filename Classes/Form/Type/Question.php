<?php
namespace Classes\Form;

class Question {
    private $name;
    private $type;
    private $text;
    private $choices;
    private $answer;
    private $score;

    public function __construct($name, $type, $text, $answer, $score, $choices = []) {
        $this->name = $name;
        $this->type = $type;
        $this->text = $text;
        $this->choices = $choices;
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
