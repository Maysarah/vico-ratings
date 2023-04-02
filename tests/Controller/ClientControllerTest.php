<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ClientControllerTest extends WebTestCase
{
    public function testCreateClient(): void
    {
        $client = static::createClient();
        $faker = Factory::create();
        $clientFakeData = [
            "firstName" => $faker->firstName(),
            "lastName" => $faker->lastName(),
            "userName" => $faker->userName(),
            "password" => $faker->password()
        ];

        // Make a POST request to the create client endpoint
        $client->request('POST', '/clients', [], [], [], json_encode([
            'first_name' => $clientFakeData ['firstName'] ,
            'last_name' => $clientFakeData ['lastName'],
            'username' => $clientFakeData ['userName'],
            'password' => $clientFakeData ['password']
        ]));

        $response = $client->getResponse();


        // Assert that the response status code is 200
        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        // Assert that the response contains the created client data
        $this->assertJson($response->getContent());

        $clientData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $clientData);
        $this->assertArrayHasKey('firstName', $clientData);
        $this->assertArrayHasKey('lastName', $clientData);
        $this->assertArrayHasKey('userName', $clientData);
        $this->assertArrayHasKey('created', $clientData);

        // Assert that the created client data matches the request data
        $this->assertSame($clientFakeData ['firstName'], $clientData['firstName']);
        $this->assertSame($clientFakeData ['lastName'], $clientData['lastName']);
        $this->assertSame($clientFakeData ['userName'], $clientData['userName']);

        // Assert that the created client password is hashed
        $this->assertNotSame('password123', $clientData['password']);
    }

    public function testGetAllClients()
    {
        $client = static::createClient();
        $client->request('GET', '/clients');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        // Verify that the response contains an array of client objects
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($response);

        foreach ($response as $client) {
            $this->assertArrayHasKey('id', $client);
            $this->assertArrayHasKey('firstName', $client);
            $this->assertArrayHasKey('lastName', $client);
            $this->assertArrayHasKey('userName', $client);
            $this->assertArrayHasKey('password', $client);
            $this->assertArrayHasKey('created', $client);

            // Add any other assertions for client properties as needed
        }
    }
}
