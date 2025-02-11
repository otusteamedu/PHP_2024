<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Gateway\ReportGenerator\ReportGeneratorRequest;
use App\Application\Gateway\ReportGenerator\ReportGeneratorResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;

readonly class ReportGenerator implements \App\Application\Gateway\ReportGenerator\ReportGenerator
{

    public function __construct(
        private Environment           $twig,
        private ParameterBagInterface $env
    )
    {
    }

    public function generate(ReportGeneratorRequest $request): ReportGeneratorResponse
    {
        $html = $this->twig->render('report.html.twig', [
            'news' => $request->getNews(),
        ]);

        // Хотелось бы вынести всё что ниже, но куда будет лучше? В отдельный сервис на этом же слое?
        $reportDir = $this->env->get('kernel.project_dir') . '/public/reports';
        $reportFileName = sprintf('report_%s.html', uniqid());
        $filePath = $reportDir . '/' . $reportFileName;

        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0775, true);
        }

        file_put_contents($filePath, $html);

        $baseUrl = $this->env->get('router.request_context.scheme') . '://' . $_SERVER['HTTP_HOST'];
        $publicFilePath = $baseUrl . '/reports/' . $reportFileName;

        return new ReportGeneratorResponse($publicFilePath);
    }
}