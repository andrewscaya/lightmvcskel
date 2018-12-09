<?php

namespace Application\Controllers;

use \Ascmvc\AbstractApp;
use \Ascmvc\Mvc\Controller;

class C405Controller extends Controller
{

    public static function config(AbstractApp &$app)
    {
        IndexController::config($app);
    }

    public function indexAction()
    {
        header('HTTP/1.1 405 Method Not Allowed', true, 405);

        $this->view['bodyjs'] = 1;

        $this->view['pageBody'] = "\t\t\t<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">";
        $this->view['pageBody'] .= "\t\t\t\t<h1>Method Not Allowed</h1>";
        $this->view['pageBody'] .= "\t\t\t\t<p>Sorry, but this method is not allowed on this page.</p>";
        $this->view['pageBody'] .= "</div>";

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('c405_index.tpl');
    }
}
