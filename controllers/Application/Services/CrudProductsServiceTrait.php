<?php

namespace Application\Services;

trait CrudProductsServiceTrait
{

    protected $crudProducts;

    /**
     * @return mixed
     */
    public function getCrudProducts()
    {
        return $this->crudProducts;
    }

    /**
     * @param mixed $crudProducts
     */
    public function setCrudProducts($crudProducts)
    {
        $this->crudProducts = $crudProducts;
    }
}
