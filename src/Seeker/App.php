<?php

namespace VladimirGrinko\Seeker;

class App
{
    public function run(): void
    {
        $mode = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '';
        switch ($mode) {
            case 'es':
                $app = new ElasticSearch\App();
                $app->run();
                break;
            default:
                throw new \Exception('Не найдена поисковая сисетма - "' . $mode . '"' . PHP_EOL);
                break;
        }
    }
}