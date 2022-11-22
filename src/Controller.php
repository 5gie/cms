<?php

namespace Src;

use Src\Config\Request;
use Src\Config\Session;
use Src\Config\Theme;

abstract class Controller {

    protected $request;
    protected $theme;
    protected $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->theme = new Theme();
        $this->session = new Session();
        $this->setTemplate();
    }

    abstract function setTemplate(): void;

    public function init()
    {
        return $this->theme->init();
    }

    public function redirect($location)
    {
        header('location: ' . $location);
    }

}