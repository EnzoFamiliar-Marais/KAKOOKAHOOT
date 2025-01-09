<?php
namespace Classes\Form;

class QuestionProvider {
    private $questions;

    public function __construct($filePath) {
        $this->questions = json_decode(file_get_contents($filePath), true);
    }

    public function getQuestions() {
        return $this->questions;
    }
}
?>