<?php

namespace Application\Services;

use Application\Controllers\ProductsController;
use Application\Models\Entity\Products;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\EventSourcing\Command;
use Ascmvc\EventSourcing\Event;
use Doctrine\ORM\Mapping\ClassMetadata;

class ProductsDeleteCommand extends Command
{
    public function execute()
    {
        $entityManager = array_pop($this->argv);

        $productsRepository = new ProductsRepository(
            $entityManager,
            new ClassMetadata('Application\Models\Entity\Products')
        );

        try {
            $products = $entityManager->find(Products::class, $this->argv['id']);
            $productsRepository->delete($products);
        } catch (\Exception $e) {
            return;
        }

        $event = new Event(ProductsController::DELETE_COMPLETED);

        $this->eventDispatcher->dispatch($event);
    }
}