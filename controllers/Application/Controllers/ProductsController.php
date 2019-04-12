<?php

namespace Application\Controllers;

use Application\Models\Entity\Products;
use Application\Services\ProductsPolicy;
use Application\Services\ProductsReadModel;
use Ascmvc\AscmvcControllerFactoryInterface;
use Ascmvc\EventSourcing\Event;
use Ascmvc\EventSourcing\EventDispatcher;
use Ascmvc\Mvc\Controller;
use Ascmvc\Mvc\AscmvcEvent;
use Pimple\Container;

class ProductsController extends Controller implements AscmvcControllerFactoryInterface
{
    const READ_REQUESTED = 'productcontroller_products_read_request_received';

    const CREATE_REQUESTED = 'productcontroller_products_create_request_received';

    const UPDATE_REQUESTED = 'productcontroller_products_update_request_received';

    const DELETE_REQUESTED = 'productcontroller_products_delete_request_received';

    const READ_COMPLETED = 'productcontroller_products_read_request_completed';

    const CREATE_COMPLETED = 'productcontroller_products_create_request_completed';

    const UPDATE_COMPLETED = 'productcontroller_products_update_request_completed';

    const DELETE_COMPLETED = 'productcontroller_products_delete_request_completed';

    public static function factory(array &$baseConfig, EventDispatcher &$eventDispatcher, Container &$serviceManager, &$viewObject)
    {
        $productsReadModel = ProductsReadModel::getInstance($eventDispatcher);

        $eventDispatcher->attach(
            ProductsController::READ_REQUESTED,
            [$productsReadModel, 'onEvent']
        );

        $productsPolicy = ProductsPolicy::getInstance($eventDispatcher);

        $eventDispatcher->attach(
            ProductsController::CREATE_REQUESTED,
            [$productsPolicy, 'onEvent']
        );

        $eventDispatcher->attach(
            ProductsController::UPDATE_REQUESTED,
            [$productsPolicy, 'onEvent']
        );

        $eventDispatcher->attach(
            ProductsController::DELETE_REQUESTED,
            [$productsPolicy, 'onEvent']
        );

        $controller = new ProductsController($baseConfig, $eventDispatcher);

        return $controller;
    }

    /*public function onDispatch(AscmvcEvent $event)
    {
        $array = [
            'firstname' => 'Andrew',
            'lastname' => 'Caya',
            'age' => 42,
        ];

        $response = new Response();
        $response->getBody()->write(json_encode($array));
        $response = $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withAddedHeader('X-Custom-Header', 'it works');

        return $response;
    }*/

    public function onDispatch(AscmvcEvent $event)
    {
        $this->view['saved'] = 0;

        $this->view['error'] = 0;

        $app = $event->getApplication();

        $sharedEventManager = $this->eventDispatcher->getSharedManager();

        $sharedEventManager->attach(
            '*',
            ProductsController::UPDATE_COMPLETED,
            [$app, 'updatePostDispatchControllerOutput'],
            1
        );
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
        $event = new Event(ProductsController::READ_REQUESTED);

        /*
         * Possible to retrieve one single entity from the database by setting the
         * event's 'id' parameter.
         */
        // $event->setParam('id', 4);

        $resultCollection = $this->eventDispatcher->dispatch($event);

        $results = $resultCollection->pop();

        if (is_object($results)) {
            $results = [$this->hydrateArray($results)];
        } elseif (is_array($results)) {
            for ($i = 0; $i < count($results); $i++) {
                $results[$i] = $this->hydrateArray($results[$i]);
            }
        } else {
            $results['nodata'] = 'No results';
        }

        $this->view['bodyjs'] = 1;

        $this->view['results'] = $results;

        $this->view['templatefile'] = 'products_index';

        return $this->view;
    }

    public function addAction($vars)
    {
        if (!empty($vars['post'])) {
            // Would have to sanitize and filter the $_POST array.
            $productArray['name'] = (string) $vars['post']['name'];
            $productArray['price'] = (string) $vars['post']['price'];
            $productArray['description'] = (string) $vars['post']['description'];
            $productArray['image'] = (string) $vars['files']['image']->getClientFilename();

            if ($this->crudService->create($productArray)) {
                $this->view['saved'] = 1;
            } else {
                $this->view['error'] = 1;
            }
        }

        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'products_add_form';
        
        return $this->view;
    }

    public function editAction($vars)
    {
        if (!empty($vars['post'])) {
            // Would have to sanitize and filter the $_POST array.
            $productArray['id'] = (string) $vars['post']['id'];
            $productArray['name'] = (string) $vars['post']['name'];
            $productArray['price'] = (string) $vars['post']['price'];
            $productArray['description'] = (string) $vars['post']['description'];

            if (!empty($vars['files']['image']->getClientFilename())) {
                $productArray['image'] = (string) $vars['files']['image']->getClientFilename();
            } else {
                $productArray['image'] = (string) $vars['post']['imageoriginal'];
            }

            $event = new Event(ProductsController::UPDATE_REQUESTED);

            $event->setParam('argv', $productArray);

            $this->eventDispatcher->dispatch($event);
        } else {
            $event = new Event(ProductsController::READ_REQUESTED);

            $event->setParam('id', $vars['get']['id']);

            $resultCollection = $this->eventDispatcher->dispatch($event);

            $results = $resultCollection->pop();

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
        
        $this->view['templatefile'] = 'products_edit_form';
        
        return $this->view;
    }

    public function deleteAction($vars)
    {
		// Sanitize and filter the $_GET array.
		$id = (int) $vars['get']['id'];

		if ($this->crudService->delete($id)) {
			$this->view['saved'] = 1;
		} else {
			$this->view['error'] = 1;
		}
		
		$this->view['templatefile'] = 'products_delete';
        
        return $this->view;
    }
}
