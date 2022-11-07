<?php

class TelInputModel extends InputModel
{

    public function __construct(string $id, string $value, string $label, string $placeHolder, bool $require = false)
    {
        parent::__construct($id, 'tel', $value, $label, $placeHolder, $require);
    }

    function generateContent(): string
    {
        return $this->getInputContent();
    }
}
