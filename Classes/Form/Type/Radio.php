<?php
namespace Classes\Form\Type;

final class Radio extends Input {
    protected string $type = 'radio';  // Bouton radio

    public function render(): string {
        return sprintf(
            '<input type="%s" %s value="%s" name="form[%s]" id="%s" %s/>', 
            $this->type,
            $this->isRequired() ? 'required="required"' : '',
            $this->getValue(),
            $this->getName(),
            $this->getId(),
            !empty($this->getValue()) ? 'checked' : ''  // Marquer comme sélectionné si nécessaire
        );
    }
}
?>