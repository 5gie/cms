<?php

namespace Src\Config;

class Theme {

    public $template;
    private $data;
    public $admin = false;
    private $layout = 'page';
    private $notifications;

    public function __construct()
    {
        $this->theme_assets = HTTP_SERVER . '/themes/assets/';
    }

    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    public function init()
    {
        return $this->render($this->getLayout());
    }

    public function render($path, $data = [])
    {
        $this->data = array_merge($this->data, $data);
        $path = $this->getDir() . $path . '.html';
        $this->checkTemplate($path);
        include($path);
    }

    private function checkTemplate($path)
    {
        if (!file_exists($path)) {
            throw new \Exception('Template file not found: ' . $path);
        }
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function setLayout($layout)
    {
        return $this->layout = $layout;
    }

    public function getDir()
    {
        return DIRNAME . '/' . ($this->admin ? 'admin' : 'themes') .'/templates/';
    }

    public function addError($key, $value)
    {
        $this->notifications['error'][$key] = $value;
    }

    public function addSuccess($key, $value)
    {
        $this->notifications['success'][$key] = $value;
    }

    public function addInfo($key, $value)
    {
        $this->notifications['info'][$key] = $value;
    }

    public function addWarning($key, $value)
    {
        $this->notifications['warning'][$key] = $value;
    }

    public function getNotifications(): array
    {
        return (array) $this->notifications;
    }

    public function data($key, $value)
    {
        $this->data[$key] = $value;
    }

}