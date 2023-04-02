<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RatingTypeControllerTest extends WebTestCase
{
    public function testGetAllRatingTypes()
    {
        $client = static::createClient();
        $client->request('GET', '/rating-types');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        // Verify that the response contains an array of Rating type objects
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($response);

        foreach ($response as $project) {
            $this->assertArrayHasKey('id', $project);
            $this->assertArrayHasKey('code', $project);
            $this->assertArrayHasKey('display', $project);
            $this->assertArrayHasKey('created', $project);

            // Add any other assertions for Rating type properties as needed
        }
    }

    public function testCreateRatingType(): void
    {
        $client = static::createClient();
        $faker = Factory::create();

        $rateTypeFakeData = [
            'code' => $faker->name(),
            'display'=> $faker->text(255)
            ];
        $client->request('POST', '/rating-types', [], [], [], json_encode([
            'code' => $rateTypeFakeData ['code'],
            'display' => $rateTypeFakeData ['display'],
        ]));
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        // Assert that the response contains the created client data
        $this->assertJson($response->getContent());
        $ratingTypeData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $ratingTypeData);
        $this->assertArrayHasKey('code', $ratingTypeData);
        $this->assertArrayHasKey('display', $ratingTypeData);
        $this->assertArrayHasKey('created', $ratingTypeData);

        // Assert that the created vico data matches the request data
        $this->assertSame($rateTypeFakeData ['code'], $ratingTypeData['code']);
        $this->assertSame($rateTypeFakeData ['display'], $ratingTypeData['display']);

    }


}
