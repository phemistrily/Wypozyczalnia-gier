<?php

declare(strict_types=1);

namespace App\Exception\ProductCategory;

use Doctrine\ORM\EntityNotFoundException;

class CategoryNotFound extends EntityNotFoundException
{
    public static function forId(int $id): CategoryNotFound
    {
        return new self(\sprintf('Product category id: %d was not found', $id));
    }
}
