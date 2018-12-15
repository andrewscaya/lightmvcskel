<?php

namespace Application\Controllers;

use \Ascmvc\AbstractApp;
use \Ascmvc\Mvc\Controller;

class C405Controller extends Controller
{
	
    public function indexAction($vars = null)
    {
        header('HTTP/1.1 405 Method Not Allowed', true, 405);
        
        $this->view['vars'] = $vars;
        
        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'c405_index.html.twig';
        
        return $this->view;
    }
    
}
