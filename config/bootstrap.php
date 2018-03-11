<?php

define('BASEDIR', dirname(dirname(__FILE__)));

require_once BASEDIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Instantiate the loader
//$loader = new Ascmvc\Mvc\Psr4Autoloader;

// Register the autoloader
//$loader->register();

// Register the base directories for the namespace prefix
//$loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');


if (PHP_SAPI !== 'cli') {
    
    $protocol = strpos($_SERVER['SERVER_SIGNATURE'], '443') !== false ? 'https://' : 'http://';
    
    $requestUriArray = explode('/', $_SERVER['PHP_SELF']);
    
    if (is_array($requestUriArray)) {
    
        $indexKey = array_search('index.php', $requestUriArray);
    
        array_splice($requestUriArray, $indexKey);
    
        $requestUri = implode('/', $requestUriArray);
    
    }
    
    $requestUrl = $protocol . $_SERVER['HTTP_HOST'] . $requestUri . '/';
    
    define('URLBASEADDR', $requestUrl);
    
}
else {
    
    define('URLBASEADDR', FALSE);
    
}


$appFolder = basename(BASEDIR);

$baseConfig = ['BASEDIR'     => BASEDIR,
    'URLBASEADDR' => URLBASEADDR,
    'appFolder'   => $appFolder,
];

require_once BASEDIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

if (file_exists(BASEDIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.local.php')) {
    
    include_once BASEDIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.local.php';
    
}
