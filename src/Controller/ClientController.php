<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ClientController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * This function to return all clients.
     *
     * @return Response all clients.
     */
    #[Route('/clients', methods: "GET")]
    public function index(): Response
    {
        $clients = $this->entityManager->getRepository(Client::class)->findAll();

        return $this->json($clients);
    }

    /**
     * This function to create a client.
     *
     * @param Request $request Request includes data to be saved {fist_name, last_name, username, password}.
     * @param UserPasswordHasherInterface $passwordHasher to hash the password before save.
     *
     * @return Response The new created resource.
     */
    #[Route('/clients', methods: "POST")]
    public function create(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent());

        $client = new Client();
        $client->setFirstName($data->first_name);
        $client->setLastName($data->last_name);
        $client->setUserName($data->username);
        $client->setCreated(new \DateTime());

        $plaintextPassword = $data->password;
        $hashedPassword = $passwordHasher->hashPassword($client, $plaintextPassword);
        $client->setPassword($hashedPassword);

        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $this->json($client, Response::HTTP_CREATED);
    }
}
