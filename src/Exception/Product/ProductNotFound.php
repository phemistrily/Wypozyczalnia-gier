<?php

declare(strict_types=1);

namespace App\Exception\Product;


use Doctrine\ORM\EntityNotFoundException;

class ProductNotFound extends EntityNotFoundException
{
    public static function forId(int $id): ProductNotFound
    {
        return new self(\sprintf('Product id: %d was not found', $id));
    }
}
