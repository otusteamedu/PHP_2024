<?php

namespace VladimirGrinko\Seeker\ElasticSearch;

class App
{

    public function run(): void
    {
        $this->showStartMenu();

        $startCommand = (int)readline();
        $this->handlerCmd($startCommand);
    }

    private function handlerCmd(int $command): void
    {
        switch ($command) {
            case 1:
                $this->skuSearch();
                break;
            case 2:
                $this->paramsSearch();
                break;
            case 0:
                echo 'Bye' . PHP_EOL;
                break;
            default:
                echo 'Неизвестная команда' . PHP_EOL . PHP_EOL;
                $app = new self();
                $app->run();
                break;
        }
    }

    private function skuSearch(): void
    {
        $sku = readline('Введите SKU: ');
        if (empty(trim($sku))) {
            echo 'Пустой запрос';
        } else {
            try {
                $connectES = new Connect();
                $search = new Search($connectES->getClient());
                $res = $search->skuSearch($sku);
                $format = new Format($res);
                echo $format->formatOnce();
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }

    private function paramsSearch(): void
    {
        $params = [];
        $builder = new Build();
        if (!empty($name = readline('Название книги (Enter, чтобы пропустить): '))) {
            $builder->setName($name);
        }

        if (!empty($category = readline('Жанр (Enter, чтобы пропустить): '))) {
            $builder->setCategory($category);
        }

        if (!empty($priceBot = readline('Цена от (Enter, чтобы пропустить): '))) {
            $builder->setPriceBot($priceBot);
        }

        if (!empty($priceTop = readline('Цена до (Enter, чтобы пропустить): '))) {
            $builder->setPriceTop($priceTop);
        }

        if (!empty($stock = readline('Наличие в магазинах (Например, Мира-10) (Enter, чтобы пропустить): '))) {
            $arrStock = explode('-', $stock);
            $builder->setShop($arrStock[0]);
            $builder->setStock($arrStock[1]);
        }

        $from = 1;

        try {
            while ($from > 0) {
                $page = $this->getPage($builder, $from);
                echo $page['content'];
                if ($page['pages'] > 1) {
                    do {
                        $from = readline('Введите страницу от 1 до ' . $page['pages'] . ' или 0 для выхода из программы: ');
                    } while ($from < 0 || $from > $page['pages']);
                } else {
                    break;
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    private function getPage(Build $build, $from = 1): array
    {
        $connectES = new Connect();
        $search = new Search($connectES->getClient());
        $res = $search->paramsSearch($build, $from);
        $format = new Format($res);
        return [
            'content' => $format->formatList($res),
            'pages' => round($res['hits']['total']['value'] / 10)
        ];
    }

    private function showStartMenu(): void
    {
        echo 'Введите команду:' . PHP_EOL .
            '1 - точный поиск по SKU' . PHP_EOL .
            '2 - гибкий поиск по параметрам' . PHP_EOL .
            '0 - выйти' . PHP_EOL;
    }
}
