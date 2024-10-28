<?php

namespace App\Application\UseCase\News\CreateHtml;

use App\Domain\Interface\Repository\FileRepositoryInterface;
use App\Domain\Interface\UseCase\CreateHtmlUseCaseInterface;
use Twig\Environment;

class CreateHtmlUseCase implements CreateHtmlUseCaseInterface
{
    public function __construct(
        private readonly FileRepositoryInterface $fileRepository,
        private readonly Environment $environment,
    ) {
    }

    private const TITLE = 'Новости по запросу';

    /**
     * @param CreateHtmlUseCaseRequest[] $request
     * @return CreateHtmlUseCaseResponse
     */
    public function __invoke(array $request): CreateHtmlUseCaseResponse
    {
        return new CreateHtmlUseCaseResponse($this->saveHtml($request));
    }

    private function saveHtml(array $request): string
    {
        $fileName = 'news-list.html';
        $href = 'http://' . $_ENV['APP_URL'] . ":" . $_ENV['APP_PORT'] . "/" . $fileName;
        $result = $this->fileRepository->store($fileName, $this->getTemplate($request));

        return $result ? $href : 'error';
    }

    private function getTemplate(array $request): string
    {
        return $this->environment->render(
            'news/news-list.html.twig',
            [
                'title' => self::TITLE,
                'newsPropertiesArray' => $this->getNewsPropertiesArray($request),
            ]
        );
    }

    /**
     * @param CreateHtmlUseCaseRequest[] $requestArray
     * @return array
     */
    private function getNewsPropertiesArray(array $requestArray): array
    {
        $newsPropertiesArray = [];
        foreach ($requestArray as $request) {
            $href = $request->urlValue;
            $title = $request->title;
            $newsPropertiesArray[] = ['href' =>  $href, 'title' => $title];
        }

        return $newsPropertiesArray;
    }
}
