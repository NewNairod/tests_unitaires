<?php

namespace App\Tests\Controller;

use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    private $client;
    private $entityManager;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        
        $this->loadFixtures([UserFixtures::class]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Supprimer l'utilisateur qu'on vient de créer en BDD
        $user = $this->entityManager->getRepository(User::class)->findOneByUsername('testuser');
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }

        // Remettre client et entity manager à null
        $this->client = null;
        $this->entityManager = null;
    }
}
