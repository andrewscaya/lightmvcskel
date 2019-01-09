<?php

namespace Specialmodule\Controllers;

use Ascmvc\Mvc\Controller;
use Zend\Diactoros\Response\JsonResponse;

class IndexController extends Controller
{
    public function indexAction($vars = null)
    {
        $array = [
            'module' => 'Specialmodule',
            'controller' => 'IndexController',
            'middlewareconstant' => BAZCONSTANT,
        ];
        $response = new JsonResponse($array);
        
        return $response;
    }
}
