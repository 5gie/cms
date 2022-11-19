<?php

namespace Src\Config;

class Request {

    public function getValue($key)
    {
        $value = false;
        if (isset($_POST[$key]) || isset($_GET[$key])) {
            $value = isset($_POST[$key]) ? $_POST[$key] : $_GET[$key];
        }
        return $value;
    }

    public function files()
    {
        return $_FILES;
    }

    public function getAll()
    {
        return array_merge($_GET, $_POST);
    }

    public function isSubmit($key)
    {
        return isset($_GET[$key]) || isset($_POST[$key]);
    }

}