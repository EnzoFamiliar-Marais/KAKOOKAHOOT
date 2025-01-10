<?php

namespace Classes\Form\Type;


final class Choice {
    private array $value;

    public function __construct(array $value) {
        $this->value = $value;
    }

    public function getValue(): array {
        return $this->value;
    }
}

?>