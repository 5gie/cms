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
}