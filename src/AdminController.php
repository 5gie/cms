<?php

namespace Src;

use Controllers\Admin\AdminAuthController;
use Src\Controller;

abstract class AdminController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->theme->admin = true;
        $this->checkAuth();
    }

    public function redirect($location)
    {
        header('location: /admin' . $location);
    }

    public function checkAuth()
    {   
        if(!$this->session->get('admin') && !$this instanceof AdminAuthController){
            $this->redirect('/');
        } else if($this->session->get('admin') && $this instanceof AdminAuthController){
            $this->redirect('/dashboard');
        }
    }

}