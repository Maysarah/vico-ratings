<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectRatings;
use App\Entity\RatingTypes;
use App\Requests\ProjectRatingRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectRatingController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * This function all projects with all ratings related.
     *
     * @return Response all projects.
     */
    #[Route('/project-ratings', methods: 'GET')]
    public function index(): Response
    {
        $projectsRatings = $this->entityManager->getRepository(ProjectRatings::class)->findAll();

        return $this->json($projectsRatings);
    }

    /**
     * This function all ratings related to a specific project.
     *
     * @return Response all ratings.
     */
    #[Route('/project-ratings/{project_id}', methods: 'GET')]
    public function show($project_id): Response
    {
        $projectRatings = $this->entityManager->getRepository(ProjectRatings::class)
            ->findBy(['project_id' => $project_id]);

        if (!$projectRatings) {
            throw new NotFoundHttpException('There is no rating to project with id:' . $project_id);
        }

        return $this->json($projectRatings);
    }

    /**
     * This function to create new rating for a specific project.
     *
     * @param Request $request Request includes data we want to add
     * {
     * "project_id": "id": 2,
     * "ratings": [
     * {
     * "rating_type_code": "OVERALL",
     * "rating" : 4,
     * "client_note": "this is a new test"
     * },
     * {
     * "rating_type_code": "QOW",
     * "rating" : 3
     * },
     * {
     * "rating_type_code": "COMM",
     * "rating" : 5
     * }
     * ]
     * }.
     *
     * @return Response The new created resource.
     */
    #[Route('/project-ratings', methods: "POST")]
    public function create(Request $request): Response
    {

        $data = json_decode($request->getContent());

        //check project we want to rate
        $project = $this->entityManager->getRepository(Project::class)->find($data->project_id);
        if (!$project) {
            throw new NotFoundHttpException('project not found');
        }

        $projectRatingsData = $data->project_ratings;
        $projectRatingsResponse = [];
        foreach ($projectRatingsData as $rating) {
            $projectRating = new ProjectRatings();
            $ratingType = $this->getRatingType($rating->rating_type_code);

            if ($this->isProjectRated($data->project_id, $ratingType[0]->id) === false) {
                $projectRating->setProjectId($project);
                $projectRating->setRatingTypeId($ratingType[0]);
                $projectRating->setClientNote($rating->client_note ?? null);
                $projectRating->setRating($rating->rating);
                $projectRating->setCreated(new \DateTime());
                $projectRating->setUpdated(new \DateTime());

                $projectRatingsResponse [] = $projectRating;
                $errors = $this->validator->validate($projectRating);
                if (count($errors) > 0) {
                    return $this->json($errors, 400);
                }
                $this->entityManager->persist($projectRating);
            }

        }
        $this->entityManager->flush();


        return $this->json(
            empty($projectRatingsResponse)
                ? "message: Project is already rated, Please use update api to update existing rate"
                : $projectRatingsResponse , Response::HTTP_CREATED);
    }

    /**
     * This function to update existing rating for a specific project.
     *
     * @param Request $request Request includes data we want to update
     * {
     *
     * "project_ratings": [
     * {
     * "rating_type_code": "OVERALL",
     * "rating": 4,
     * "client_note": "this is a new test from upate"
     * },
     * {
     * "rating_type_code": "QOW",
     * "rating": 3
     * },
     * {
     * "rating_type_code": "COMM",
     * "rating": 5
     * }
     * ]
     * }.
     *
     * @return Response The new created resource.
     */
    #[Route('/project-ratings/projects/{project_id}', methods: "PUT")]
    public function update(Request $request, $project_id): Response
    {
        $projectRatings = $this->entityManager->getRepository(ProjectRatings::class)
            ->findBy(['project_id' => $project_id]);

        if (!$projectRatings) {
            $this->create($request);
        }

        $data = json_decode($request->getContent());
        $projectRatingsData = $data->project_ratings;
        $projectRatingsResponse = [];
        foreach ($projectRatingsData as $rating) {

            $projectRating = $this->entityManager->getRepository(ProjectRatings::class)
                ->findBy(['project_id' => $project_id, 'rating_type_id' => $this->getRatingType($rating->rating_type_code)[0]->id])[0];

            $projectRating->setClientNote($rating->client_note ?? null);
            $projectRating->setRating($rating->rating);

            $projectRatingsResponse [] = $projectRating;
            $errors = $this->validator->validate($projectRating);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }
            $this->entityManager->persist($projectRating);
        }

        $this->entityManager->flush();
        return $this->json($projectRatingsResponse);
    }


    /**
     * This function to get rating type object using rating type code .
     * @param $ratingTypeCode
     * @return array rating type.
     */
    private function getRatingType($ratingTypeCode): array
    {
        //check the rating type
        $ratingType = $this->entityManager->getRepository(RatingTypes::class)->findBy(['code' => $ratingTypeCode]);
        if (!$ratingType) {
            throw new NotFoundHttpException('rating type for' . $ratingTypeCode . ' is not found');
        }
        return $ratingType;
    }

    /**
     * This function to check if the project is rated or not  .
     * @param $projectId
     * @param $rateTypeId
     * @return bool rated.
     */
    private function isProjectRated($projectId, $rateTypeId): bool
    {
        $isProjectRated = $this->entityManager->getRepository(ProjectRatings::class)
            ->findBy(['project_id' => $projectId, 'rating_type_id' => $rateTypeId]);

        if ($isProjectRated) {
            return true;
        }
        return false;
    }
}
