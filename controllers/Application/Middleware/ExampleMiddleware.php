<?php

namespace Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;

class ExampleMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (session_status() != PHP_SESSION_NONE) {
            $response = new Response();
            $response->getBody()->write('Session started! You are on the admin page.');
            $response = $response->withStatus(200);

            return $response;
        }

        define('BAZCONSTANT', 'Hello from Baz Middleware');

        return $handler->handle($request);
    }
}
