<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases;

use Symfony\Component\DomCrawler\Crawler;

class ParseCourtCaseFromHtmlUseCase
{
    public function __invoke(string $html, string $title): array
    {
        $html = preg_replace(
            '/<meta.*charset=windows-1251.*>/i',
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',
            $html
        );
        $crawler = new Crawler($html);

        if ($crawler->filterXPath("//*[contains(., 'НЕВЕРНЫЙ ФОРМАТ ЗАПРОСА')]")->count() > 0) {
            return ['status' => 'error', 'errorType' => 'Обновить ссылку'];
        }

        if ($crawler->filterXPath('//*[contains(., "сайт временно недоступен")]')->count() > 0) {
            return ['status' => 'error', 'errorType' => 'Сайт недоступен'];
        }

        $safeText = fn($crawler) => $crawler->count() > 0 ? trim($crawler->text()) : null;

        $uid = $safeText($crawler->filterXPath('//td[b[contains(., "Уникальный идентификатор дела")]]/following-sibling::td/a')->first());
        $caseNumber = $safeText($crawler->filterXPath('//div[@class="casenumber"]'));
        $caseNumber = str_replace("ДЕЛО №", "", $caseNumber ?? '');
        $registerDate = $safeText($crawler->filterXPath('//td[b[contains(., "Дата поступления")]]/following-sibling::td')->first());
        $judgeFio = $safeText($crawler->filterXPath('//td[b[contains(., "Судья")]]/following-sibling::td')->first());

        $nodeText = function (Crawler $node, int $index): ?string {
            $td = $node->filter('td');
            return $td->count() > $index ? trim($td->eq($index)->text()) : null;
        };

        $events = [];
        $table = $crawler->filterXPath('//tr[td[b[contains(., "Наименование события")]]]/ancestor::table');
        if ($table->count()) {
            $events = $table->filter('tr')->slice(2)->each(
                fn(Crawler $node) =>
                $node->filter('td')->count() > 0 ? [
                    'title' => $nodeText($node, 0),
                    'resultDate' => $nodeText($node, 1),
                    'resultTime' => $nodeText($node, 2),
                    'location' => $nodeText($node, 3),
                    'result' => $nodeText($node, 4),
                    'basis' => $nodeText($node, 5),
                    'notes' => $nodeText($node, 6),
                    'postingDate' => $nodeText($node, 7),
                ] : null
            );
            $events = array_filter($events);
        }

        $parties = [];
        $partiesTable = $crawler->filterXPath('//tr[td[b[contains(text(), "Вид лица, участвующего в деле")]]]/ancestor::table');
        if ($partiesTable->count()) {
            $parties = $partiesTable->filter('tr')->slice(2)->each(
                fn(Crawler $node) =>
                $node->filter('td')->count() > 0 ? [
                    'party_type' => $nodeText($node, 0),
                    'patry_name' => $nodeText($node, 1),
                ] : null
            );
            $parties = array_filter($parties);
        }

        return [
            'status' => 'success',
            'errorType' => '',
            'data' => [
                'courtTitle' => $title,
                'uid' => $uid,
                'caseNumber' => $caseNumber,
                'registerDate' => $registerDate,
                'judgeFio' => $judgeFio,
                'events' => $events,
                'parties' => $parties
            ]
        ];
    }
}
