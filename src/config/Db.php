<?php

namespace Src\Config;

use PDO;
use PDOException;

class Db
{
    // DB Params
    private $host = 'localhost';
    private $db_name = 'format';
    private $username = 'root';
    private $password = '';
    private $conn = null;
    private $stmt = null;

    public function __construct()
    {
        try {

            $this->conn = new PDO('mysql:host=' .$this->host . ';dbname=' .$this->db_name,$this->username,$this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

        } catch (PDOException $e) {

            die('Wystąpił nieoczekiwany błąd.');

        }
    }

    public static function getInstance()
    {
        return new self;
    }

    public function insert(string $table, array $data): bool
    {
        $table = DB_PREFIX . $table;

        // Check if $data is a list of row
        $current = current($data);
        if (!is_array($current) || isset($current['type'])) {
            $data = [$data];
        }

        $keys = [];
        $values_stringified = [];
        foreach ($data as $row_data) {
            $values = [];
            foreach ($row_data as $key => $value) {

                $keys[] = '`' . $key . '`';

                if (!is_array($value)) {
                    $value = ['type' => 'text', 'value' => $value];
                }
                if ($value['type'] == 'sql') {
                    $values[] = $value['value'];
                } else {
                    $values[] = $value['value'] === '' || null === $value['value'] ? 'NULL' : "'{$value['value']}'";
                }
            }
            $values_stringified[] = '(' . implode(', ', $values) . ')';
        }
        $keys_stringified = implode(', ', $keys);

        $sql = 'INSERT INTO `' . $table . '` (' . $keys_stringified . ') VALUES ' . implode(', ', $values_stringified);

        return (bool) $this->query($sql);
    }

    public function update(string $table, array $data, string $where = '', int $limit = 0)
    {
        $table = DB_PREFIX . $table;

        $sql = 'UPDATE `' . $table . '` SET ';
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $value = ['type' => 'text', 'value' => $value];
            }
            if ($value['type'] == 'sql') {
                $sql .= '`' . $key . "` = {$value['value']},";
            } else {
                $sql .= ($value['value'] === '' || null === $value['value']) ? '`' . $key . '` = NULL,' : '`' . $key . "` = '{$value['value']}',";
            }
        }

        $sql = rtrim($sql, ',');
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        if ($limit) {
            $sql .= ' LIMIT ' . (int) $limit;
        }

        return (bool) $this->query($sql);
    }

    public function delete(string $table, string $where = '', int $limit = 0)
    {
        $table = DB_PREFIX . $table;
        $sql = 'DELETE FROM `' . $table . '`' . ($where ? ' WHERE ' . $where : '') . ($limit ? ' LIMIT ' . (int) $limit : '');
        $res = $this->query($sql);

        return (bool) $res;
    }

    public function findOne($where = ''): mixed
    {
        $sql = 'SELECT * FROM `' . $this->table . '` ' . (!empty($where) ? 'WHERE ' . $where : '') . 'LIMIT 1';

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($where = '', $limit = 0): mixed
    {
        return $this->query('SELECT * FROM `' . $this->table . '` ' . (!empty($where) ? 'WHERE ' . $where : '') . ($limit ? 'LIMIT ' . $limit : ''));
    }

    public function query(string $sql): mixed
    {
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}