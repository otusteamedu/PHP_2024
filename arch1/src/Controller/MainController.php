<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {}

    #[Route('/api/v1/age', name: 'app_main')]
    public function index(Request $request): JsonResponse
    {
        $response = $this->httpClient->request('GET', sprintf('https://api.agify.io?name=%s', $request->get('name', '')));

        return $this->json([
            'name' => $request->get('name', ''),
            'age' => $response->toArray()['age'],
        ]);
    }
}
