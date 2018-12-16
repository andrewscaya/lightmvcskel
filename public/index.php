<?php

ob_start();

define('BASEDIR', dirname(dirname(__FILE__)));

require_once BASEDIR . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Instantiate the loader
//$loader = new Ascmvc\Mvc\Psr4Autoloader;

// Register the autoloader
//$loader->register();

// Register the base directories for the namespace prefix
//$loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');

try {

    $app = Ascmvc\Mvc\App::getInstance();
    $baseConfig = $app->boot();
    $app->initialize($baseConfig)->run();

} catch (\Exception $e) {
    
    $logFile = BASEDIR . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'log.txt';
    
    $data = $e->getMessage() . PHP_EOL;
    
    // Write the contents to the file,
    // using the FILE_APPEND flag to append the content to the end of the file
    // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
    file_put_contents($logFile, $data, FILE_APPEND | LOCK_EX);
    
    echo 'A critical error has occurred.  Please contact your system administrator.';
    
}

ob_flush();

flush();

exit;
