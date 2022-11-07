<?php

class NumberInputModel extends InputModel
{

    public function __construct(string $id, string $value, string $label, string $placeHolder, bool $require = false, int $max = 0, int $min = 0)
    {
        parent::__construct($id, 'number', $value, $label, $placeHolder, $require);
        if($max > 0){
            $this->setInputAttrs(['max' => $max]);
        }
        if($min > 0){
            $this->setInputAttrs(['min' => $min]);
        }
    }

    function generateContent(): string
    {
        return $this->getInputContent();
    }
}
