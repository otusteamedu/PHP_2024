<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Exception\FailedToLoadHtmlContent;
use App\Application\Service\ArticleParserInterface;
use App\Application\Service\DTO\ParsedArticleDto;
use App\Application\Service\Exception\HtmlParserException;
use App\Domain\ValueObject\Url;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class HtmlParser implements ArticleParserInterface
{
    private int $connectionTimeout;
    private int $completionTimeout;
    private DesiredCapabilities $desiredCapabilities;
    public function __construct(
        private readonly string $seleniumGridUrl,
    ) {
        // Settings
//        $host = 'http://selenium-hub:4444/wd/hub';  // Адрес Selenium Grid
        $this->connectionTimeout = 10 * 1000; // 10 seconds
        $this->completionTimeout = 60 * 1000; // 60 seconds

        //Chrome setting uo options
        $chromeOptions = (new ChromeOptions())
            ->setExperimentalOption('w3c', false)
            // Chromium args
            ->addArguments(
                [
                    '--window-size=' . '1280.1224', // window size
                    '--user-agent=' . 'Chrome test', // user agent
                ]
            );

        $this->desiredCapabilities = DesiredCapabilities::chrome()
            ->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);
    }

    public function parseArticle(Url $url): ParsedArticleDto
    {
        $html = file_get_contents($url->getValue());

        if ($html === false) {
            throw new HtmlParserException('Не удалось прочитать содержимое страницы');
        }

        $driver = $this->getDriver();
        $driver->get($url);
        $title = $driver->getTitle();
        $driver->quit();

        return new ParsedArticleDto($title);
    }

    private function getDriver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(
            $this->seleniumGridUrl,
            $this->desiredCapabilities,
            $this->connectionTimeout,
            $this->completionTimeout,
        );
    }
}
