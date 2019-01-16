<?php

namespace Specialmodule\Controllers;

use Ascmvc\Mvc\Controller;
use Zend\Diactoros\Response\JsonResponse;

class IndexController extends Controller
{
    public function indexAction($vars = null)
    {
        $middlewareName = $_SERVER['sessionmiddleware'] ?? 'None';

        $array = [
            'module' => 'Specialmodule',
            'controller' => 'IndexController',
            'sessionmiddleware' => $middlewareName,
            'middlewareconstant' => BAZCONSTANT
        ];
        $response = new JsonResponse($array);
        
        return $response;
    }
}
