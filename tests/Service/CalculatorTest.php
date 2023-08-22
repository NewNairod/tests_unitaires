<?php

namespace App\Tests\Service;

use App\Service\Calculator;
use App\Entity\Product; // Import your Product entity
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testGetTotalHT()
    {
        $calculator = new Calculator();
        $product1 = new Product();
        $product1->setPrice(10);
        $product2 = new Product();
        $product2->setPrice(15);

        $products = [
            ['product' => $product1, 'quantity' => 2],
            ['product' => $product2, 'quantity' => 3],
        ];

        $totalHT = $calculator->getTotalHT($products);

        $this->assertEquals(10 * 2 + 15 * 3, $totalHT);
    }

    public function testGetTotalTTC()
    {
        $calculator = new Calculator();
        $product1 = new Product();
        $product1->setPrice(10);
        $product2 = new Product();
        $product2->setPrice(15);

        $products = [
            ['product' => $product1, 'quantity' => 2],
            ['product' => $product2, 'quantity' => 3],
        ];
        
        $tva = 20;
        
        $totalTTC = $calculator->getTotalTTC($products, $tva);

        $expectedTotalTTC = (10 * 2 + 15 * 3) * (1 + ($tva / 100));
        $this->assertEquals($expectedTotalTTC, $totalTTC);
    }
}

