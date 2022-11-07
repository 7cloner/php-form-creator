<?php

class RadioInputModel extends InputModel
{

    public function __construct(bool $checked, string $id, string $value, string $label, string $placeHolder, bool $require = false)
    {
        parent::__construct($id, 'radio', $value, $label, $placeHolder, $require);
        $this->setInputAttrs(['checked' => $checked ? 'checked' : '']);
    }

    function generateContent(): string
    {
        $this->setInputAttrs(['placeholder' => '']);
        return $this->getInputContent() . $this->getPlaceHolder();
    }
}
