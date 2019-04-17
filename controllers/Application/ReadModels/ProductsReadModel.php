<?php

namespace Application\ReadModels;

use Application\Commands\ReadProductsCommand;
use Application\Models\Entity\Products;
use Application\Models\Traits\DoctrineTrait;
use Ascmvc\EventSourcing\Event\Event;
use Ascmvc\EventSourcing\EventDispatcher;
use Ascmvc\EventSourcing\ReadModel;

class ProductsReadModel extends ReadModel
{
    use DoctrineTrait;

    protected $id;

    protected $products;

    protected $productsRepository;

    protected function __construct(EventDispatcher $eventDispatcher, Products $products)
    {
        parent::__construct($eventDispatcher);

        $this->products = $products;
    }

    public static function getInstance(EventDispatcher $eventDispatcher)
    {
        $productsEntity = new Products();

        return new self($eventDispatcher, $productsEntity);
    }

    public function onEvent(Event $event)
    {
        $connName = $event->getApplication()->getBaseConfig()['events']['read_conn_name'];

        $entityManager = $event->getApplication()->getServiceManager()[$connName];

        $productsCommand = new ReadProductsCommand(
            $event->getAggregateValueObject(),
            $entityManager,
            $this->eventDispatcher
        );

        if (!is_null($productsCommand)) {
            $productsCommand->execute();
        }

        return;
    }
}
