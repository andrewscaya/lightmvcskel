<?php

namespace Application\Services;

use Application\Models\Entity\Products;
use Application\Models\Traits\DoctrineTrait;
use Application\Models\Repository\ProductsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class CrudProductsService
{

    use DoctrineTrait;

    protected $products;

    protected $productsRepository;

    public function __construct(Products $products, EntityManager $em)
    {
        $this->products = $products;

        $this->em = $em;

        $this->productsRepository = new ProductsRepository(
            $this->em,
            new ClassMetaData('Application\Models\Entity\Products')
        );
    }

    public function create(array $array)
    {
        try {
            $this->productsRepository->save($array);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function read(int $id = null)
    {
        try {
            if (isset($id)) {
                $results = $this->getEm()->find(Products::class, $id);
            } else {
                $results = $this->productsRepository->findAll();
            }
        } catch (\Exception $e) {
            return false;
        }

        return $results;
    }

    public function update(array $array)
    {
        try {
            if (isset($array['id'])) {
                $products = $this->getEm()->find(Products::class, $array['id']);
                $this->productsRepository->save($array, $products);
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function delete(int $id)
    {
        try {
            $products = $this->getEm()->find(Products::class, $id);
            $this->productsRepository->delete($products);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
