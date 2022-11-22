<?php

namespace Src\Config;

class Theme {

    public $template;
    public $data;
    public $admin = false;
    private $layout = 'page';
    private $theme_assets;

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

    public function render($path)
    {
        $path = $this->getDir() . $path . '.html';
        $this->checkTemplate($path);
        include_once($path);
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

}