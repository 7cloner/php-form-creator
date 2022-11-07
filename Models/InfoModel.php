<?php

class InfoModel extends BaseInputModel
{

    private string $tagName;

    public function __construct(string $label, string $tagName, string $id = "")
    {
        parent::__construct($id, "", $label, "");
        $this->tagName = $tagName;
    }

    function generateContent(): string
    {
        if(!empty($this->tagName)){
            return "<" . $this->tagName . ' ' . $this->generateInputAttrsValue() . ' >' . $this->getLabel() . '</' . $this->tagName . '>';
        }
        return "";
    }
}