<?php

abstract class BaseInputModel
{

    private string $beforeFieldBody = '';
    private string $afterFieldBody = '';
    private string $id;
    private string $name;
    private string $value;
    private string $label;
    private string $placeHolder;
    private bool $require;
    private array $attrs = [];
    private array $labelAttrs = [];

    public function __construct(string $id, string $value, string $label, string $placeHolder, bool $require = false)
    {
        $this->id = $id;
        $this->name = $id;
        $this->value = $value;
        $this->label = $label;
        $this->placeHolder = $placeHolder;
        $this->require = $require;
        $this->attrs['name'] = $this->name;
    }

    public function setBeforeFieldBody(string $beforeFieldBody): self
    {
        $this->beforeFieldBody = $beforeFieldBody;
        return $this;
    }

    public function setAfterFieldBody(string $afterFieldBody): self
    {
        $this->afterFieldBody = $afterFieldBody;
        return $this;
    }

    public function getBeforeFieldBody(): string {
        return $this->beforeFieldBody;
    }

    public function getAfterFieldBody(): string {
        return $this->afterFieldBody;
    }

    protected function getId(): string{
        return $this->id;
    }

    protected function getValue(): string{
        return $this->value;
    }

    protected function getLabel(): string{
        return $this->label;
    }

    protected function getPlaceHolder(): string{
        return $this->placeHolder;
    }

    protected function isRequired(): bool {
        return $this->require;
    }

    protected function getName(): string {
        return $this->name;
    }

    private function getLabelAttrs(): array
    {
        return $this->labelAttrs;
    }

    private function getInputAttrs(): array
    {
        $this->attrs['required'] = $this->isRequired() ? 'required' : '';
        $this->attrs['id'] = $this->getId();
        $this->attrs['placeHolder'] = $this->getPlaceHolder();

        return $this->attrs;
    }

    private function getAttrsValue(array $attrsList): string
    {
        $attrs = "";
        foreach ($attrsList as $attrKey => $attrValue) {
            if (!empty($attrValue)) {
                $attrs .= "$attrKey=\"$attrValue\" ";
            }
        }

        return $attrs;
    }

    public function setLabelAttrs(array $attrs): self
    {
        if (!empty($attrs)) {
            $this->labelAttrs = array_merge($attrs, $this->labelAttrs);
        }
        return $this;
    }

    public function setInputAttrs(array $attrs): self
    {
        if (!empty($attrs)) {
            $this->attrs = array_merge($attrs, $this->attrs);

            if (isset($attrs['name'])) {
                $this->attrs['name'] = $attrs['name'];
                $this->name = $attrs['name'];
            }
        }
        return $this;
    }

    protected function joinArrayKeysAndValues(array $data, string $joiner, string $separator): string
    {
        $content = '';
        foreach ($data as $key => $value) {
            $content .= $key . $joiner . $value . $separator;
        }

        return $content;
    }

    protected function generateLabelAttrsValue(): string {
        return $this->getAttrsValue($this->getLabelAttrs());
    }

    protected function generateInputAttrsValue(): string {
        return $this->getAttrsValue($this->getInputAttrs());
    }

    protected function generateLabelContent(): string
    {
        if (!empty($this->getLabel())) {
            return '<label ' . $this->generateLabelAttrsValue() . ' for="' . $this->getId() . '">' . $this->getLabel() . '</label>';
        }
        return "";
    }

    abstract function generateContent(): string;
}