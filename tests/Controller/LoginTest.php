<?php
 
namespace App\Tests\Controller;
 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
 
class LoginTest extends WebTestCase
{
    private $client;
 
    protected function setUp(): void
    {
        parent::setUp();
 
        $this->client = static::createClient();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Remettre le client à null
        $this->client = null;
    }
 
    public function testLoginPageIsRender()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion'); // Assurez-vous que le titre de la page est "Connexion"
    }
 
    public function testSuccessfulLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Connexion')->form();
        $form['_email'] = 'd.libotte78@gmail.com';
        $form['_password'] = 'test78';

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect()); 
        $crawler = $this->client->followRedirect(); 

        $this->assertSelectorTextContains('h1', 'Bienvenue'); 
    }
 
    public function testWrongLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Connexion')->form();
        $form['_email'] = 'd.27@test.com';
        $form['_password'] = 'wrongpassword';

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect()); 
        $crawler = $this->client->followRedirect(); 

        $this->assertSelectorTextContains('.alert-danger', 'Invalid credentials'); 
    }
}
