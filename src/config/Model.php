<?php

namespace Src\Config;

use Src\Helpers\Validate;

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
        if(empty(static::$definition) || !isset(static::$definition['table'])){
            throw new \Exception('This object requires definition array');
        }
    }

    public function insert($auto_dates = true): bool
    {
        if(!$this->validate()){
            return false;
        }

        if($auto_dates){
            $this->date_add = date('Y-m-d H:i:s');
            $this->date_upd = date('Y-m-d H:i:s');
        }

        $data = $this->getFields();
        
        return (bool) Db::getInstance()->insert(static::$definition['table'], $data);
    }

    public function update(string $where = '', $auto_dates = true, int $limit = 0): bool
    {
        if (!$this->validate()) {
            return false;
        }

        if ($auto_dates) {
            $this->date_upd = date('Y-m-d H:i:s');
        }

        $data = $this->getFields();

        return (bool) Db::getInstance()->update(static::$definition['table'], $data, $where, $limit);
    }

    public function findOne($where = ''): mixed
    {
        $sql = 'SELECT * FROM `' . DB_PREFIX . static::$definition['table'] . '` ' . (!empty($where) ? 'WHERE ' . $where : '') . 'LIMIT 1';

        return Db::getInstance()->getOne($sql);
    }

    public function findAll($where = '', $limit = 0): mixed
    {
        return Db::getInstance()->getAll('SELECT * FROM `' . DB_PREFIX . static::$definition['table'] . '` ' . (!empty($where) ? 'WHERE ' . $where : '') . ($limit ? 'LIMIT ' . $limit : ''));
    }

    public function validate(): bool
    {
        foreach(static::$definition['fields'] as $name => $field){

            if(isset($field['required']) && empty($this->{$name})){
                $this->errors[$name] = Translator::trans('%s is required', [$name]);
            } else if(isset($field['size']) && strlen($this->{$name}) > $field['size']){
                $this->errors[$name] = Translator::trans('%s must not be longer than %s characters', $name, $field['size']);
            } else if((isset($field['required']) || !empty($this->{$name})) && isset($field['validate']) && Validate::{$field['validate']}($this->{$name})){
                $this->errors[$name] = Translator::trans('%s has the wrong format', $name);
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
        foreach(static::$definition['fields'] as $name => $field)
        {
            $output[$name] = $this->{$name};
        }
        return $output;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }

    public function initObject(int $id)
    {
        $where = static::$definition['primary'] . ' = ' . $id;
        if($data = $this->findOne($where)){
            
            foreach($data as $key => $value){
                if(property_exists($this, $key)){
                    $this->{$key} = $value;
                }
            }

            $this->id = $id;
        }
    }

}