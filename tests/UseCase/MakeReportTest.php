<?php

namespace App\Tests\UseCase;

use App\Application\UseCase\AddNewsUseCase;
use App\Application\UseCase\GetAllNewsUseCase;
use App\Application\UseCase\MakeReportUseCase;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Request\MakeConsolidatedReportRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Application\UseCase\Response\ConsolidatedReportResponse;
use App\Application\UseCase\Response\NewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Http\GetAllNewsController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MakeReportTest extends KernelTestCase
{
    public function testMakeReport(): void
    {
        self::bootKernel(["environment" => 'test']);
        $container = self::getContainer();

        $request = new AddNewsRequest('https://reintech.io/blog/use-php-file-get-contents-reading-files-urls');
        $addUseCase = $container->get(AddNewsUseCase::class);;
        $res = ($addUseCase)($request);

        $request = new AddNewsRequest('https://tomasvotruba.com/blog/how-to-create-symfony-kernel-for-tests-with-different-configs');
        $addUseCase = $container->get(AddNewsUseCase::class);;
        ($addUseCase)($request);

        $makeReportRequest = new MakeConsolidatedReportRequest([1,2]);
        $makeReportUseCase = $container->get(MakeReportUseCase::class);
        $makeReportResponse = ($makeReportUseCase)($makeReportRequest);
        $this->assertInstanceOf(ConsolidatedReportResponse::class, $makeReportResponse);
        $this->assertNotEmpty($makeReportResponse->fileUriPath);
    }
}
