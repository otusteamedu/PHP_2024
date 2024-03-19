<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use RailMukhametshin\Hw\Commands\AbstractCommand;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;
use RailMukhametshin\Hw\Repositories\Elastic\OtusShopRepository;

class OtusShopImportCommand extends AbstractCommand
{
    private const FILES_DIR = __DIR__ . "/../../public/files";

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws Exception
     */
    public function execute(): void
    {
        if (!isset($this->argv[0])) {
            throw new Exception('File name is required');
        }

        $pathToFile = sprintf('%s/%s', self::FILES_DIR, $this->argv[0]);

        if (!is_file($pathToFile)) {
            throw new Exception('File is not exist');
        }

        $data = [];

        $stream = fopen($pathToFile, 'r');

        do {
            $line = fgets($stream);

            if ($line !== false) {
                $data[] = json_decode($line, true);
            }
        } while ($line !== false);

        fclose($stream);

        $otusShopRepository = new OtusShopRepository($this->elasticClient);
        $otusShopRepository->bulk($data);

        $this->formatter->output('Success import');
    }
}
