<?php

class CheckBoxInputModel extends InputModel
{

    public function __construct(bool $checked, string $id, string $value, string $label, string $placeHolder, bool $require = false)
    {
        parent::__construct($id, 'checkbox', $value, $label, $placeHolder, $require);
        $this->setInputAttrs(['checked' => $checked ? 'checked' : '']);
    }

    function generateContent(): string
    {
        $this->setInputAttrs(['placeholder' => '']);
        return $this->getInputContent() . $this->getPlaceHolder();
    }
}
