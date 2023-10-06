<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehicleControllerTest extends WebTestCase
{
    public function testAppVehicle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/vehicle');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Vehicule de location');
    }
    public function testVehicleForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($adminUser);
        $client->request('GET', '/vehicle/update');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Envoyer', "Le formulaire est bien affiché");
    }
    public function testVehicleDelete(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($adminUser);
        $client->request('GET', '/vehicle/remove/15');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Vehicule de location', "Delete");
    }
}
