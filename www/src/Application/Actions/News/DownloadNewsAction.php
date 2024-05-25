<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\Exporter\ExporterInterface;
use App\Domain\News\News;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

class DownloadNewsAction extends BaseNewsAction
{
    private StreamFactoryInterface $streamFactory;
    private ExporterInterface $exporter;


    public function __construct(
        LoggerInterface        $logger,
        EntityManager          $entityManager,
        ExporterInterface      $exporterFactory,
        StreamFactoryInterface $streamFactory
    )
    {
        parent::__construct($logger, $entityManager);
        $this->streamFactory = $streamFactory;
        $this->exporter = $exporterFactory;
    }

    protected function action(): Response
    {
        $fileExtension = (string)$this->resolveArg('extension');
        $exporter = $this->exporter::GetConcreteExporter($fileExtension);


        $newsId = (int)$this->resolveArg('id');
        $news = $this->entityManager->find(News::class, $newsId);

        $fileSource = $news->accept($exporter);

        $stream = $this->streamFactory->createStream($fileSource); // create a stream instance for the response body

        return $this->response->withHeader('Content-Type', 'application/force-download')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Content-Type', 'application/download')
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $news->getTitle() . '.' . $fileExtension . '"')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->withHeader('Pragma', 'public')
            ->withBody($stream); // all stream contents will be sent to the response
    }
}