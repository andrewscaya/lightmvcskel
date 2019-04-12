<?php

namespace Application\Commands;

use Ascmvc\EventSourcing\AggregateImmutableValueObject;
use Ascmvc\EventSourcing\Command;
use Ascmvc\EventSourcing\EventDispatcher;
use Doctrine\ORM\EntityManager;

class ProductsCommand extends Command
{
    protected $aggregateValueObject;

    protected $entityManager;

    public function __construct(
        AggregateImmutableValueObject $aggregateValueObject,
        EntityManager $entityManager,
        EventDispatcher $eventDispatcher,
        array $argv = []
    )
    {
        parent::__construct($eventDispatcher, $argv);

        $this->aggregateValueObject = $aggregateValueObject;

        $this->entityManager = $entityManager;
    }

    public function execute()
    {
    }
}