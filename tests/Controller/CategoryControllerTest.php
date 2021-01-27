<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCategoryPageIsRenderedWhenLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('patox44@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/category?id=1');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCategoryPageIsRenderedWhenNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/category?id=1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCategoryPageWithIncorrectDataIsRenderedWhenLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('patox44@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/category');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testCategoryPageWithIncorrectDataIsRenderedWhenNotLoggedIn(): void
    {
        $client = static::createClient();

        $client->request('GET', '/category');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

}