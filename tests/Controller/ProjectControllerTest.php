<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends WebTestCase
{
    public function testGetAllProjects()
    {
        $client = static::createClient();
        $client->request('GET', '/projects');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        // Verify that the response contains an array of project objects
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($response);

        foreach ($response as $project) {
            $this->assertArrayHasKey('id', $project);
            $this->assertArrayHasKey('creatorId', $project);
            $this->assertArrayHasKey('vicoId', $project);
            $this->assertArrayHasKey('title', $project);
            $this->assertArrayHasKey('created', $project);

            // Add any other assertions for project properties as needed
        }
    }

    public function testCreateProject(): void
    {
        $client = static::createClient();
        $faker = Factory::create();
        $creatorIdInTestDB = [1,2,4,9,11]; // client ids in test DB
        $vicoIdsInTestDB = [1,2,3,4,5,6,7,8,9]; // vico ids in test DB
        $projectFakeData = [
            "creatorId" => $creatorIdInTestDB[array_rand($creatorIdInTestDB)],
            "vicoId" => $vicoIdsInTestDB[array_rand($vicoIdsInTestDB)],
            "title" => $faker->title(),
        ];

        // Make a POST request to the create client endpoint
        $client->request('POST', '/projects', [], [], [], json_encode([
            'creator_id' => $projectFakeData ['creatorId'],
            'vico_id' => $projectFakeData ['vicoId'],
            'title' => $projectFakeData ['title'],
        ]));

        $response = $client->getResponse();

        // Assert that the response status code is 200
        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        // Assert that the response contains the created client data
        $this->assertJson($response->getContent());

        $projectData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $projectData);
        $this->assertArrayHasKey('creatorId', $projectData);
        $this->assertArrayHasKey('vicoId', $projectData);
        $this->assertArrayHasKey('title', $projectData);
        $this->assertArrayHasKey('created', $projectData);

        // Assert that the created client data matches the request data
        $this->assertSame($projectFakeData ['title'], $projectData['title']);
        $this->assertSame($projectFakeData ['creatorId'], $projectData['creatorId']['id']);
        $this->assertSame($projectFakeData ['vicoId'], $projectData['vicoId']['id']);
    }
}
