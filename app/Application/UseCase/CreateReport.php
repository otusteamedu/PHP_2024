<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateReportRequest;
use App\Application\UseCase\Response\CreateReportResponse;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Exceptions\ReportFileCreateException;

final readonly class CreateReport
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    /**
     * @throws ReportFileCreateException
     */
    public function __invoke(CreateReportRequest $request): CreateReportResponse
    {
        $items = $this->getItems($request->ids);
        $template = $this->generateTemplate($items);
        $fileName = time() . '.html';
        $filePath = $request->templatePath . $fileName;
        file_put_contents($filePath, $template) or throw new ReportFileCreateException('File not created');

        return new CreateReportResponse($fileName);
    }

    private function getItems(array $ids): false|array
    {
        return $this->repository->getByIds($ids);
    }

    protected function generateTemplate(array $items): string
    {
        $content = '<meta charset="UTF-8"><ul>';

        foreach ($items as $item) {
            $content .= "<a href='{$item['url']}'>{$item['title']}</a><br>";
        }

        $content .= '</ul>';

        return $content;
    }
}
