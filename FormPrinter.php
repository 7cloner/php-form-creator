<?php

abstract class FormPrinter
{

    const FIELD_TYPE = 'field_type';
    const FIELD_ID = 'field_id';
    const FIELD_VALUE = 'field_value';
    const FIELD_LABEL = 'field_label';
    const FIELD_PLACEHOLDER = 'field_placeholder';
    const FIELD_REQUIRED = 'field_required';
    const FIELD_CHECKED = 'field_checked';
    const FIELD_MAXLENGTH = 'field_maxlength';
    const FIELD_MAX = 'field_max';
    const FIELD_MIN = 'field_min';
    const FIELD_TAG = 'field_tag';
    const FIELD_ITEMS = 'field_items';
    const FIELD_NOTHING_TITLE = 'field_nothing_title';
    const FIELD_AFTER_FIELD_BODY = 'field_after_field_body';
    const FIELD_BEFORE_FIELD_BODY = 'field_before_field_body';
    const FIELD_INPUT_ATTRS = 'field_input_attrs';
    const FIELD_LABEL_ATTRS = 'field_label_attrs';
    private array $checkBoxBody;
    private array $emailBody;
    private array $numberBody;
    private array $radioBody;
    private array $selectBody;
    private array $telBody;
    private array $textAreaBody;
    private array $textBody;
    private array $calenderBody;

    public function __construct(array $checkBoxBody, array $emailBody, array $numberBody, array $radioBody, array $selectBody, array $calenderBody, array $telBody, array $textAreaBody, array $textBody)
    {
        $this->checkBoxBody = $checkBoxBody;
        $this->emailBody = $emailBody;
        $this->numberBody = $numberBody;
        $this->radioBody = $radioBody;
        $this->selectBody = $selectBody;
        $this->telBody = $telBody;
        $this->textAreaBody = $textAreaBody;
        $this->textBody = $textBody;
        $this->calenderBody = $calenderBody;
    }

    protected function printField(array $fieldInfo): void
    {
        if (isset($fieldInfo[self::FIELD_TYPE])) {
            $fieldType = $fieldInfo[self::FIELD_TYPE];

            if ($this->isSupportedFieldType($fieldType)) {
                $field = $this->getFieldModel($fieldType, $fieldInfo);

                if ($field instanceof BaseInputModel) {
                    echo $field->getBeforeFieldBody();
                    $body = $this->getFieldBody($fieldType);
                    echo !is_null($body) && count($body) > 0 ? $body[0] : '';
                    echo $field->generateContent();
                    echo !is_null($body) && count($body) > 1 ? $body[1] : '';
                    echo $field->getAfterFieldBody();
                }
            }
        }
    }

    private function getFieldModel($fieldType, $fieldInfo): ?BaseInputModel
    {
        if ($this->isSupportedFieldType($fieldType)) {
            $model = $this->findAndInitModel($fieldType, $fieldInfo);
            if ($model instanceof BaseInputModel) {
                $model->setAfterFieldBody($fieldType[self::FIELD_AFTER_FIELD_BODY] ?? '');
                $model->setBeforeFieldBody($fieldType[self::FIELD_BEFORE_FIELD_BODY] ?? '');
                $model->setInputAttrs($fieldType[self::FIELD_INPUT_ATTRS] ?? '');
                $model->setLabelAttrs($fieldType[self::FIELD_LABEL_ATTRS] ?? '');

                return $model;
            }
        }
        return null;
    }

    private function findAndInitModel(string $fieldType, array $fieldInfo): ?BaseInputModel
    {
        $id = $fieldInfo[self::FIELD_ID] ?? 'tid' . rand(100000, 999999);
        $value = $fieldInfo[self::FIELD_VALUE] ?? '';
        $label = $fieldInfo[self::FIELD_LABEL] ?? '';
        $placeholder = $fieldInfo[self::FIELD_PLACEHOLDER] ?? '';
        $required = $fieldInfo[self::FIELD_REQUIRED] ?? false;
        $checked = $fieldInfo[self::FIELD_CHECKED] ?? false;

        switch ($fieldType) {
            case 'text':
                return (new TextInputModel($id, $value, $label, $placeholder, $required, $fieldInfo[self::FIELD_MAXLENGTH] ?? 0));
            case 'number':
                return (new NumberInputModel($id, $value, $label, $placeholder, $required, $fieldInfo[self::FIELD_MAX] ?? 0, $fieldInfo[self::FIELD_MIN] ?? 0));
            case 'tag':
                return (new InfoModel($label, $fieldInfo[self::FIELD_TAG] ?? '', $id));
            case 'textarea':
                return (new TextAreaModel($id, $value, $label, $placeholder, $required));
            case 'email':
                return (new EmailInputModel($id, $value, $label, $placeholder, $required));
            case 'tel':
                return (new TelInputModel($id, $value, $label, $placeholder, $required));
            case 'calender':
            case 'date':
                return (new DateInputModel($id, $value, $label, $placeholder, $required));
            case 'checkbox':
                return (new CheckBoxInputModel($checked, $id, $value, $label, $placeholder, $required));
            case 'radio':
                return (new RadioInputModel($checked, $id, $value, $label, $placeholder, $required));
            case 'select':
                $nothingItemTitle = $fieldInfo[self::FIELD_NOTHING_TITLE];
                return (new SelectInputModel($fieldInfo[self::FIELD_ITEMS] ?? [], $id, $value, $label, $placeholder, $required))
                    ->setupNothingItem(!empty($nothingItemTitle), $nothingItemTitle);
        }
        return null;
    }

    private function isSupportedFieldType(string $fieldType): bool
    {
        return !empty($fieldType) && in_array($fieldType,
                ['text', 'number', 'tag', 'textarea', 'email', 'tel', 'calender', 'date', 'checkbox', 'radio', 'select']);
    }

    private function getFieldBody(string $fieldType): ?array
    {
        return [
            'text' => $this->textBody,
            'number' => $this->numberBody,
            'tag' => null,
            'textarea' => $this->textAreaBody,
            'email' => $this->emailBody,
            'tel' => $this->telBody,
            'calender' => $this->calenderBody,
            'checkbox' => $this->checkBoxBody,
            'radio' => $this->radioBody,
            'select' => $this->selectBody
        ][$fieldType] ?? null;
    }

    public function printFields(array $fields): void
    {
        $this->beforePrint($fields);
        foreach ($fields as $field) {
            $fieldType = $field[self::FIELD_TYPE] ?? '';
            if ($this->isSupportedFieldType($fieldType)) {
                $this->beforePrintField($fieldType, $field);
                $this->printField($field);
                $this->afterPrintField($fieldType, $field);
            }
        }
        $this->afterPrint($fields);
    }

    abstract protected function beforePrint(array $fields): void;

    abstract protected function afterPrint(array $fields): void;

    abstract protected function beforePrintField(string $fieldType, array $fieldInfo): void;

    abstract protected function afterPrintField(string $fieldType, array $fieldInfo): void;

}
