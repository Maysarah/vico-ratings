<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Vico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This function to return all projects.
     *
     * @return Response all projects.
     */
    #[Route('/projects', methods: "GET")]
    public function index(): Response
    {
        $projects = $this->entityManager->getRepository(Project::class)->findAll();
        return $this->json($projects);
    }

    /**
     * This function to create a project for a specific vico by specific client.
     *
     * @param Request $request Request includes data to be saved {vico_id, creator_id, title}.
     *
     * @return Response The new created resource.
     */
    #[Route('/projects', methods: "POST")]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent());
        $client = $this->entityManager->getRepository(Client::class)->find($data->creator_id);
        if (!$client) {
            throw new NotFoundHttpException('Client not found');
        }
        $vico = $this->entityManager->getRepository(Vico::class)->find($data->vico_id);

        $project = new Project();
        $project->setVicoId($vico);
        $project->setCreatorId($client);
        $project->setTitle($data->title);
        $project->setCreated(new \DateTime());

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this->json($project,Response::HTTP_CREATED);
    }
}
