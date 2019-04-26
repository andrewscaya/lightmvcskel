<?php

namespace Application\ReadModels;

use Application\Events\ReadProductsCompleted;
use Application\Models\Entity\Products;
use Application\Models\Traits\DoctrineTrait;
use Ascmvc\EventSourcing\AggregateImmutableValueObject;
use Ascmvc\EventSourcing\AggregateReadModel;
use Ascmvc\EventSourcing\Event\AggregateEvent;
use Ascmvc\EventSourcing\Event\Event;
use Ascmvc\EventSourcing\EventDispatcher;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProductsReadModel extends AggregateReadModel
{
    const READ_COMPLETED = 'products_read_completed';

    use DoctrineTrait;

    protected $id;

    protected $products;

    protected $productsRepository;

    protected $commandProcess;

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

    public function __invoke(AggregateEvent $event)
    {
        if (is_null($this->commandProcess)) {
            parent::onAggregateEvent($event);

            $asyncBus = $event->getApplication()->getBaseConfig()['async_process_bin'];

            $values = $event->getAggregateValueObject()->serialize();

            $productsCommand = 'php ' . $asyncBus . ' products:read --values ' . "'$values'";

            $this->commandProcess = new Process($productsCommand);

            $this->commandProcess->setTty($this->commandProcess->isTtySupported());

            $this->commandProcess->setTimeout(null);

            try {
                $this->commandProcess->mustRun();
            } catch (ProcessFailedException $e) {
                throw new \Exception($productsCommand . ' failed');
            }

            // Can be used for callback architecture style.
            //$this->commandProcess->start();
            //$this->commandProcess->wait();
        }

        while ($this->commandProcess->isRunning()) {
            yield true;
        }

        $processStdout = $this->commandProcess->getOutput();
        //$processStderr = $this->commandProcess->getErrorOutput();

        $aggregateValueObject = new AggregateImmutableValueObject();

        $aggregateValueObject = $aggregateValueObject->unserialize($processStdout);

        $event = new ReadProductsCompleted(
            $aggregateValueObject,
            $this->aggregateRootName,
            ProductsReadModel::READ_COMPLETED
        );

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
