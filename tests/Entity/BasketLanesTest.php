<?php

namespace tests\App\Entity;
 
use App\Entity\Basket;
use App\Entity\BasketLanes;
use App\Entity\Product;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
 
class BasketLanesTest extends TestCase
{
    public function testAddNewBasketLane()
    {
        $user = new User();

        $basket = new Basket($user);
        $product = new Product('Crash Bandicoot', 'Opis' , 80.20, 12);

        $basketLane = new BasketLanes($basket, $product, 2);

        $this->assertEquals($basket, $basketLane->getBasket());
        $this->assertEquals($product, $basketLane->getProduct());
        $this->assertEquals(2, $basketLane->getQuantity());
    }
}