<?php

declare(strict_types=1);

namespace  Otus\App;

use Otus\App\Elastic\Entry;
use Otus\App\Elastic\Data;
use Otus\App\Elastic\Query;
use Otus\App\Elastic\Output;
use Exception;

class App
{
    private Entry $elastic;

    public function __construct()
    {
        $this->elastic = new Entry();
    }

    public function run()
    {
        $status = $this->healthChaeck();
        if (!$status) {
            throw new Exception('ERROR: Elastic is not reachable!');
        }

        switch ($_SERVER['argv'][1]) {
            case 'init':
                return $this->init();
            case 'query':
                return $this->query();
            default:
                throw new Exception('ERROR: No action specified. Use `init` or `query`');
        }
    }

    public function healthChaeck()
    {
        try {
            $response = $this->elastic->client->cluster()->health();
            echo "Elastic Health: " . $response['status'] . PHP_EOL;
            return true;
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function init()
    {
        (new Data($this->elastic))->loadFromFile();
    }

    public function query()
    {
        $result = (new Query($this->elastic))->findAll();
        (new Output())->renderTable($result);
    }
}
