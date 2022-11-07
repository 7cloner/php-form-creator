<?php

class SelectInputModel extends BaseInputModel
{

    private array $items;
    private bool $haveNothingItem = false;
    private string $nothingItemTitle = '';

    public function __construct(array $items, string $id, string $value, string $label, string $placeHolder, bool $require = false)
    {
        parent::__construct($id, $value, $label, $placeHolder, $require);
        $this->items = $items;
    }

    private function haveNothingItem(): bool
    {
        return $this->haveNothingItem;
    }

    private function getNothingItemTitle(): string
    {
        return $this->nothingItemTitle;
    }

    public function setupNothingItem(bool $haveNothingItem, string $nothingItemTitle = ''): self
    {
        $this->haveNothingItem = $haveNothingItem;
        $this->nothingItemTitle = $nothingItemTitle;
        return $this;
    }

    private function getSelectOptionItem(bool $isChecked, string $value, string $title): string
    {
        $selected = $isChecked ? 'selected' : '';
        return '<option ' . $selected . ' value="' . $value . '">' . $title . '</option>';
    }

    private function getItemsContent(): string
    {
        $content = $this->haveNothingItem() ? $this->getSelectOptionItem(false, '', $this->getNothingItemTitle()) : '';

        foreach ($this->items as $itemValue => $itemTitle) {
            $content .= $this->getSelectOptionItem($this->getValue() == $itemValue, $itemValue, $itemTitle);
        }

        return $content;
    }

    function generateContent(): string
    {
        return $this->generateLabelContent() . '<select ' . $this->generateInputAttrsValue() . ' >' . $this->getItemsContent() . '</select>';
    }
}