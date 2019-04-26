<?php

namespace Application\Policies;

use Application\Controllers\ProductsController;
use Application\Events\WriteProductsCompleted;
use Application\Models\Traits\DoctrineTrait;
use Ascmvc\EventSourcing\AggregateImmutableValueObject;
use Ascmvc\EventSourcing\AggregatePolicy;
use Ascmvc\EventSourcing\Event\AggregateEvent;
use Ascmvc\EventSourcing\Event\Event;
use Ascmvc\EventSourcing\EventDispatcher;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProductsPolicy extends AggregatePolicy
{
    const CREATE_COMPLETED = 'products_create_completed';

    const UPDATE_COMPLETED = 'products_update_completed';

    const DELETE_COMPLETED = 'products_delete_completed';

    use DoctrineTrait;

    protected $properties;

    protected $products;

    protected $productsRepository;

    protected $commandProcess;

    public static function getInstance(EventDispatcher $eventDispatcher)
    {
        return new self($eventDispatcher);
    }

    public function __invoke(AggregateEvent $event)
    {
        if (is_null($this->commandProcess)) {
            parent::onAggregateEvent($event);

            $asyncBus = $event->getApplication()->getBaseConfig()['async_process_bin'];

            $values = $event->getAggregateValueObject()->serialize();

            $name = $event->getName();

            $execute = '';

            if ($name === ProductsController::CREATE_REQUESTED) {
                $execute = 'create';
            } elseif ($name === ProductsController::UPDATE_REQUESTED) {
                $execute = 'update';
            } elseif ($name === ProductsController::DELETE_REQUESTED) {
                $execute = 'delete';
            }

            $productsCommand = 'php ' . $asyncBus . ' products:write ' . $execute . ' --values ' . "'$values'";

            $this->commandProcess = new Process($productsCommand);

            $this->commandProcess->setTty($this->commandProcess->isTtySupported());

            $this->commandProcess->setTimeout(null);

            try {
                $this->commandProcess->mustRun();
            } catch (ProcessFailedException $e) {
                die($e->getMessage());
                throw new \Exception($productsCommand . ' failed');
            }

            // Can be used for callback architecture style.
            //$this->commandProcess->start();
            //$this->commandProcess->wait();
        }

        while ($this->commandProcess->isRunning()) {
            yield true;
        }

        $name = $event->getName();

        $processStdout = $this->commandProcess->getOutput();
        //$processStderr = $this->commandProcess->getErrorOutput();

        $processStdoutArray = unserialize($processStdout);

        $valueObjectProperties = $processStdoutArray['data'];

        $aggregateValueObject = new AggregateImmutableValueObject($valueObjectProperties);

        if ($name === ProductsController::CREATE_REQUESTED) {
            $event = new WriteProductsCompleted(
                $aggregateValueObject,
                $this->aggregateRootName,
                ProductsPolicy::CREATE_COMPLETED
            );
        } elseif ($name === ProductsController::UPDATE_REQUESTED) {
            $event = new WriteProductsCompleted(
                $aggregateValueObject,
                $this->aggregateRootName,
                ProductsPolicy::UPDATE_COMPLETED
            );
        } elseif ($name === ProductsController::DELETE_REQUESTED) {
            $event = new WriteProductsCompleted(
                $aggregateValueObject,
                $this->aggregateRootName,
                ProductsPolicy::DELETE_COMPLETED
            );
        }

        $eventParams = $processStdoutArray['params'];

        $event->setParams($eventParams);

        $this->eventDispatcher->dispatch($event);

        return;
    }

    public function onAggregateEvent(AggregateEvent $event)
    {
    }

    public function onEvent(Event $event)
    {
    }
}
