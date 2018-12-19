<?php

namespace Application\Controllers;

use Ascmvc\Mvc\Controller;


class C404Controller extends Controller
{
	
    public function indexAction($vars = null)
    {
        header('HTTP/1.1 404 Not Found', true, 404);

        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'c404_index.html.twig';
        
        return $this->view;
    }
    
}
