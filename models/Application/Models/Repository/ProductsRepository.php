<?php

namespace Application\Models\Repository;

use Application\Models\Entity\Products;
use Doctrine\ORM\EntityRepository;

class ProductsRepository extends EntityRepository
{

    protected $products;

    public function findAll()
    {
        return $this->findBy([], ['id' => 'ASC']);
    }

    public function save(array $productArray, $products = null)
    {
        $this->products = $this->setData($productArray, $products);

        try {
            $this->_em->persist($this->products);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function delete(Products $products)
    {
        $this->products = $products;

        try {
            $this->_em->remove($this->products);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function setData(array $productArray, Products $products = null)
    {
        if (!$products) {
            $this->products = new Products();
        } else {
            $this->products = $products;
        }

        $this->products->setName($productArray['name']);
        $this->products->setPrice($productArray['price']);
        $this->products->setDescription($productArray['description']);
        $this->products->setImage($productArray['image']);

        return $this->products;
    }
}
