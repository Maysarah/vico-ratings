<?php

namespace App\Controller;

use App\Entity\Vico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VicoController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * This function to return all vicos.
     *
     * @return Response all vicos.
     */
    #[Route('/vicos', methods: "GET")]
    public function index(): Response
    {
        $vicos = $this->entityManager->getRepository(Vico::class)->findAll();
        return $this->json($vicos);
    }

    /**
     * This function to create a vico.
     *
     * @param Request $request Request includes data to be saved {name}.
     *
     * @return Response The new created resource.
     */
    #[Route('/vicos', methods: "POST")]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent());

        $vicos = new Vico();
        $vicos->setName($data->name);
        $vicos->setCreated(new \DateTime());

        $errors = $this->validator->validate($vicos);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $this->entityManager->persist($vicos);
        $this->entityManager->flush();

        return $this->json($vicos,Response::HTTP_CREATED);
    }
}
