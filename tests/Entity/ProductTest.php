<?php


namespace App\Tests\Entity;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    public function testCreateProduct()
    {
        $product = new Product();
        $product->setName('Figurine POP');
        $product->setPrice(19.99);

        $this->assertEquals('Figurine POP', $product->getName());
        $this->assertEquals(19.99, $product->getPrice());
    }
}
