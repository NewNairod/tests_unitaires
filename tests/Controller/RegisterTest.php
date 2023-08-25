<?php
 
namespace App\Tests\Controller;
 
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
 
class RegisterTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
 
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }
 
    public function testRenderRegisterPage()
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Inscription');
    }
 
    public function testSuccessfulRegister()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form();
        $form['registration_form[email]'] = 'newuser@example.com';
        $form['registration_form[plainPassword]'] = 'newpassword';
        $form['registration_form[firstName]'] = 'John';
        $form['registration_form[lastname]'] = 'Doe';

        $this->client->submit($form);

        $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/login', $location);
        $crawler = $this->client->followRedirect();
        $this->assertSelectorTextContains('h2', "Connexion");
        
       // Vérifier qu'on retrouve bien l'utilisateur en BDD
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'newuser@example.com']);
        $this->assertInstanceOf(User::class, $user);
    }

    protected function tearDown():void{
        parent::tearDown();

        // Supprimer l'utilisateur créé en BDD
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'newuser@example.com']);
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }

        // Remettre le client et l'entity manager à null
        $this->client = null;
        $this->entityManager = null;
    }
}