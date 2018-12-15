<?php

namespace Application\Controllers;

use \Ascmvc\Mvc\Controller;
use Ascmvc\FactoryInterface;
use \Ascmvc\AbstractEventManager;
use Application\Models\Entity\Products;
use Application\Services\CrudProductsService;
use Application\Services\CrudProductsServiceTrait;
use Pimple\Container;


class ProductController extends Controller implements FactoryInterface
{
    use CrudProductsServiceTrait;
    
    public static function factory(array &$baseConfig, &$viewObject, Container &$serviceManager, AbstractEventManager &$eventManager)
    {
        $serviceManager[ProductController::class] = $serviceManager->factory(function ($serviceManager) use ($baseConfig) {
			$em = $serviceManager['em1'];
			
			$products = new Products();

			$crudService = new CrudProductsService($products, $em);
			
			$controller = new ProductController($baseConfig);
			
			$controller->setCrudService($crudService);
			
			return $controller;
		});
    }

    public function predispatch()
    {
        $this->view['saved'] = 0;

        $this->view['error'] = 0;
    }
    
    protected function readProducts($id = null)
    {
        if ($id == null) {
            return $this->crudService->read();
        } else {
            return $this->crudService->read($id);
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

    public function indexAction($vars = null)
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
        
        $this->view['templatefile'] = 'product_index.html.twig';
        
        return $this->view;
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            // Would have to sanitize and filter the $_POST array.
            $productArray['name'] = (string) $_POST['name'];
            $productArray['price'] = (string) $_POST['price'];
            $productArray['description'] = (string) $_POST['description'];
            $productArray['image'] = (string) $_FILES['image']['name'];

            if ($this->crudService->create($productArray)) {
                $this->view['saved'] = 1;
            } else {
                $this->view['error'] = 1;
            }
        }

        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'product_add_form.html.twig';
        
        return $this->view;
    }

    public function editAction($vars)
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

            if ($this->crudService->update($productArray)) {
                $this->view['saved'] = 1;
            } else {
                $this->view['error'] = 1;
            }
        } else {
            $results = $this->readProducts($vars['id']);

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
        
        $this->view['templatefile'] = 'product_edit_form.html.twig';
        
        return $this->view;
    }

    public function deleteAction($vars)
    {
		// Sanitize and filter the $_GET array.
		$id = (int) $vars['id'];

		if ($this->crudService->delete($id)) {
			$this->view['saved'] = 1;
		} else {
			$this->view['error'] = 1;
		}
		
		$this->view['templatefile'] = 'product_delete.html.twig';
        
        return $this->view;
    }
}
