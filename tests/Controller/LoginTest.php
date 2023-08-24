<?php
 
namespace App\Tests\Controller; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class LoginTest extends WebTestCase
{
    private $client;
 
    protected function setUp():void
    {
        parent::setUp();
        $this->client = static::createClient();
    }
    public function testLoginPageIsRender()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }
 
    public function testSuccessfulLogin()
    {
       // Faire la requête
       $crawler = $this->client->request('GET', '/login');
       // Soumettre le formulaire
       $form = $crawler->selectButton('login')->form([
        '_username' => 'test@test.com',
        '_password' => 'testtest',
        ]);
        $this->client->submit($form);
       // vérifier qu'on est bien redirigé vers la page d'accueil
       $this->assertResponseRedirects();
        $location = $this->client->getResponse()->headers->get('Location');
        $this->assertStringEndsWith('/accueil', $location);

        // Suivre la redirection
        $crawler = $this->client->followRedirect();
        // vérifier que la page d'accueil contient bien les bons textes
        $this->assertSelectorTextContains('p', 'Vous êtes connecté');
    }

    public function testWrongLogin()
    {

       $crawler = $this->client->request('GET', '/login');

       $form = $crawler->selectButton('login')->form([
        '_email' => 'test@test.com',
        '_password' => 'testtest',
        ]);
        $this->client->submit($form);
       $this->assertResponseRedirects('/accueil');
        $crawler = $this->client->followRedirect();
        $this->assertSelectorTextContains('p', "Vous n'êtes pas connecté");
    }
}