<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalculatorController
{
    #[Route('/calc/add/{a}/{b}')]
    public function add(int $a, int $b): JsonResponse
    {
        return new JsonResponse($a + $b);
    }
}