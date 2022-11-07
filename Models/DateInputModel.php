<?php

class DateInputModel extends InputModel
{

    public function __construct(string $id, string $value, string $label, string $placeHolder, bool $require = false)
    {
        parent::__construct($id, 'calender', $value, $label, $placeHolder, $require);
    }

    function generateContent(): string
    {
        return $this->getInputContent();
    }
}
