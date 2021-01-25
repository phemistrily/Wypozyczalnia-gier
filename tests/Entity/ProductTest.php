<?php

namespace tests\App\Entity;
 
use App\Entity\Product;
use PHPUnit\Framework\TestCase;
 
class ProductTest extends TestCase
{
    public function testAddNewProduct()
    {
        $product = new Product('Crash Bandicoot', 'Opis' , 80.20, 12);

        $this->assertEquals('Crash Bandicoot', $product->getName());
        $this->assertEquals('Opis', $product->getDescription());
        $this->assertEquals(80.20, $product->getPrice());
        $this->assertEquals(12, $product->getQuantity());
    }
}