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

    protected function tearDown(): void
    {
        parent::tearDown();
        
        $this->client = null;
        $this->entityManager = null;
    }
 
    public function testRenderRegisterPage()
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Inscription');
    }
 
    public function testSuccessfulRegister()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('Inscription')->form();
        $form['registration_form[email]'] = 'newuser@example.com';
        $form['registration_form[password]'] = 'newpassword';
        $form['registration_form[firstName]'] = 'John';
        $form['registration_form[lastName]'] = 'Doe';

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Connexion'); 

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'newuser@example.com']);
        $this->assertInstanceOf(User::class, $user);
    }
}
