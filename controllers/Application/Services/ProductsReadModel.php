<?php

namespace Application\Services;

use Application\Models\Entity\Products;
use Application\Models\Traits\DoctrineTrait;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\EventSourcing\Event;
use Ascmvc\EventSourcing\EventDispatcher;
use Ascmvc\EventSourcing\ReadModel;
use Doctrine\ORM\Mapping\ClassMetadata;

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
        $entityManager = $event->getApplication()->getServiceManager()['dem1'];

        $this->id = $event->getParam('id') ?? null;

        $this->em = $entityManager;

        $this->productsRepository = new ProductsRepository(
            $this->em,
            new ClassMetaData('Application\Models\Entity\Products')
        );

        return $this->read();
    }

    public function read()
    {
        try {
            if (isset($this->id)) {
                $results = $this->getEm()->find(Products::class, $this->id);
            } else {
                $results = $this->productsRepository->findAll();
            }
        } catch (\Exception $e) {
            return false;
        }

        return $results;
    }
}
