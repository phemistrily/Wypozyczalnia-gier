<?php

namespace tests\App\Entity;

use App\Entity\Loans;
use App\Entity\Product;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
 
class LoansTest extends TestCase
{
    public function testAddNewLoan()
    {
        $user = new User();

        $product = new Product('Crash Bandicoot', 'Opis' , 80.20, 12);

        $dateStart = new \DateTime();
        $dateEnd = new \DateTime('+1 month');
        $loan = new Loans($user, $product, $dateStart, $dateEnd);

        $this->assertEquals($user, $loan->getUser());
        $this->assertEquals($product, $loan->getProduct());
        $this->assertEquals($dateStart, $loan->getDateLoan());
        $this->assertEquals($dateEnd, $loan->getDateExpectedFinishLoan());
    }
}