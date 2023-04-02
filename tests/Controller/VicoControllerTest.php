<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VicoControllerTest extends WebTestCase
{
    public function testGetAllVicos(): void
    {
        // Create a new client to make requests
        $client = static::createClient();

        // Make a GET request to the /vicos endpoint
        $client->request('GET', '/vicos');

        // Verify that the response has a 200 status code
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Verify that the response is a JSON string
        $this->assertJson($client->getResponse()->getContent());

        // Verify that the response contains an array of Vico objects
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($response);

        foreach ($response as $vico) {
            $this->assertArrayHasKey('id', $vico);
            $this->assertArrayHasKey('name', $vico);
            $this->assertArrayHasKey('created', $vico);
            // Add any other assertions for Vico properties as needed
        }
    }

    public function testCreateVico(): void
    {
        $client = static::createClient();
        $faker = Factory::create();

        $vicoFakeData = ['name' => $faker->name()];
        $client->request('POST', '/vicos', [], [], [], json_encode([
            'name' => $vicoFakeData ['name'],
        ]));
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        // Assert that the response contains the created client data
        $this->assertJson($response->getContent());
        $vicoData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $vicoData);
        $this->assertArrayHasKey('name', $vicoData);
        $this->assertArrayHasKey('created', $vicoData);

        // Assert that the created vico data matches the request data
        $this->assertSame($vicoFakeData ['name'], $vicoData['name']);
    }
}