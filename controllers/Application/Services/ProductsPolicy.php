<?php

namespace Application\Services;

use Application\Controllers\ProductsController;
use Application\Models\Traits\DoctrineTrait;
use Ascmvc\EventSourcing\Event;
use Ascmvc\EventSourcing\EventDispatcher;
use Ascmvc\EventSourcing\Policy;

class ProductsPolicy extends Policy
{
    use DoctrineTrait;

    protected $properties;

    protected $products;

    protected $productsRepository;

    public static function getInstance(EventDispatcher $eventDispatcher)
    {
        return new self($eventDispatcher);
    }

    public function onEvent(Event $event)
    {
        $entityManager = $event->getApplication()->getServiceManager()['dem1'];

        $eventName = $event->getName();

        $argv = $event->getParam('argv');
        $argv['entityManager'] = $entityManager;

        if ($eventName === ProductsController::CREATE_REQUESTED) {
            $productsCommand = new ProductsCreateCommand($this->eventDispatcher, $argv);
        } elseif ($eventName === ProductsController::UPDATE_REQUESTED) {
            $productsCommand = new ProductsUpdateCommand($this->eventDispatcher, $argv);
        } elseif ($eventName === ProductsController::DELETE_REQUESTED) {
            $productsCommand = new ProductsDeleteCommand($this->eventDispatcher, $argv);
        }

        if (!is_null($productsCommand)) {
            $productsCommand->execute();
        }

        return;
    }
}
