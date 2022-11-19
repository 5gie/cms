<?php

namespace Src\Config;

use PDO;
use PDOException;

class Db
{
    // DB Params
    static private $host = 'localhost';
    static private $db_name = 'format';
    static private $username = 'root';
    static private $password = '';
    static private $conn = null;

    public function __construct()
    {
        try {

            self::$conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name, self::$username, self::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

        } catch (PDOException $e) {

            die('Wystąpił nieoczekiwany błąd.');

        }

        return self::$conn;
    }

    public static function getInstance()
    {
        return new self;
    }
    
}