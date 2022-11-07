<?php

class TextAreaModel extends BaseInputModel
{

    function generateContent(): string
    {
        return $this->generateLabelContent() . "<textarea " . $this->generateInputAttrsValue() . ">" . $this->getValue() . "</textarea>";
    }
}