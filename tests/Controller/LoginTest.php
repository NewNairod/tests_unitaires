<?php

namespace App\Tests\Controller;

use App\DataFixtures\LoginUserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->loadFixtures([LoginUserFixtures::class]);
    }

    public function testLoginPageIsRendered()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Login'); // Assurez-vous que le titre de la page est "Login"
    }

    public function testSuccessfulLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Login')->form();
        $form['_email'] = 'dorian@test.com';
        $form['_password'] = 'testpassword';

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect()); // Assurez-vous que la redirection réussisse
        $crawler = $this->client->followRedirect(); // Suivez la redirection

        $this->assertSelectorTextContains('h1', 'Welcome'); // Assurez-vous que la page d'accueil contienne le texte "Welcome"
    }

    public function testWrongLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'testuser';
        $form['_password'] = 'wrongpassword';

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect()); // Assurez-vous que la redirection réussisse
        $crawler = $this->client->followRedirect(); // Suivez la redirection

        $this->assertSelectorTextContains('.alert-danger', 'Invalid credentials'); // Assurez-vous que le message d'erreur s'affiche
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Remettre client à null
        $this->client = null;
    }
}
