<?php

namespace Controllers\Admin;

use Src\AdminController;

class AdminAuthController extends AdminController
{

    public function init()
    {
        $this->theme->setLayout('login');
        if($this->request->isSubmit('submitLogin')){
            $this->postProcess();
        } 
        return parent::init();
    }

    public function setTemplate(): void
    {
        $this->theme->template = 'pages/dashboard';
    }

    /**
     * TODO: validate this
     */
    public function postProcess() 
    {
        $this->session->set('admin' , [
            'login' => $this->request->getValue('login')
        ]);
        $this->redirect('/dashboard');
    }
}
