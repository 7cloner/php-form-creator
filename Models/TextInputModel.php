<?php

class TextInputModel extends InputModel
{

    public function __construct(string $id, string $value, string $label, string $placeHolder, bool $require = false, int $maxLength = 0)
    {
        parent::__construct($id, 'text', $value, $label, $placeHolder, $require);
        if($maxLength > 0){
            $this->setInputAttrs(['maxlength' => $maxLength]);
        }
    }

    function generateContent(): string
    {
        return $this->getInputContent();
    }
}
