<?php

namespace Src\Classes;

use Model;

class Employee extends Model {

    public $id_employee;
    public $name;
    public $email;
    public $passwd;
    public $active;
    public $reset_password_token;

    public static $definition = [
        'table' => 'employee',
        'primary' => 'id_employee',
        'lang' => false,
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 255],
            'email' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 255],
            'passwd' => ['type' => self::TYPE_STRING, 'validate' => 'isPasswd', 'required' => true, 'size' => 255],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'reset_password_token' => ['type' => self::TYPE_STRING, 'validate' => 'isSha1', 'size' => 40]
        ],
    ];

    public function __construct(mixed $id = null)
    {
        if($id) {
            $this->initObject((int) $id);
        }        
    }


}