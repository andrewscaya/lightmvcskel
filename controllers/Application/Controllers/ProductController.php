<?php

namespace Application\Controllers;

use \Ascmvc\AbstractApp;
use \Ascmvc\Mvc\Controller;
use Application\Services\CrudProductsService;
use Application\Services\CrudProductsServiceTrait;
use Application\Models\Entity\Products;

class ProductController extends Controller
{

    use CrudProductsServiceTrait;

    public static function config(AbstractApp &$app)
    {
        IndexController::config($app);
    }

    public function predispatch()
    {
        $em = $this->serviceManager->getRegisteredService('em1');

        $products = new Products();

        $crudService = new CrudProductsService($products, $em);

        $this->serviceManager->addRegisteredService('CrudProductService', $crudService);

        $this->setCrudProducts($this->serviceManager->getRegisteredService('CrudProductService'));

        $this->view['saved'] = 0;

        $this->view['error'] = 0;
    }

    public function indexAction()
    {
        $results = $this->readProducts();

        if (is_object($results)) {
            $results = [$this->hydrateArray($results)];
        } else {
            for ($i = 0; $i < count($results); $i++) {
                $results[$i] = $this->hydrateArray($results[$i]);
            }
        }

        $this->view['bodyjs'] = 1;

        $this->view['results'] = $results;

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('product_index.tpl');
    }

    protected function readProducts()
    {
        if (!empty($_GET)) {
            $id = (int) $_GET['id'];

            return $this->getCrudProducts()->read($id);
        } else {
            return $this->getCrudProducts()->read();
        }
    }

    protected function hydrateArray(Products $object)
    {
        $array['id'] = $object->getId();
        $array['name'] = $object->getName();
        $array['price'] = $object->getPrice();
        $array['description'] = $object->getDescription();
        $array['image'] = $object->getImage();

        return $array;
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            // Would have to sanitize and filter the $_POST array.
            $productArray['name'] = (string) $_POST['name'];
            $productArray['price'] = (string) $_POST['price'];
            $productArray['description'] = (string) $_POST['description'];
            $productArray['image'] = (string) $_FILES['image']['name'];

            if ($this->crudProducts->create($productArray)) {
                $this->view['saved'] = 1;
            } else {
                $this->view['error'] = 1;
            }
        }

        $this->view['bodyjs'] = 1;

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('product_add_form.tpl');
    }

    public function editAction()
    {
        if (!empty($_POST)) {
            // Would have to sanitize and filter the $_POST array.
            $productArray['id'] = (string) $_POST['id'];
            $productArray['name'] = (string) $_POST['name'];
            $productArray['price'] = (string) $_POST['price'];
            $productArray['description'] = (string) $_POST['description'];

            if (!empty($_FILES['image']['name'])) {
                $productArray['image'] = (string) $_FILES['image']['name'];
            } else {
                $productArray['image'] = (string) $_POST['imageoriginal'];
            }

            if ($this->crudProducts->update($productArray)) {
                $this->view['saved'] = 1;
            } else {
                $this->view['error'] = 1;
            }
        } else {
            $results = $this->readProducts();

            if (is_object($results)) {
                $results = [$this->hydrateArray($results)];
            } else {
                for ($i = 0; $i < count($results); $i++) {
                    $results[$i] = $this->hydrateArray($results[$i]);
                }
            }

            $this->view['results'] = $results;
        }

        $this->view['bodyjs'] = 1;

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('product_edit_form.tpl');
    }

    public function deleteAction()
    {
        if (!empty($_GET)) {
            // Would have to sanitize and filter the $_GET array.
            $id = (int) $_GET['id'];

            if ($this->crudProducts->delete($id)) {
                $this->view['saved'] = 1;
            } else {
                $this->view['error'] = 1;
            }
        }

        $this->viewObject->assign('view', $this->view);

        $this->viewObject->display('product_delete.tpl');
    }
}
