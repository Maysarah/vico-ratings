<?php

namespace App\Tests\Controller;

use App\Repository\ProjectRatingRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProjectRatingControllerTest extends WebTestCase
{
    public function testGetAllProjectRatings(): void
    {
        // Create a new client to make requests
        $client = static::createClient();

        // Make a GET request to the /vicos endpoint
        $client->request('GET', '/project-ratings');

        // Verify that the response has a 200 status code
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Verify that the response is a JSON string
        $this->assertJson($client->getResponse()->getContent());

        // Verify that the response contains an array of Vico objects
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($response);

        foreach ($response as $projectRating) {

            $this->assertArrayHasKey('id', $projectRating);
            $this->assertArrayHasKey('projectId', $projectRating);
            $this->assertArrayHasKey('ratingTypeId', $projectRating);
            $this->assertArrayHasKey('clientNote', $projectRating);
            // Add any other assertions for projectRating properties as needed
        }
    }

    public function testCreateProjectRating(): void
    {
        $client = static::createClient();
        $faker = Factory::create();
        $projectIdsInTestDB = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // project ids in test DB

        $projectRatingFakeData = [
            "project_id" => $projectIdsInTestDB[array_rand($projectIdsInTestDB)],
            "project_ratings" => [
                [
                    "rating_type_code" => "OVERALL",
                    "rating" => $faker->numberBetween(1, 5),
                    "client_note" => $faker->text(1000)
                ],
                [
                    "rating_type_code" => "QOW",
                    "rating" => $faker->numberBetween(1, 5),
                ],
                [
                    "rating_type_code" => "COMM",
                    "rating" => $faker->numberBetween(1, 5),
                ]
            ]
        ];
        $client->request('POST', '/project-ratings', [], [], [], json_encode($projectRatingFakeData));
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        // Assert that the response contains the created client data
        $this->assertJson($response->getContent());
        $projectRatingData = json_decode($response->getContent(), true);

        if (is_array($projectRatingData)) { // already rated projects return a string exception
            foreach ($projectRatingData as $projectRating) {
                $this->assertArrayHasKey('id', $projectRating);
                $this->assertArrayHasKey('ratingTypeId', $projectRating);
                $this->assertArrayHasKey('clientNote', $projectRating);
                $this->assertArrayHasKey('rating', $projectRating);
                $this->assertArrayHasKey('created', $projectRating);
                $this->assertArrayHasKey('updated', $projectRating);
            }

            // Assert that the created project rating data matches the request data
            foreach ($projectRatingData as $ratingDatum) {
                foreach ((array)$projectRatingFakeData["project_ratings"] as $ratingFakeDatum) {
                    if ($ratingFakeDatum ["rating_type_code"] == $ratingDatum["ratingTypeId"]["code"]) {
                        $this->assertSame($projectRatingFakeData ["project_id"], $ratingDatum["projectId"]["id"]);
                        $this->assertSame($ratingFakeDatum ["rating_type_code"], $ratingDatum["ratingTypeId"]["code"]);
                        $this->assertSame($ratingFakeDatum ["rating"], $ratingDatum["rating"]);
                        if (isset($ratingFakeDatum ["client_note"])) {
                            $this->assertSame($ratingFakeDatum ["client_note"], $ratingDatum["clientNote"]);
                        }
                    }
                }
            }
        }
    }

    public function testUpdateProjectRating(): void
    {
        $client = static::createClient();
        $faker = Factory::create();
        $projectIdsInTestDB = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // project ids in test DB
        $projectId = $projectIdsInTestDB[array_rand($projectIdsInTestDB)];
        $projectRatingFakeData = [
            "project_ratings" => [
                [
                    "rating_type_code" => "OVERALL",
                    "rating" => $faker->numberBetween(1, 5),
                    "client_note" => $faker->text(1000)
                ],
                [
                    "rating_type_code" => "QOW",
                    "rating" => $faker->numberBetween(1, 5),
                ],
                [
                    "rating_type_code" => "COMM",
                    "rating" => $faker->numberBetween(1, 5),
                ]
            ]
        ];
        $client->request('PUT', '/project-ratings/projects/' . $projectId , [], [], [], json_encode($projectRatingFakeData));
        $response = $client->getResponse();
        // Assert that the response status code is 200
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        // Assert that the response contains the created client data
        $this->assertJson($response->getContent());

        $projectRatingData = json_decode($response->getContent(), true);

        if (is_array($projectRatingData)) { // already rated projects return a string exception
            foreach ($projectRatingData as $projectRating) {
                $this->assertArrayHasKey('id', $projectRating);
                $this->assertArrayHasKey('ratingTypeId', $projectRating);
                $this->assertArrayHasKey('clientNote', $projectRating);
                $this->assertArrayHasKey('rating', $projectRating);
                $this->assertArrayHasKey('created', $projectRating);
                $this->assertArrayHasKey('updated', $projectRating);
            }
            // Assert that the updated project rating data matches the request data
            foreach ($projectRatingData as $ratingDatum) {
                foreach ((array)$projectRatingFakeData["project_ratings"] as $ratingFakeDatum) {
                    if ($ratingFakeDatum ["rating_type_code"] == $ratingDatum["ratingTypeId"]["code"]) {
                        $this->assertSame($projectId, $ratingDatum["projectId"]["id"]);
                        $this->assertSame($ratingFakeDatum ["rating_type_code"], $ratingDatum["ratingTypeId"]["code"]);
                        $this->assertSame($ratingFakeDatum ["rating"], $ratingDatum["rating"]);
                        if (isset($ratingFakeDatum ["client_note"])) {
                            $this->assertSame($ratingFakeDatum ["client_note"], $ratingDatum["clientNote"]);
                        }
                    }
                }
            }
        }
    }
}
