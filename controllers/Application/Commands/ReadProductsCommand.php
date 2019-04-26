<?php

namespace Application\Commands;

use Application\Models\Entity\Products;
use Application\Models\Repository\ProductsRepository;
use Ascmvc\AbstractApp;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReadProductsCommand extends ProductsCommand
{
    protected static $defaultName = 'products:read';

    public function __construct(AbstractApp $webapp)
    {
        // you *must* call the parent constructor
        parent::__construct($webapp);
    }

    protected function configure()
    {
        $this
            ->setName('products:read')
            ->setDescription("Query Doctrine for 'Products' entities.");
        $this
            // configure options
            ->addOption('values', null, InputOption::VALUE_REQUIRED, 'Specify a serialized value object array to use.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connName = $this->getWebapp()->getBaseConfig()['events']['read_conn_name'];

        $entityManager = $this->getWebapp()->getServiceManager()[$connName];

        $serializedAggregateValueObjectProperties = $input->getOption('values');

        $args = unserialize($serializedAggregateValueObjectProperties);

        $productsRepository = new ProductsRepository(
            $entityManager,
            new ClassMetadata(Products::class)
        );

        try {
            if (isset($args['id'])) {
                $result = $productsRepository->find($args['id']);
                $results[] = $productsRepository->hydrateArray($result);
            } else {
                $results = $productsRepository->findAll();
            }
        } catch (\Exception $e) {
            return 1;
        }

        $outputValues = serialize($results);

        $output->writeln($outputValues);
    }
}