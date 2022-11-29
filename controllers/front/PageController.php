<?php

namespace Controllers\Front;

use Src\Controller;

class PageController extends Controller{

    private $page;

    public function init($param = false)
    {
        $this->page = $this->getPage($param);
        return parent::init();
    }

    public function setTemplate(): void
    {
        $this->theme->template = $this->page['template'];
    }

    public function getTemplateVarPage(): array
    {
        $vars = parent::getTemplateVarPage();
        $vars['meta_title'] = $this->page['meta']['title'];
        $vars['meta_description'] = $this->page['meta']['description'];
        $vars['name'] = $this->page['name'];
        return $vars;
    }

    public function getPage($request)
    {
        switch($request)
        {
            case 'o-nas':
                return [
                    'template' => 'pages/about',
                    'meta' => [
                        'title' => 'O nas',
                        'description' => '',
                    ],
                    'name' => 'page'
                ];
            break;
            case 'nasza-oferta':
                return [
                    'template' => 'pages/offer',
                    'meta' => [
                        'title' => 'Nasza oferta',
                        'description' => '',
                    ],
                    'name' => 'page'
                ];
            break;
            case 'realizacje':
                return [
                    'template' => 'pages/gallery',
                    'meta' => [
                        'title' => 'Nasze realizacje',
                        'description' => '',
                    ],
                    'name' => 'page'
                    ];
            break;
            default:
                $this->redirect('404');
            break;
        }
    }
}