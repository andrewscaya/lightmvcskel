<?php

namespace Application\Services;

use Application\Controllers\ProductsController;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\EventSourcing\Command;
use Ascmvc\EventSourcing\Event;
use Doctrine\ORM\Mapping\ClassMetadata;

class ProductsCreateCommand extends Command
{
    public function execute()
    {
        $entityManager = array_pop($this->argv);

        $productsRepository = new ProductsRepository(
            $entityManager,
            new ClassMetadata('Application\Models\Entity\Products')
        );

        try {
            $productsRepository->save($this->argv);
        } catch (\Exception $e) {
            return;
        }

        $event = new Event(ProductsController::CREATE_COMPLETED);

        $this->eventDispatcher->dispatch($event);
    }
}