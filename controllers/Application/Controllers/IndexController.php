<?php

namespace Application\Controllers;

use \Ascmvc\AbstractApp;
use \Ascmvc\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction($vars = null)
    {
        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'index_index.tpl';
        
        return $this->view;
    }
}
