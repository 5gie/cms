<?php

use Src\Config\Db;
use Src\Config\Translator;

abstract class Model {

    const TYPE_INT = 1;
    const TYPE_BOOL = 2;
    const TYPE_STRING = 3;
    const TYPE_FLOAT = 4;
    const TYPE_DATE = 5;
    const TYPE_HTML = 6;

    public static $definition;
    private array $errors;

    public function __construct()
    {
        if(empty(self::$definition) || !isset(self::$definition['table'])){
            throw new \Exception('This object requires definition array');
        }
        $this->table = self::$definition['table'];
    }

    public function insert(): bool
    {
        if(!$this->validate()){
            return false;
        }

        $data = $this->getFields();

        return (bool) Db::getInstance()->insert(self::$definition['table'], $data);
    }

    public function update(string $where = '', int $limit = 0): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $data = $this->getFields();

        return (bool) Db::getInstance()->update(self::$definition['table'], $data, $where, $limit);
    }

    public function validate(): bool
    {
        foreach(self::$definition as $field){

            if($field['required'] && empty($this->{$field['name']})){
                $this->errors[$field['name']] = Translator::trans('%s is required', [$field['name']]);
            } else if(isset($field['size']) && strlen($this->{$field['size']}) > $field['size']){
                $this->errors[$field['name']] = Translator::trans('%s must not be longer than %s characters', $field['name'], $field['size']);
            } else if(isset($field['validate']) && Validate::{$field['validate']}($this->{$field['name']})){
                $this->errors[$field['name']] = Translator::trans('%s has the wrong format', $field['name']);
            }

        }

        return (bool) count($this->errors);
    }

    /**
     * get vars by definition
     */
    public function getFields(): array
    {
        $output = [];
        foreach(self::$definition as $field)
        {
            $output[$field['name']] = $this->{$field['name']};
        }
        return $output;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }

    public function initObject(int $id)
    {
        $where = self::$definition['primary'] . ' = ' . $id;
        if($data = Db::getInstance()->findOne($where)){
            
            foreach($data as $key => $value){
                if(property_exists($this, $key)){
                    $this->{$key} = $value;
                }
            }

            $this->id = $id;
        }
    }

}