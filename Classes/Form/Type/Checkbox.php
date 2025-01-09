<?php
namespace Form\Type;

final class Checkbox extends Input {
    protected string $type = 'checkbox';

    // public function __construct(string $name, string $id, string $value, bool $checked = false)
    // {
    //     parent::__construct($name, $id, $value);
    //     $this->checked = $checked;
    //     $this->value = $value;
    //     $this->name = $name;
    //     $this->id = $id;
    // }

    public function render(): string
    {
        return sprintf(
            '<input type="%s" %s value="%s" name="form[%s]" id="%s"/>', 
            $this->type,
            $this->isRequired() ? 'required="required"' : '',
            $this->getValue(),
            $this->getName(),
            $this->getId()
        );
    }

    public function __toString() : string
    {
        return $this->render().PHP_EOL;
    }


}
?>