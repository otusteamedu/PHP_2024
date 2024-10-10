<?php

declare(strict_types=1);

namespace Otus\App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Otus\App\Elastic\Entry;
use Otus\App\Elastic\DataLoader;
use Otus\App\Elastic\Finder;
use Otus\App\Elastic\Output;
use Exception;

class App
{
    private Entry $elastic;

    public function __construct()
    {
        $this->elastic = new Entry();
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $status = $this->healthCheck();
        if (!$status) {
            throw new Exception('ERROR: Elastic is not reachable!');
        }

        switch ($_SERVER['argv'][1]) {
            case 'init':
                $this->init();
                break;
            case 'query':
                $this->query();
                break;
            default:
                throw new Exception('ERROR: No action specified. Use `init` or `query`');
        }
    }

    /**
     * @return bool
     */
    public function healthCheck(): bool
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

    /**
     * @return void
     */
    public function init(): void
    {
        (new DataLoader($this->elastic))->loadFromFile();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function query(): void
    {
        $result = (new Finder($this->elastic))->findAll();
        (new Output())->renderTable($result);
    }
}
