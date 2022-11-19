<?php

abstract class Model {

    private $table;

    public function __construct($table)
    {
        $this->table = $this->getTable();
    }

    abstract function getTable(): string;

}