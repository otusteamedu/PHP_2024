<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\TimeoutException;

class GetCourtCaseHtmlUseCase
{
    public function __invoke(string $url): array
    {
        $host = 'http://otus-selenium-chrome:4444/wd/hub';
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

        while ($attempt < $maxRetries) {
            try {
                $attempt++;
                error_log("Попытка №$attempt открыть: $url");

                $driver = RemoteWebDriver::create($host, $capabilities, 5000, 180000);
                $driver->manage()->timeouts()->implicitlyWait(10);
                $driver->manage()->timeouts()->pageLoadTimeout(60);

                $driver->get($url);
                $title = $driver->getTitle();
                $html = $driver->getPageSource();

                return ['status' => 'success', 'html' => $html, 'title' => $title];
            } catch (TimeoutException $e) {
                error_log("⏱ Таймаут при загрузке страницы: " . $e->getMessage());
                if (isset($driver)) {
                    $driver->quit();
                    $driver = null;
                }
                if ($attempt >= $maxRetries) {
                    return ['status' => 'error', 'errorType' => 'Время ожидания истекло'];
                }
                sleep(1);
            } catch (\Throwable $e) {
                error_log('❌ Неизвестная ошибка driver в ParseCourtCasesUseCase: ' . $e->getMessage());
                return ['status' => 'error', 'errorType' => 'Неизвестная ошибка'];
            } finally {
                if (isset($driver)) {
                    $driver->quit();
                }
            }
        }

        return ['status' => 'error', 'errorType' => 'Не удалось получить HTML'];
    }
}
