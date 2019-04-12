<?php

namespace Application\Policies;

use Application\Commands\WriteProductsCommand;
use Application\Models\Traits\DoctrineTrait;
use Ascmvc\EventSourcing\Event\Event;
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
        $connName = $event->getApplication()->getBaseConfig()['events']['write_conn_name'];

        $entityManager = $event->getApplication()->getServiceManager()[$connName];

        $argv['name'] = $event->getName();

        $productsCommand = new WriteProductsCommand(
            $event->getAggregateValueObject(),
            $entityManager,
            $this->eventDispatcher,
            $argv
        );

        $productsCommand->execute();

        return;
    }
}
