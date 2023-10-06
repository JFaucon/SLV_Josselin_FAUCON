<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testAuthentification(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($adminUser);

        $client->request('GET', '/vehicle/update/14');

        $this->assertResponseIsSuccessful();

    }
}
