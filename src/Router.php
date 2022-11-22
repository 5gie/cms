<?php

namespace Src;

use Bramus\Router\Router as BramusRouter;

class Router {

    private $router;
    
    public function __construct(BramusRouter $router)
    {
        $this->router = $router;
    }

    public function initFront()
    {
        $this->router->setNamespace('\Controllers\Front');
        $this->router->get('/', 'IndexController@init');

        return $this->router->run();
    }

    public function initAdmin()
    {
        $this->router->setNamespace('\Controllers\Admin');
        $this->router->setBasePath('/admin');
        $this->router->match('GET|POST', '/', 'AdminAuthController@init');
        $this->router->get('/dashboard', 'AdminDashboardController@init');

        return $this->router->run();
    }

}