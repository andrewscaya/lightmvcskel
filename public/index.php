<?php

ob_start();

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.php';

try {

    $serviceManager = new Ascmvc\Mvc\ServiceManager();

    $viewObject = Ascmvc\Mvc\Smarty::getInstance();

    $lMVCApp = Ascmvc\Mvc\App::getInstance();

    $lMVCApp->initialize($baseConfig, $serviceManager, $viewObject);

    $lMVCApp->run();

}
catch (\Exception $e) {
    
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
