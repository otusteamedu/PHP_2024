<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

use Exception;

class ElasticConfig
{
    public static function load()
    {
        $password = getenv('ELASTIC_PASSWORD');
        $host = getenv('ELASTIC_HOST');
        $port = getenv('ELASTIC_PORT');
        $pathToFileBooks = getenv('PATH_TO_FILE_BOOKS');
        $pathToFileSettings = getenv('PATH_TO_FILE_SETTINGS');
        $indexName = getenv('INDEX_NAME');

        if (!$password) {
            throw new Exception("No isset ELASTIC_PASSWORD in .env");
        }

        if (!$host) {
            throw new Exception("No isset ELASTIC_HOST in .env");
        }

        if (!$port) {
            throw new Exception("No isset ELASTIC_PORT in .env");
        }

        if (!$indexName) {
            throw new Exception("No isset INDEX_NAME in .env");
        }

        if (!$pathToFileBooks) {
            throw new Exception("No isset PATH_TO_FILE_BOOKS in .env");
        }

        if (!$pathToFileSettings) {
            throw new Exception("No isset PATH_TO_FILE_SETTINGS in .env");
        }

        return [
            'password' => $password,
            'host'  => $host,
            'port'  => $port,
            'pathToFileBooks' => $pathToFileBooks,
            'pathToFileSettings' => $pathToFileSettings,
            'indexName' => $indexName
        ];
    }
}
