<?php

$baseConfig['routes'] = [
    0 => [
        'GET',
        '/',
        'index',
    ],
    1 => [
        'GET',
        '/index[/{action}]',
        'index',
    ],
    2 => [
        'GET',
        '/products[/{action}]',
        'product',
    ],
    3 => [
        'POST',
        '/products[/{action}]',
        'product',
    ],
    4 => [
        'GET',
        '/products/{action}/[{id:[0-9]+}]',
        'product',
    ],
    5 => [
        'POST',
        '/products/{action}/[{id:[0-9]+}]',
        'product',
    ],
];