<?php

namespace Src\Config;

class Theme {

    public $template;
    public $data;
    public $admin = false;
    private $layout = 'page';

    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    public function render()
    {
        $path = $this->getLayout();
        $this->checkTemplate($path);
        include_once($path);
    }

    public function renderTemplate()
    {
        $path = $this->getTemplate();
        $this->checkTemplate($path);
        include_once($path);
    }

    public function renderHeader()
    {
        $header = $this->getHeader();
        $this->checkTemplate($header);
        include_once($header);
    }

    public function renderFooter()
    {
        $footer = $this->getFooter();
        $this->checkTemplate($footer);
        include_once($footer);
    }

    private function checkTemplate($path)
    {
        if (!file_exists($path)) {
            throw new \Exception('Template file not found: ' . $path);
        }
    }

    public function getTemplate()
    {
        return DIRNAME . '/'.$this->getDir().'/templates/' . $this->template . '.html';
    }

    public function getLayout()
    {
        return DIRNAME . '/'.$this->getDir().'/templates/'. $this->layout .'.html';
    }

    public function setLayout($layout)
    {
        return $this->layout = $layout;
    }

    public function getHeader()
    {
        return DIRNAME . '/'.$this->getDir().'/templates/_partials/header.html';
    }

    public function getFooter()
    {
        return DIRNAME . '/'.$this->getDir().'/templates/_partials/footer.html';
    }

    public function getDir()
    {
        return $this->admin ? 'admin' : 'themes';
    }

}