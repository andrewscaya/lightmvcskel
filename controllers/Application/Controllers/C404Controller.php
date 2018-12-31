<?php

namespace Application\Controllers;

use Ascmvc\Mvc\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;


class C404Controller extends Controller implements MiddlewareInterface
{

    public function indexAction($vars = null)
    {
        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'c404_index.html.twig';

        $this->view['statuscode'] = 404;
        
        return $this->view;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('Kinda wrong! :)');
        $response = $response->withStatus(404);
        return $response;
    }
    
}
