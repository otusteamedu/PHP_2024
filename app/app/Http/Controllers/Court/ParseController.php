<?php

namespace App\Http\Controllers\Court;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class ParseController extends BaseController
{
    public function __invoke()
    {
        $url = "https://avtozavodsky--nnov.sudrf.ru/modules.php?name=sud_delo&srv_num=2&name_op=case&case_id=255166987&case_uid=2e2fe5a9-6781-41da-9abc-12ff18ab89e2&delo_id=1540005";
        // $html = file_get_contents($url);
        // $html = mb_convert_encoding($html, 'UTF-8', 'Windows-1251');
        // $html = preg_replace('/<meta.*charset=windows-1251.*>/i', '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">', $html);
        // dump($html);
        //
        $host = 'http://selenium:4444/wd/hub'; // обращение к selenium в сети docker
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

        try {
            $driver = RemoteWebDriver::create($host, $capabilities);

            Log::info('Начинаем парсинг');

            $driver->manage()->timeouts()->implicitlyWait(10); // Ожидание до 10 секунд
            $driver->manage()->timeouts()->pageLoadTimeout(120000); // Ожидание загрузки страницы до 30 секунд
            $driver->get($url);
            sleep(5);
            Log::info('Загрузили страницу');
            $title = $driver->getTitle();
            $html = $driver->getPageSource();
            Log::info('Получили HTML');
        } catch (\Throwable $e) {
            Log::error('Ошибка при парсинге: ' . $e->getMessage());
            throw $e;
        } finally {
            if (isset($driver)) {
                $driver->quit();
                Log::info('Закрыли драйвер');
            }
        }

        $html = preg_replace('/<meta.*charset=windows-1251.*>/i', '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">', $html);

        $crawler = new Crawler($html);
        Log::info('Создали Crawler');

        // УИД
        $uid = $crawler->filterXPath('//td[b[contains(text(), "Уникальный идентификатор дела")]]/following-sibling::td/a')->first()->text();

        // Номер дела
        $caseNumber = $crawler->filterXPath('//div[@class="casenumber"]')->text();

        // Дата регистрации дела
        $registerDate = $crawler->filterXPath('//td[b[contains(text(), "Дата поступления")]]/following-sibling::td')->first()->text();

        // ФИО судьи
        $judgeFio = $crawler->filterXPath('//td[b[contains(text(), "Судья")]]/following-sibling::td')->first()->text();

        // Движение дела
        $table = $crawler->filterXPath('//tr[td[b[contains(text(), "Наименование события")]]]/ancestor::table');
        // Находим все строки событий, игнорируя заголовок
        $events = $table->filter('tr')->slice(2)->each(function (Crawler $node) {
            // Пропускаем первую строку (заголовок таблицы)
            if ($node->filter('td')->count() > 0) {
                return [
                    'event_name' => $node->filter('td')->eq(0)->text(),
                    'date' => $node->filter('td')->eq(1)->text(),
                    'time' => $node->filter('td')->eq(2)->text(),
                    'location' => $node->filter('td')->eq(3)->text(),
                    'result' => $node->filter('td')->eq(4)->text(),
                    'basis_for_result' => $node->filter('td')->eq(5)->text(),
                    'notes' => $node->filter('td')->eq(6)->text(),
                    'posting_date' => $node->filter('td')->eq(7)->text(),
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
                    'party_type' => $node->filter('td')->eq(0)->text(),
                    'patry_name' => $node->filter('td')->eq(1)->text(),
                ];
            }
            return null;
        });

        // Фильтруем пустые элементы (если они есть)
        $parties = array_filter($parties);

        // Вывод данных
        dump([
            'Суд' => $title,
            'УИД' => $uid,
            'Номер дела' => $caseNumber,
            'Дата регистрации' => $registerDate,
            'ФИО судьи' => $judgeFio,
            'События' => $events,
            'Стороны' => $parties,
        ]);
    }
}
