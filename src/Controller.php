<?php

namespace Src;

use Src\Config\Request;
use Src\Config\Session;
use Src\Config\Theme;

abstract class Controller {

    protected $request;
    protected $theme;
    protected $session;
    protected $form;

    public function __construct()
    {
        $this->request = new Request();
        $this->theme = new Theme();
        $this->session = new Session();
    }

    abstract function setTemplate(): void;

    public function init()
    {
        $this->setTemplate();
        $this->postProcess();
        $this->assignThemeData();
        return $this->theme->init();
    }

    public function redirect($location)
    {
        header('location: ' . $location);
    }

    public function postProcess(){}

    public function assignThemeData()
    {
        $this->theme->data('page', $this->getTemplateVarPage());
        $this->theme->data('form', $this->getTemplateVarForm());
        $this->theme->data('urls', $this->getTemplateVarUrls());
    }
    
    public function getTemplateVarPage(): array
    {
        return [];
    }
    
    public function getTemplateVarForm(): array
    {
        return [];
    }
    
    public function getTemplateVarUrls(): array
    {
        return [
            'base' => HTTP_SERVER,
            'theme_assets' => HTTP_SERVER . 'themes/assets/',
            'theme_img' => HTTP_SERVER . 'themes/assets/img/'
        ];
    }

}