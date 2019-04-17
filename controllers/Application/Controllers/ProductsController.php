<?php

namespace Application\Controllers;

use Application\Events\ReadProductsCompleted;
use Application\Events\WriteProductsCompleted;
use Application\Models\Entity\Products;
use Application\Policies\ProductsPolicy;
use Application\ReadModels\ProductsReadModel;
use Ascmvc\AscmvcControllerFactoryInterface;
use Ascmvc\EventSourcing\AggregateImmutableValueObject;
use Ascmvc\EventSourcing\EventDispatcher;
use Ascmvc\EventSourcing\EventLogger;
use Ascmvc\EventSourcing\Event\AggregateEvent;
use Ascmvc\EventSourcing\Event\Event;
use Ascmvc\Mvc\AscmvcEvent;
use Ascmvc\Mvc\Controller;
use Pimple\Container;

class ProductsController extends Controller implements AscmvcControllerFactoryInterface
{
    const READ_REQUESTED =  'products_read_received';

    const CREATE_REQUESTED = 'products_create_received';

    const UPDATE_REQUESTED = 'products_update_received';

    const DELETE_REQUESTED = 'products_delete_received';

    const READ_COMPLETED = 'products_read_completed';

    const CREATE_COMPLETED = 'products_create_completed';

    const UPDATE_COMPLETED = 'products_update_completed';

    const DELETE_COMPLETED = 'products_delete_completed';


    public static function factory(array &$baseConfig, EventDispatcher &$eventDispatcher, Container &$serviceManager, &$viewObject)
    {
        // Setting the identifiers of this Event Dispatcher (event bus).
        // Subscribing this controller (Aggregate Root) and the Event Sourcing Logger.
        $eventDispatcher->setIdentifiers(
            [
                ProductsController::class,
                EventLogger::class,
            ]
        );

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

        $sharedEventManager = $eventDispatcher->getSharedManager();

        // Attaching this controller's listener method to the shared event manager's
        // corresponding identifier (see above).
        $sharedEventManager->attach(
            ProductsController::class,
            '*',
            [$controller, 'updatePostActionControllerOutput']
        );

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
        if (isset($vars['get']['id'])) {
            $productArray['id'] = (string) $vars['get']['id'];
        } else {
            $productArray = [];
        }

        $aggregateValueObject = new AggregateImmutableValueObject($productArray);

        $event = new AggregateEvent(
            $aggregateValueObject,
            ProductsController::class,
            ProductsController::READ_REQUESTED
        );

        $this->eventDispatcher->dispatch($event);

        $this->view['bodyjs'] = 1;

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

            $aggregateValueObject = new AggregateImmutableValueObject($productArray);

            $event = new AggregateEvent(
                $aggregateValueObject,
                ProductsController::class,
                ProductsController::CREATE_REQUESTED
            );

            $this->eventDispatcher->dispatch($event);
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

            $aggregateValueObject = new AggregateImmutableValueObject($productArray);

            $event = new AggregateEvent(
                $aggregateValueObject,
                ProductsController::class,
                ProductsController::UPDATE_REQUESTED
            );

            $this->eventDispatcher->dispatch($event);
        } else {
            if (isset($vars['get']['id'])) {
                $productArray['id'] = (string) $vars['get']['id'];
                $aggregateValueObject = new AggregateImmutableValueObject($productArray);
                $event = new AggregateEvent(
                    $aggregateValueObject,
                    ProductsController::class,
                    ProductsController::READ_REQUESTED
                );
            }

            $this->eventDispatcher->dispatch($event);
        }

        $this->view['bodyjs'] = 1;
        
        $this->view['templatefile'] = 'products_edit_form';
        
        return $this->view;
    }

    public function deleteAction($vars)
    {
		// Sanitize and filter the $_GET array.
		$productArray['id'] = (int) $vars['get']['id'];

        $aggregateValueObject = new AggregateImmutableValueObject($productArray);

        $event = new AggregateEvent(
            $aggregateValueObject,
            ProductsController::class,
            ProductsController::DELETE_REQUESTED
        );

        $this->eventDispatcher->dispatch($event);
		
		$this->view['templatefile'] = 'products_delete';
        
        return $this->view;
    }

    /**
     * Updates the Controller's output at the dispatch event if needed (listener method).
     *
     * @param Event $event
     */
    public function updatePostActionControllerOutput(Event $event)
    {
        if (!$event instanceof WriteProductsCompleted && !$event instanceof ReadProductsCompleted) {
            return;
        }

        $app = $event->getApplication();

        $eventName = $event->getName();

        $results = $event->getAggregateValueObject()->getProperties();

        $params = $event->getParams();

        $controllerOutput = $app->getControllerOutput();

        if ($eventName === ProductsController::READ_COMPLETED) {
            if (!empty($results)) {
                if (is_object($results)) {
                    $results = [$this->hydrateArray($results)];
                } elseif (is_array($results)) {
                    for ($i = 0; $i < count($results); $i++) {
                        $results[$i] = $this->hydrateArray($results[$i]);
                    }
                }

                $output = [];

                $output['results'] = $results;

                if (is_null($controllerOutput)) {
                    $controllerOutput = $output;
                } else {
                    $controllerOutput = array_merge($output, $controllerOutput);
                }
            }
        } else {
            if (!empty($params)) {
                $output['saved'] = $params['saved'];

                if (is_null($controllerOutput)) {
                    $controllerOutput = $output;
                } else {
                    $controllerOutput = array_merge($output, $controllerOutput);
                }
            }
        }

        $app->setControllerOutput($controllerOutput);
    }
}
