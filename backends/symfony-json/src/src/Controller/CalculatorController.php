<?php

declare(strict_types=1);

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CalculatorController
{
    #[Route('/add/{a}/{b}')]
    public function add(int $a, int $b): JsonResponse
    {
        return new JsonResponse($a + $b);
    }
}