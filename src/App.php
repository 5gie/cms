<?php

namespace Src;

use Bramus\Router\Router as BramusRouter;

class App
{
    public function __construct()
    {
        return (new Router(new BramusRouter()))->initFront();
    }
}
