<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
{
    public function testCreateOrder()
    {
        $user = new User();
        $user->setEmail("dorian@exemple.com");
        $order = new Order();
        $order->setNumber('12345');
        $order->setTotalPrice(100.00);
        $order->setUserId($user);

        $this->assertEquals('12345', $order->getNumber());
        $this->assertEquals(100.00, $order->getTotalPrice());
        $this->assertEquals("dorian@exemple.com", $order->getUserId()->getEmail());
    }
}
