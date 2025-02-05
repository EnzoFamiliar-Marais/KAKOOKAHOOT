<?php

namespace Form\Type;
use Classes\GenericFormElement;
final class Textarea extends GenericFormElement
{
    public function render(): string
    {
        return sprintf(
            '<textarea name="form[%s]" %s id="%s">%s<textarea/>', 
            $this->getName(),
            $this->isRequired() ? 'required="required"' : '',
            $this->getId(),
            $this->getValue(),
        );
    }
}
?>