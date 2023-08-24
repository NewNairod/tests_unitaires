<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; 
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('dorian@test.com');
        $user->setLastName('testuser');
        $user->setFirstName('testuser');
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'testpassword');
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}


