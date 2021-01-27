<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SellGameControllerTest extends WebTestCase
{
    public function testSellGamePageIsRenderedWhenLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('patox44@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/sell/game');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSellGamePageIsRenderedWhenNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/sell/game');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}