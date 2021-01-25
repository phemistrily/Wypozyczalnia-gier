<?php

declare(strict_types=1);

namespace App\Exception\Basket;


use Doctrine\ORM\EntityNotFoundException;

class BasketNotFound extends EntityNotFoundException
{
    public static function forId(int $id): BasketNotFound
    {
        return new self(\sprintf('Basket id: %d was not found', $id));
    }
}
