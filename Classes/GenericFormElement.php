<?php
namespace Classes;

abstract class GenericFormElement {
    protected string $name;
    protected string $id;
    protected $value;
    protected bool $required = false;

    public function __construct(string $name, string $id = null) {
        $this->name = $name;
        $this->id = $id ?? $name;
    }

    public function setValue($value): self {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setId(string $id): self {
        $this->id = $id;
        return $this;
    }

    public function getId(): string {
        return $this->id;
    }

    public function isRequired(): bool {
        return $this->required;
    }

    public function setRequired(bool $required): self {
        $this->required = $required;
        return $this;
    }

    abstract public function render(): string;
}

?>