<?php

namespace Application\Commands;

use Application\Controllers\ProductsController;
use Application\Events\WriteProductsCompleted;
use Application\Models\Entity\Products;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\EventSourcing\AggregateImmutableValueObject;
use Doctrine\ORM\Mapping\ClassMetadata;

class WriteProductsCommand extends ProductsCommand
{
    public function execute()
    {
        $name = $this->argv['name'];

        $args = $this->aggregateValueObject->getProperties();

        $productsRepository = new ProductsRepository(
            $this->entityManager,
            new ClassMetadata(Products::class)
        );

        $values = [];

        try {
            if ($name === ProductsController::CREATE_REQUESTED) {
                $productsRepository->save($args);
            } elseif ($name === ProductsController::UPDATE_REQUESTED) {
                $products = $this->entityManager->find(Products::class, $args['id']);

                $values['pre'] = [
                    'id' => $products->getId(),
                    'name' => $products->getName(),
                    'price' => $products->getPrice(),
                    'description' => $products->getDescription(),
                    'image' => $products->getImage(),
                ];

                $productsRepository->save($args, $products);
            } elseif ($name === ProductsController::DELETE_REQUESTED) {
                if (isset($args['id'])) {
                    $products = $this->entityManager->find(Products::class, $args['id']);
                    $productsRepository->delete($products);
                }
            }

            $params = ['saved' => 1];

            $values['post'] = $args;

            $aggregateValueObject = new AggregateImmutableValueObject($values);

            if ($name === ProductsController::CREATE_REQUESTED) {
                $event = new WriteProductsCompleted(
                    $aggregateValueObject,
                    ProductsController::class,
                    ProductsController::CREATE_COMPLETED
                );
            } elseif ($name === ProductsController::UPDATE_REQUESTED) {
                $event = new WriteProductsCompleted(
                    $aggregateValueObject,
                    ProductsController::class,
                    ProductsController::UPDATE_COMPLETED
                );
            } elseif ($name === ProductsController::DELETE_REQUESTED) {
                $event = new WriteProductsCompleted(
                    $aggregateValueObject,
                    ProductsController::class,
                    ProductsController::DELETE_COMPLETED
                );
            }

            $event->setParams($params);
        } catch (\Exception $e) {
            $event->setParam('error', 1);
        }

        $this->eventDispatcher->dispatch($event);
    }
}