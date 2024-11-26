<?php

namespace App\Infrastructure\Controllers;

use App\Application\DTO\GetAgeByNameRequestDTO;
use App\Application\UseCase\GetAgeByNameUseCase;
use App\Domain\ValueObjects\Name;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class MainController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger,
        private GetAgeByNameUseCase $getAgeByName
    ) {
        //
    }

    #[Route('/api/v1/age')]
    public function index(Request $request): JsonResponse
    {
        $name = (new Name($request->get('name', '')));

        $response = $this->httpClient->request('GET', sprintf('https://api.agify.io?name=%s', $name->getValue()));

        return $this->json([
            'name' => $request->get('name', ''),
            'age' => $response->toArray()['age'],
        ]);
    }

    #[Route('/api/v2/age')]
    public function getAge(Request $request): JsonResponse
    {
        try {
            $dto = new GetAgeByNameRequestDTO(
                (new Name($request->get('name', '')))->getValue()
            );

            $nameAge = ($this->getAgeByName)($dto);

            return $this->json([
                'success' => true,
                'data' => [
                    'name' => $nameAge->getName(),
                    'age' => $nameAge->getAge(),
                ]
            ]);

        } catch (Throwable $e) {
            $this->logger->error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));

            return $this->json([
                'success' => false,
                'error' => 'Возникла непредвиденная ошибка',
            ]);
        }
    }
}
