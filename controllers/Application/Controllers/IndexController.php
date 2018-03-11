<?php

namespace Application\Controllers;

use \Ascmvc\AbstractApp;
use \Ascmvc\Mvc\Controller;


class IndexController extends Controller {
    
    
    public static function config(AbstractApp &$app)
    {
        $baseConfig = $app->getBaseConfig();
        
        $view = [
            'logo' => $baseConfig['URLBASEADDR'] . 'img/logo.png',
            'favicon' => $baseConfig['URLBASEADDR'] . 'favicon.ico',
            'appname' => $baseConfig['appName'],
            'title' => 'LightMVC Home',
            'author' => 'ETISTA',
            'description' => 'And then there was truly light.',
            'css' =>
            [
                $baseConfig['URLBASEADDR'] . 'css/bootstrap.min.css',
                $baseConfig['URLBASEADDR'] . 'css/dashboard.css',
                $baseConfig['URLBASEADDR'] . 'css/bootstrap.custom.css',
                $baseConfig['URLBASEADDR'] . 'css/dashboard.css',
                
            ],
            'js' =>
            [
                $baseConfig['URLBASEADDR'] . 'js/jquery.min.js',
                $baseConfig['URLBASEADDR'] . 'js/bootstrap.min.js',
                
            ],
            'jsscripts' =>
            [
                //"<script>\n\t\tfunction getPage(page) {\n\n\t\t\tvar url = page;\n\n\t\t\tjq( \"#pageBody\" ).load( url );\n\n\t\t}\n\t</script>\n",
        
            ],
            'links' =>
            [
                'Home' => $baseConfig['URLBASEADDR'] . 'index.php',
                
            ],
            'navMenu' =>
            [
                'Home' => $baseConfig['URLBASEADDR'] . 'index.php',
                
            ],
        
        ];
        
        $app->appendBaseConfig('view', $view);
    }
    
    public function indexAction()
    {
        $this->view['bodyjs'] = 1;

        $this->view['pageBody'] = "\t\t\t<div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">";
        $this->view['pageBody'] .= "\t\t\t\t<h1>Welcome to the test version of {$this->view['appname']}!</h1>";
        $this->view['pageBody'] .= "\t\t\t\t<p>You can test the access to the backend (Doctrine) by going to the address /lightmvctest/public/index.php/index/test?idn=1 (1 to 5).</p>";
        $this->view['pageBody'] .= "</div>";

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('index.tpl');
    }
    
    /*public function testAction()
    {
        $conn = $this->serviceManager->getRegisteredService('dbm1');
        
        $qb = $conn->createQueryBuilder();
        
        $qb->select('*')
        ->from('customers')
        ->where('id = :idn');
        $data = array(':idn' => $_GET['idn']);
        
        try {
            $stmt = $conn->prepare($qb->getSql());
            $stmt->execute($data);
            // fetch results after prepare and execute
            while ($row = $stmt->fetch()) {
                echo '<br />' . $row['lastname'] . ', ' . $row['firstname'];
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }*/
    
    public function testAction()
    {
        $em = $this->serviceManager->getRegisteredService('em1');
        
        // get query builder
        try {
            $qb = $em->createQueryBuilder();
            $qb->select('c')
            ->from('Application\Models\Entity\Customers', 'c')
            ->where('c.id = :idn')
            ->setParameter(':idn', $_GET['idn']);
        
            printf("\n%s\n", $qb->getQuery()->getSql());
            
            if ($result = $qb->getQuery()->getResult()) {
                echo "{$result[0]->getLastName()}, {$result[0]->getFirstName()}<br />";
            }
        }
        catch (Exception $e) {
        
            echo PHP_EOL . $e->getMessage();
        
        }
        
    }
    
}