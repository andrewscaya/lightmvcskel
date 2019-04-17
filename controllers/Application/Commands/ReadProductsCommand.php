<?php

namespace Application\Commands;

use Application\Controllers\ProductsController;
use Application\Events\ReadProductsCompleted;
use Application\Models\Entity\Products;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\EventSourcing\AggregateImmutableValueObject;
use Doctrine\ORM\Mapping\ClassMetadata;

class ReadProductsCommand extends ProductsCommand
{
    public function execute()
    {
        $args = $this->aggregateValueObject->getProperties();

        $productsRepository = new ProductsRepository(
            $this->entityManager,
            new ClassMetadata(Products::class)
        );

        try {
            if (isset($args['id'])) {
                $results = $productsRepository->find($args['id']);
            } else {
                $results = $productsRepository->findAll();
            }
        } catch (\Exception $e) {
            return;
        }

        if (is_object($results)) {
            $results = [$results];
        }

        $aggregateValueObject = new AggregateImmutableValueObject($results);

        $event = new ReadProductsCompleted(
            $aggregateValueObject,
            ProductsController::class,
            ProductsController::READ_COMPLETED
        );

        $this->eventDispatcher->dispatch($event);
    }
}