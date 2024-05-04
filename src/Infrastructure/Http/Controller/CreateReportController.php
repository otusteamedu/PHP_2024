<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CreateReportUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/report/create', name: 'report_create', methods: 'POST')]
class CreateReportController extends AbstractController
{
    public function __invoke(CreateReportUseCase $createReportUseCase): Response
    {
        $result = call_user_func_array($createReportUseCase, []);

        return $this->json($result);
    }
}
