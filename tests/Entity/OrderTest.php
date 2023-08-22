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
        $order = new Order();
        $order->setNumber('12345');
        $order->setTotalPrice(100.00);
        $order->setUserId($user);

        $this->assertEquals('12345', $order->getNumber());
        $this->assertEquals(100.00, $order->getTotalPrice());
        $this->assertEquals($user, $order->getUserId());
    }
}
