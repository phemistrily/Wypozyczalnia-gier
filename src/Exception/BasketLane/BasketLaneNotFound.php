<?php

declare(strict_types=1);

namespace App\Exception\BasketLane;


use Doctrine\ORM\EntityNotFoundException;

class BasketLaneNotFound extends EntityNotFoundException
{
    public static function forId(int $id): BasketLaneNotFound
    {
        return new self(\sprintf('Basket Lane id: %d was not found', $id));
    }
}
