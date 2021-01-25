<?php
namespace App\Services;

use App\Repository\ProductCategoryRepository;

class ProductCategoryService
{
    private $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function getCategories()
    {
        return $this->productCategoryRepository->getProductCategories();
    }

}