<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\GetPageTitleInterface;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class HtmlParser implements GetPageTitleInterface
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

    public function getPageTitle(string $url): ?string
    {
        $driver = $this->getDriver();
        $driver->get($url);
        $title = $driver->getTitle();
        $driver->quit();

        return $title;
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
