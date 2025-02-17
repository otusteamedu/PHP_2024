<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews;

use PavelMiasnov\MediaMonitoring\Application\Gateway\WebGatewayInterface;
use PavelMiasnov\MediaMonitoring\Application\Gateway\WebGatewayRequest;
use PavelMiasnov\MediaMonitoring\Domain\Entity\News;
use PavelMiasnov\MediaMonitoring\Domain\Factory\NewsFactoryInterface;
use PavelMiasnov\MediaMonitoring\Domain\Repository\NewsRepositoryInterface;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Title;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Url;

class CreateNewsUseCase
{
    private WebGatewayInterface $webGateway;
    private NewsFactoryInterface $newsFactory;
    private NewsRepositoryInterface $newsRepository;

    public function __construct(
        WebGatewayInterface $webGateway,
        NewsFactoryInterface $newsFactory,
        NewsRepositoryInterface $newsRepository
    ) {
        $this->webGateway = $webGateway;
        $this->newsFactory = $newsFactory;
        $this->newsRepository = $newsRepository;
    }

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $webGatewayRequest = new WebGatewayRequest($request->url);
        $webGatewayResponse = $this->webGateway->sendRequest($webGatewayRequest);

        $htmlContent = $webGatewayResponse->getContent();
        $title = $this->extractTitleFromHtml($htmlContent);

        $news = $this->newsFactory->create($request->url, $title);
        $this->newsRepository->save($news);

        return new CreateNewsResponse($news->getId());
    }

    private function extractTitleFromHtml(string $html): string
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();

        $titleNode = $dom->getElementsByTagName('title')->item(0);
        return $titleNode ? trim($titleNode->nodeValue) : 'No Title';
    }
}
