<?php

namespace Controllers\Front;

use Src\Controller;

class IndexController extends Controller{

    public function init()
    {
        return parent::init();
    }

    public function setTemplate(): void
    {
        $this->theme->template = 'pages/index';
    }

    public function getTemplateVarPage(): array
    {
        $vars = parent::getTemplateVarPage();
        $vars['meta_title'] = 'Format Meble'; // TODO
        $vars['meta_description'] = ''; //TODO
        $vars['name'] = 'index';
        return $vars;
    }
}