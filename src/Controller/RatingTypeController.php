<?php

namespace App\Controller;

use App\Entity\RatingTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RatingTypeController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This function to return all rating types.
     *
     * @return Response all rating types.
     */
    #[Route('/rating-types', methods: 'GET')]
    public function index(): Response
    {
        $ratingTypes = $this->entityManager->getRepository(RatingTypes::class)->findAll();
        return $this->json($ratingTypes);
    }


    /**
     * This function to create new rating type.
     *
     * @param Request $request The first number to add.
     * @param ValidatorInterface $validator The second number to add.
     *
     * @return Response The new created resource.
     */
    #[Route('/rating-types', methods:"POST")]
    public function create(Request $request, ValidatorInterface $validator) :Response
    {
        $data = json_decode($request->getContent());

        $ratingTypes = new RatingTypes();
        $ratingTypes->setCode($data->code);
        $ratingTypes->setDisplay($data->display);
        $ratingTypes->setCreated(new \DateTime());

        $errors = $validator->validate($ratingTypes);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $this->entityManager->persist($ratingTypes);
        $this->entityManager->flush();

        return $this->json($ratingTypes, Response::HTTP_CREATED);
    }

    /**
     * This function to delete existing resource.
     *
     * @param Request $request which includes the rating type code for example OVERALL.
     *
     * @return Response The deleted resource.
     */
    #[Route('/rating-types', methods:"DELETE")]
    public function delete(Request $request): Response
    {
        $ratingType = $this->entityManager->getRepository(RatingTypes::class)->findBy(['code'=>$request->get('code')]);
        if (!$ratingType) {
            throw new NotFoundHttpException('rating type not found');
        }
        $this->entityManager->remove($ratingType[0]);
        $this->entityManager->flush();
        return $this->json($ratingType);
    }
}
