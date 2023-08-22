<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testCreateUser()
    {
        $user = new User();
        $user->setLastName('Dorian');
        $user->setFirstName('Libotte');
        $user->setEmail('dorian@example.com');
        $user->setPassword('password');
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals('Dorian', $user->getLastName());
        $this->assertEquals('Libotte', $user->getFirstName());
        $this->assertEquals('dorian@example.com', $user->getEmail());
        $this->assertEquals('password', $user->getPassword());
        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertEquals('dorian@example.com', $user->getUserIdentifier());
    }
}

