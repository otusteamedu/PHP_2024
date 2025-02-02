<?php

namespace KRudenko\Otus\Service;

use Exception;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class SpiderService
{
    private const BASE_URL = 'https://www.labirint.ru/books/';
    private const DELAY = [3, 10];
    private const START_PAGE = 1;
    private const MAX_PAGES = 17;

    private HttpBrowser $browser;
    private array $data = [];
    private string $outputFile;
    private OutputInterface $output;

    public function __construct()
    {
        $this->browser = new HttpBrowser(HttpClient::create([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept-Language' => 'ru-RU,ru;q=0.9',
            ],
            'max_redirects' => 5,
            'timeout' => 10,
        ]));

        $this->outputFile = dirname(__DIR__, 2).'/files/books.json';
    }

    public function run(OutputInterface $output, ?string $path): void
    {
        $this->output = $output;
        try {
            $page = self::START_PAGE;
            do {
                $url = $this->buildPageUrl($path, $page);

                $this->output->writeln('Парс страницы ' . $page);

                $crawler = $this->browser->request('GET', $url);
                $this->processPage($crawler);
                $page++;
                $this->randomDelay();
            } while ($page <= self::MAX_PAGES && $this->hasNextPage($crawler));
        } finally {
            $this->saveData(true);
        }
    }

    private function buildPageUrl(?string $path, int $page): string
    {
        return ($path ?? self::BASE_URL) . "?page=$page";
    }

    private function processPage(Crawler $crawler): void
    {
        $crawler->filter('#catalog .products-row .product-cover')->each(function (Crawler $node) {
            $this->processBook($node);
        });
    }

    private function processBook(Crawler $node): void
    {
        try {
            $url = $node->filter('.product-title-link')->link()->getUri();

            $this->output->writeln('Парс книги ' . $url);

            $crawler = $this->browser->request('GET', $url);

            $id = $crawler->filter('meta[itemprop=isbn]')->attr('content');
            if (str_contains($id, ',')) {
                $id = explode(',', $id)[0];
            }
            $title = $crawler->filter('h1[itemprop=name]')->text();
            $description = $crawler->filter('#annotation h2')->closest('div')->nextAll()->first()->filter('div div div')->text();
            $price = $this->extractPrice($crawler);
            $reviews_count = $this->extractReviewsCount($crawler);
            $rating = $this->extractRating($crawler);
            $url = $crawler->filter('meta[itemprop=url]')->attr('content');

            $this->data[] = ['create' => ['_index' => $_ENV['ELASTIC_INDEX'], '_id' => $id]];
            $this->data[] = [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'reviews_count' => $reviews_count,
                'rating' => $rating,
                'url' => $url,
            ];

            $this->saveData();
        } catch (Exception $e) {
            $this->output->writeln('Error parsing book: ' . $e->getMessage() . ' Node html: ' . $node->html());
        }
    }

    private function extractPrice(Crawler $crawler): ?float
    {
        try {
            return (float)preg_replace('/[^0-9.]/', '',
                $crawler->filter('meta[itemprop=price]')->attr('content')
            );
        } catch (Exception) {
            return 0;
        }
    }

    private function extractReviewsCount(Crawler $crawler): int
    {
        try {
            return (int)preg_replace('/[^0-9]/', '',
                $crawler->filter('meta[itemprop=reviewCount]')->attr('content')
            );
        } catch (Exception) {
            return 0;
        }
    }

    private function extractRating(Crawler $crawler): ?float
    {
        try {
            return (float)preg_replace('/[^0-9.]/', '',
                $crawler->filter('meta[itemprop=ratingValue]')->attr('content')
            );
        } catch (Exception) {
            return null;
        }
    }

    private function hasNextPage(Crawler $crawler): bool
    {
        return $crawler->filter('a.pagination-next__text')->count() > 0;
    }

    private function saveData(bool $force = false): void
    {
        if ($force || (count($this->data) / 2) % 5 === 0) {
            try {
                $newEntry = json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                $newEntry = substr($newEntry, 1, -1);

                $handle = fopen($this->outputFile, 'c+');

                if (flock($handle, LOCK_EX)) {
                    fseek($handle, -1, SEEK_END);
                    $lastChar = fread($handle, 1);

                    if ($lastChar === ']') {
                        fseek($handle, -1, SEEK_END);
                        fwrite($handle, ',' . $newEntry . ']');
                    } else {
                        ftruncate($handle, 0);
                        fwrite($handle, '[' . $newEntry . ']');
                    }

                    flock($handle, LOCK_UN);
                }
                fclose($handle);

                $this->data = [];
            } catch (Exception $e) {
                $this->output->writeln('Error save data: ' . $e->getMessage());
            }
        }
    }

    private function randomDelay(): void
    {
        sleep(random_int(...self::DELAY));
    }
}
