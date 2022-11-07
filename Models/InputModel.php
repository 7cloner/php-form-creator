<?php

abstract class InputModel extends BaseInputModel
{

    public function __construct(string $id, string $type, string $value, string $label, string $placeHolder, bool $require = false)
    {
        parent::__construct($id, $value, $label, $placeHolder, $require);
        $this->setInputAttrs(['type' => $type]);
    }

    protected function getInputContent(): string{
        return $this->generateLabelContent() .
            "<input " . $this->generateInputAttrsValue() . " value='" . $this->getValue() . "'";
    }

    abstract function generateContent(): string;
}