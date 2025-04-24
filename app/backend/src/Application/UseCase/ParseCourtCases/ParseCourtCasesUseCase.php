<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Symfony\Component\DomCrawler\Crawler;
use Facebook\WebDriver\Exception\TimeoutException;

class ParseCourtCasesUseCase
{
    public function __invoke(string $url): array
    {
        $host = 'http://otus-selenium-chrome:4444/wd/hub'; // обращение к selenium в сети docker
        $options = new ChromeOptions();
        $options->addArguments([
            '--headless=new',
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--disable-gpu',
            '--disable-software-rasterizer',
            '--remote-debugging-port=9222'
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $capabilities->setCapability('acceptInsecureCerts', true);

        $maxRetries = 3;
        $attempt = 0;
        $driver = null;
        $html = '';
        $title = '';

        while ($attempt < $maxRetries) {
            try {
                $attempt++;
                error_log("Попытка №$attempt открыть: $url");

                $driver = RemoteWebDriver::create(
                    $host,
                    $capabilities,
                    5000,     // таймаут соединения (мс)
                    180000    // таймаут ожидания ответа (мс)
                );

                $driver->manage()->timeouts()->implicitlyWait(10); // Ожидание до 10 секунд
                $driver->manage()->timeouts()->pageLoadTimeout(60); // Ожидание загрузки страницы до 30 секунд

                $driver->get($url);
                $title = $driver->getTitle();
                $html = $driver->getPageSource();
                break;
            } catch (TimeoutException $e) {
                error_log("⏱ Таймаут при загрузке страницы: " . $e->getMessage());

                if (isset($driver)) {
                    $driver->quit();
                    $driver = null;
                }

                if ($attempt >= $maxRetries) {
                    return [
                        'status' => 'error',
                        'errorType' => 'Время ожидания истекло',
                    ];
                }

                sleep(1);
            } catch (\Throwable $e) {
                // Логируем любые другие ошибки
                error_log('❌ Неизвестная ошибка driver в ParseCourtCasesUseCase: ' . $e->getMessage());
                return [
                    'status' => 'error',
                    'errorType' => 'Неизвестная ошибка',
                ];
            } finally {
                if (isset($driver)) {
                    $driver->quit();
                }
            }
        }

        $html = preg_replace('/<meta.*charset=windows-1251.*>/i', '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">', $html);
        $crawler = new Crawler($html);

        // Проверка на пустую стрницу
        $wrongRequestFormat = $crawler->filterXPath("//*[contains(., 'НЕВЕРНЫЙ ФОРМАТ ЗАПРОСА')]");

        if ($wrongRequestFormat->count() > 0) {
            return [
                'status' => 'error',
                "errorType" => "Обновить ссылку"
            ];
        }

        // Проверка на недоступность сайта
        $siteTemporarilyUnavailable = $crawler->filterXPath('//*[contains(., "сайт временно недоступен")]');

        if ($siteTemporarilyUnavailable->count() > 0) {
            return [
                'status' => 'error',
                "errorType" => "Сайт недоступен"
            ];
        }

        // УИД
        $uid = $this->safeText($crawler->filterXPath('//td[b[contains(., "Уникальный идентификатор дела")]]/following-sibling::td/a')->first());

        // Номер дела
        $caseNumber = $this->safeText($crawler->filterXPath('//div[@class="casenumber"]'));
        $caseNumber = str_replace("ДЕЛО №", "", $caseNumber ?? '');
        // Дата регистрации дела
        $registerDate = $this->safeText($crawler->filterXPath('//td[b[contains(., "Дата поступления")]]/following-sibling::td')->first());

        // ФИО судьи
        $judgeFio = $this->safeText($crawler->filterXPath('//td[b[contains(., "Судья")]]/following-sibling::td')->first());

        // Движение дела
        $table = $crawler->filterXPath('//tr[td[b[contains(., "Наименование события")]]]/ancestor::table');
        // Находим все строки событий, игнорируя заголовок
        $events = $table->filter('tr')->slice(2)->each(function (Crawler $node) {
            // Пропускаем первую строку (заголовок таблицы)
            if ($node->filter('td')->count() > 0) {
                return [
                    'title' => $this->safeNodeText($node, 0),
                    'resultDate' => $this->safeNodeText($node, 1),
                    'resultTime' => $this->safeNodeText($node, 2),
                    'location' => $this->safeNodeText($node, 3),
                    'result' => $this->safeNodeText($node, 4),
                    'basis' => $this->safeNodeText($node, 5),
                    'notes' => $this->safeNodeText($node, 6),
                    'postingDate' => $this->safeNodeText($node, 7),
                ];
            }
            return null;
        });

        // Фильтруем пустые элементы (если они есть)
        $events = array_filter($events);

        // Стороны по делу
        $partiesTable = $crawler->filterXPath('//tr[td[b[contains(text(), "Вид лица, участвующего в деле")]]]/ancestor::table');
        // Находим все строки событий, игнорируя заголовок
        $parties = $partiesTable->filter('tr')->slice(2)->each(function (Crawler $node) {
            // Пропускаем первую строку (заголовок таблицы)
            if ($node->filter('td')->count() > 0) {
                return [
                    'party_type' => $this->safeNodeText($node, 0),
                    'patry_name' => $this->safeNodeText($node, 1),
                ];
            }
            return null;
        });

        // Фильтруем пустые элементы (если они есть)
        $parties = array_filter($parties);

        // Вывод данных
        return [
            'status' => 'success',
            "errorType" => '',
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

    private function safeText(Crawler $crawler): ?string
    {
        return $crawler->count() > 0 ? trim($crawler->text()) : null;
    }

    private function safeNodeText(Crawler $node, int $index): ?string
    {
        $td = $node->filter('td');
        return $td->count() > $index ? trim($td->eq($index)->text()) : null;
    }
}
