<?php

declare(strict_types=1);

namespace Otus\Hw20\Infrastructure\Http;

use Otus\Hw20\Application\UseCase\RequestStatementUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatementController extends AbstractController
{
    #[Route('/statement/request', name: 'statement_request', methods: ['GET', 'POST'])]
    public function request(Request $request, RequestStatementUseCase $useCase): Response
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->get('start_date'));
            $endDate = new \DateTime($request->request->get('end_date'));
            $useCase->execute($startDate, $endDate);
            return $this->json(['message' => 'Request accepted for processing']);
        }

        return $this->render('statement_form.html.twig');
    }
}
