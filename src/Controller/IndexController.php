<?php

declare(strict_types=1);

namespace App\Controller;

use App\Queue\Message\MakeFinanceReportQueueMessage;
use App\Queue\QueueInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @throws \Exception
     */
    #[Route('/', name: 'generate', methods: ['POST'])]
    public function generate(Request $request, QueueInterface $queue): Response
    {
        $email = $request->request->get('email');
        $dateFrom = $request->request->get('from');
        $dateTo = $request->request->get('to');
        if (empty($email) || empty($dateFrom) || empty($dateTo)) {
            throw new BadRequestHttpException('Invalid params');
        }

        $queue->push(new MakeFinanceReportQueueMessage($email, new DateTime($dateFrom), new DateTime($dateTo)));

        $this->addFlash('notice', 'после генерации отчет будет оправлен вам на почту!');

        return $this->render('index/index.html.twig');
    }
}
