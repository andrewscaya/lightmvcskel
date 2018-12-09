<?php

$baseConfig['appName'] = 'LightMVC Framework Skeleton Application';

$baseConfig['routes'] = [
	0 => [
		'GET',
		'/index[/{action}]',
		'index',
	],
	1 => [
		'GET',
		'/products[/{action}]',
		'product',
	],
	2 => [
		'GET',
		'/products/{action}/[{id:[0-9]+}]',
		'product',
	],
	3 => [
		'POST',
		'/products/{action}',
		'product',
	],
];
