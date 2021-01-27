<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use App\Tests\SecurityTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class BasketControllerTest extends WebTestCase
{
    public function testBasketPageIsRenderedWhenLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('patox44@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/basket');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testBasketPageIsRenderedWhenNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/basket');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}