<?php

namespace Application\Controllers;

use \Ascmvc\AbstractApp;
use \Ascmvc\Mvc\Controller;

class IndexController extends Controller
{

    public static function config(AbstractApp &$app)
    {
        $baseConfig = $app->getBaseConfig();

        $view = [
            'urlbaseaddr' => $baseConfig['URLBASEADDR'],
            'logo' => $baseConfig['URLBASEADDR'] . 'img/logo.png',
            'favicon' => $baseConfig['URLBASEADDR'] . 'favicon.ico',
            'appname' => $baseConfig['appName'],
            'title' => "Andrew's Shop",
            'author' => 'Andrew Caya',
            'description' => 'Small CRUD application',
            'css' =>
            [
                $baseConfig['URLBASEADDR'] . 'css/bootstrap.min.css',
                $baseConfig['URLBASEADDR'] . 'css/dashboard.css',
                $baseConfig['URLBASEADDR'] . 'css/bootstrap.custom.css',
                $baseConfig['URLBASEADDR'] . 'css/dashboard.css',

            ],
            'js' =>
            [
                $baseConfig['URLBASEADDR'] . 'js/jquery.min.js',
                $baseConfig['URLBASEADDR'] . 'js/bootstrap.min.js',

            ],
            'jsscripts' =>
            [
                //"<script>\n\t\tfunction getPage(page) {\n\n\t\t\tvar url = page;\n\n\t\t\tjq( \"#pageBody\" ).load( url );\n\n\t\t}\n\t</script>\n",

            ],
            'links' =>
            [
                'Home' => $baseConfig['URLBASEADDR'] . 'index',

            ],
            'navMenu' =>
            [
                'Home' => $baseConfig['URLBASEADDR'] . 'index',

            ],

        ];

        $app->appendBaseConfig('view', $view);
    }

    public function indexAction()
    {
        $this->view['bodyjs'] = 1;

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('index_index.tpl');
    }
}
