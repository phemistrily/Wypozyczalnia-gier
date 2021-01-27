<?php

namespace tests\App\Entity;

use App\Entity\Basket;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
 
class BasketTest extends TestCase
{
    public function testAddNewBasket()
    {
        $user = new User();

        $basket = new Basket($user);

        $this->assertEquals("NEW", $basket->getStatus());
        $this->assertEquals($user, $basket->getUser());
    }

    public function testAddPaidBasket()
    {
        $user = new User();

        $basket = new Basket($user, "PAID");

        $this->assertEquals("PAID", $basket->getStatus());
        $this->assertEquals($user, $basket->getUser());
    }

    public function testAddClosedBasket()
    {
        $user = new User();

        $basket = new Basket($user, "CLOSED");

        $this->assertEquals("CLOSED", $basket->getStatus());
        $this->assertEquals($user, $basket->getUser());
    }
}