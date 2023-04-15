<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ThingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Dto\ThingDto;
use App\Entity\Thing;
use Symfony\Component\HttpFoundation\Response;

class ThingCrudController
{
    #[Route('/things', methods: ['POST'])]
    public function createThing(Request $request, ThingRepository $thingRepository): JsonResponse
    {
        $content = \json_decode($request->getContent(), true);

        $dto = new ThingDto();
        $dto->name = $content['name'];
        $dto->count = $content['count'];

        $thing = new Thing();
        $thing->setName($dto->name)
            ->setCount($dto->count);

        $thingRepository->save($thing, true);

        return new JsonResponse();
    }

    #[Route('/things', methods: ['GET'])]
    public function getThings(ThingRepository $thingRepository): JsonResponse
    {
        $things = $thingRepository->findAll();
        $response = [];
        foreach ($things as $thing) {
            $response[] = $thing->toArray();
        }

        return new JsonResponse($response);
    }

    #[Route('/things/{id}', methods: ['GET'])]
    public function getThing(int $id, ThingRepository $thingRepository): JsonResponse
    {
        $thing = $thingRepository->find($id);
        if ($thing) {
            return new JsonResponse($thing->toArray());
        } else {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/things/{id}', methods: ['PUT'])]
    public function editThing(int $id, Request $request, ThingRepository $thingRepository): JsonResponse
    {
        $content = \json_decode($request->getContent(), true);

        $dto = new ThingDto();
        $dto->name = $content['name'];
        $dto->count = $content['count'];

        $thing = $thingRepository->find($id);

        if ($thing) {
            $thing->setName($dto->name)
                ->setCount($dto->count);

            $thingRepository->save($thing, true);

            return new JsonResponse();
        } else {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/things/{id}', methods: ['DELETE'])]
    public function deleteThing(int $id, Thing $thing, ThingRepository $thingRepository): JsonResponse
    {
        $thing = $thingRepository->find($id);

        if ($thing) {
            $thingRepository->remove($thing, true);
            return new JsonResponse();
        } else {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }
}