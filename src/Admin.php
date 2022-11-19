<?php

namespace Src;

use Bramus\Router\Router as BramusRouter;

class Admin
{
    public function __construct()
    {
        return (new Router(new BramusRouter()))->initAdmin();
    }

}