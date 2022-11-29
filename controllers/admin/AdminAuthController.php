<?php

namespace Controllers\Admin;

use Src\AdminController;
use Src\Classes\Employee;
use Src\Helpers\Translator;

class AdminAuthController extends AdminController
{

    public function init()
    {
        $this->theme->setLayout('login');

        $this->postProcess();
      
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
        if($this->request->isSubmit('submitAdminLogin')){

            $error = false;

            if(!$employee = Employee::getByEmail($this->request->getValue('email'))){
                $error = true;

            } 

            if(!password_verify($this->request->getValue('password'), $employee['password'])){
                $error = true;
            }

            if(!$error){
                $this->session->set('admin' , [
                    'id_employee' => $employee['id_employee'],
                    'email' => $employee['email'],
                ]);
                $this->redirect('/dashboard');
            } else {
                $this->theme->addError('admin_login', Translator::trans('Nieprawidłowy login lub hasło'));
            }
        }
        
    }
}
