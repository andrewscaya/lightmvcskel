<?php

$baseConfig['templateManager'] = 'Twig';

$baseConfig['templates'] = [
    'templateDir' => $baseConfig['BASEDIR'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'twig' . DIRECTORY_SEPARATOR,
    'compileDir' => $baseConfig['BASEDIR'] . DIRECTORY_SEPARATOR . 'templates_c' . DIRECTORY_SEPARATOR,
    'configDir' => $baseConfig['BASEDIR'] . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR,
    'cacheDir' => $baseConfig['BASEDIR'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR,
];

$baseConfig['view'] = [
    'urlbaseaddr' => $baseConfig['URLBASEADDR'],
    'logo' => $baseConfig['URLBASEADDR'] . 'img/logo.png',
    'favicon' => $baseConfig['URLBASEADDR'] . 'favicon.ico',
    'appname' => $baseConfig['appName'],
    'title' => "Skeleton Application",
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