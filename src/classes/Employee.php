<?php

namespace Src\Classes;

use Src\Config\Db;
use Src\Config\Model;

class Employee extends Model {

    public $id_employee;
    public $name;
    public $email;
    public $password;
    public $active;
    public $reset_password_token;

    public static $definition = [
        'table' => 'employee',
        'primary' => 'id_employee',
        'lang' => false,
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true, 'size' => 255],
            'email' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 255],
            'password' => ['type' => self::TYPE_STRING, 'validate' => 'isPasswd', 'required' => true, 'size' => 255],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'reset_password_token' => ['type' => self::TYPE_STRING, 'validate' => 'isSha1', 'size' => 40],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];

    public function __construct(mixed $id = null)
    {
        if($id) {
            $this->initObject((int) $id);
        }        
    }

    public static function getByEmail(string $email): ?array
    {
        return Db::getInstance()->getOne('SELECT * FROM ' . DB_PREFIX . self::$definition['table'] . ' WHERE email = "'.$email.'"');
    }


}