<?php

namespace Application\Services;

use Application\Controllers\ProductsController;
use Application\Models\Entity\Products;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\EventSourcing\Command;
use Ascmvc\EventSourcing\Event;
use Doctrine\ORM\Mapping\ClassMetadata;

class ProductsUpdateCommand extends Command
{
    public function execute()
    {
        $entityManager = array_pop($this->argv);

        $productsRepository = new ProductsRepository(
            $entityManager,
            new ClassMetadata('Application\Models\Entity\Products')
        );

        $event = new Event(ProductsController::UPDATE_COMPLETED);

        try {
            if (isset($this->argv['id'])) {
                $products = $entityManager->find(Products::class, $this->argv['id']);
                $productsRepository->save($this->argv, $products);
            }
        } catch (\Exception $e) {
            $event->setParam('error', 1);

            return;
        }

        $event->setParam('saved', 1);

        $this->eventDispatcher->dispatch($event);
    }
}