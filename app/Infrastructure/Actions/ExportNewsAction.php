<?php

namespace App\Infrastructure\Actions;

use App\Application\Actions\ExportNewsActionInterface;
use App\Application\Responses\ExportNewsResponse;
use Illuminate\Support\Facades\Storage;

class ExportNewsAction implements ExportNewsActionInterface
{
    public function __invoke(iterable $newsEntities): ExportNewsResponse
    {
        $html = $this->generateHtml($newsEntities);

        $fileName = 'news_report_' . time() . '.html';
        $filePath = 'exports/' . $fileName;

        Storage::disk('public')->put($filePath, $html);

        $url = Storage::disk('public')->url($filePath);

        return new ExportNewsResponse($url);
    }

    protected function generateHtml(iterable $newsEntities): string
    {
        $html = '<ul>';

        foreach ($newsEntities as $news) {
            $html .= sprintf(
                '<li><a href="%s">%s</a></li>',
                htmlspecialchars($news->url, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($news->title, ENT_QUOTES, 'UTF-8')
            );
        }

        $html .= '</ul>';

        return $html;
    }
}
