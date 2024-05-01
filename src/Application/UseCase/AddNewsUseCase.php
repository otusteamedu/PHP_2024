<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\FailedToLoadHtmlContent;
use App\Application\Exception\PageTitleNotFoundException;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Interface\NewsRepositoryInterface;
use DOMDocument;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class AddNewsUseCase
{
    private DOMDocument $htmlParser;

    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        $this->htmlParser = new DOMDocument();
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = $request->url;

        $html = file_get_contents($url);

        if ($html === false) {
            throw new FailedToLoadHtmlContent();
        }
        // Settings
        $host = 'http://selenium-hub:4444/wd/hub';  // Адрес Selenium Grid
        $windowSize = '1280.1224';
        $userAgent = 'Chrome test';
        $seleniumConnectionTimeout = 10*1000; // 10 seconds
        $seleniumCompletionTimeout = 60*1000; // 60 seconds

        // Chromium args
        $chromiumArgs = [
            '--window-size=' . $windowSize,
            '--user-agent=' . $userAgent,
        ];

        //Chrome setting uo options
        $chromeOptions = new ChromeOptions();
        $chromeOptions->setExperimentalOption('w3c', false);
        $chromeOptions->addArguments($chromiumArgs);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);

        $driver = RemoteWebDriver::create($host, $capabilities, $seleniumConnectionTimeout, $seleniumCompletionTimeout);
        $driver->get($url);
        $title = $driver->getTitle();

        if (is_null($title)) {
            throw new PageTitleNotFoundException();
        }

        $driver->quit();

        $news = News::createNew($title, $url);

        $this->newsRepository->addAndSaveNews($news);

        return new AddNewsResponse($news->getId());
    }
}
