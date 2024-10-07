<?php

namespace App\Infrastructure\Actions;

use App\Application\Actions\CreateNewsActionInterface;
use App\Application\Requests\CreateNewsRequest;
use App\Application\Responses\CreateNewsResponse;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

readonly class CreateNewsAction implements CreateNewsActionInterface
{
    public function __construct(
        private NewsFactoryInterface $newsFactory,
        private NewsRepositoryInterface $newsRepository
    ) {}

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $date = date('d-m-y');
        $title = $this->extractTextFromUrl($request->url, 'title');

        $newsEntity = $this->newsFactory->create($date, $request->url, $title);

        $this->newsRepository->save($newsEntity);

        return new CreateNewsResponse($newsEntity->getId());
    }

    private function extractTextFromUrl(string $url, string $tag, ?string $default = null): ?string
    {
        try {
            $html = file_get_contents($url);
            $crawler = new Crawler($html);
            $node = $crawler->filter($tag);

            if ($node->count() === 0) {
                return $default;
            }

            return $node->text();
        } catch (Exception $e) {
            throw new Exception("Could not parse $url. Error: ".$e->getMessage());
        }
    }
}
