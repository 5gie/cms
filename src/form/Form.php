<?php

class Form
{
    protected $translator;
    protected $constraintTranslator;

    protected $action;
    protected $template;

    protected $formatter;

    protected $formFields = [];
    protected $errors = ['' => []];

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getErrors()
    {
        foreach ($this->formFields as $field) {
            $this->errors[$field->getName()] = $field->getErrors();
        }

        return $this->errors;
    }

    public function hasErrors()
    {
        foreach ($this->getErrors() as $errors) {
            if (!empty($errors)) {
                return true;
            }
        }

        return false;
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function validate()
    {
        foreach ($this->formFields as $field) {
            if ($field->isRequired()) {
                if (!$field->getValue()) {
                    $field->addError(
                        $this->constraintTranslator->translate('required')
                    );

                    continue;
                } elseif (!$this->checkFieldLength($field)) {
                    $field->addError(
                        $this->translator->trans(
                            'The %1$s field is too long (%2$d chars max).',
                            [$field->getLabel(), $field->getMaxLength()],
                            'Shop.Notifications.Error'
                        )
                    );
                }
            } elseif (!$field->isRequired()) {
                if (!$field->getValue()) {
                    continue;
                } elseif (!$this->checkFieldLength($field)) {
                    $field->addError(
                        $this->translator->trans(
                            'The %1$s field is too long (%2$d chars max).',
                            [$field->getLabel(), $field->getMaxLength()],
                            'Shop.Notifications.Error'
                        )
                    );
                }
            }
        }

        return !$this->hasErrors();
    }

    public function fillWith(array $params = [])
    {
        $newFields = $this->formatter->getFormat();

        foreach ($newFields as $field) {
            if (array_key_exists($field->getName(), $this->formFields)) {
                // keep current value if set
                $field->setValue($this->formFields[$field->getName()]->getValue());
            }

            if (array_key_exists($field->getName(), $params)) {
                // overwrite it if necessary
                $field->setValue($params[$field->getName()]);
            } elseif ($field->getType() === 'checkbox') {
                // checkboxes that are not submitted
                // are interpreted as booleans switched off
                if (empty($field->getValue())) {
                    $field->setValue(false);
                }
            }
        }

        $this->formFields = $newFields;

        return $this;
    }

    public function getField($field_name)
    {
        if (array_key_exists($field_name, $this->formFields)) {
            return $this->formFields[$field_name];
        }

        return null;
    }

    public function getValue($field_name)
    {
        if ($field = $this->getField($field_name)) {
            return $field->getValue();
        }

        return null;
    }

    public function setValue($field_name, $value)
    {
        $this->getField($field_name)->setValue($value);

        return $this;
    }

    protected function checkFieldLength($field)
    {
        $error = $field->getMaxLength() != null && strlen($field->getValue()) > (int) $field->getMaxLength();

        return !$error;
    }
}
