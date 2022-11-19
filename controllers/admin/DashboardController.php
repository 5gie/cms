<?php

namespace Controllers\Admin;

use Src\AdminController;

class DashboardController extends AdminController {

    public function init()
    {
        return parent::init();
    }

    public function setTemplate(): void
    {
        $this->theme->template = 'pages/dashboard';
    }

}