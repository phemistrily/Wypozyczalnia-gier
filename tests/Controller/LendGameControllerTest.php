<?php
namespace App\Tests\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LendGameControllerTest extends WebTestCase
{
    public function testUserPageIsRenderedWhenLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('patox44@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/lend/game');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUserPageIsRenderedWhenNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/lend/game');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}