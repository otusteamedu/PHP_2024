<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

use Exception;

class ElasticInit extends Elastic
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        if (!$this->indexName) {
            throw new Exception("Empty indexName");
        }

        $this->deleteIndex();
        $this->createIndex();
        $res = $this->loadData();

        if ($res) {
            print_r("Load success" . PHP_EOL);
        } else {
            print_r("Load error" . PHP_EOL);
        }
    }

    private function loadSettings()
    {
        if (!$this->pathToFileSettings) {
            throw new Exception("Empty pathToFileSettings");
        }

        $FullPathToFileBooksSettings = __DIR__ . "/.." . $this->pathToFileSettings;

        if (!file_exists($FullPathToFileBooksSettings)) {
            throw new Exception("File not exist");
        }

        $data = file_get_contents($FullPathToFileBooksSettings, true);

        return $data;
    }

    private function loadData(): bool
    {
        if (!$this->pathToFileBooks) {
            throw new Exception("Empty pathToFileBooks");
        }

        $FullPathToFileBooks = __DIR__ . "/.." . $this->pathToFileBooks;

        if (!file_exists($FullPathToFileBooks)) {
            throw new Exception("File not exist");
        }

        $result = $this->client->bulk([
            'index' => $this->indexName,
            'body' => ['data-binary' => file_get_contents($FullPathToFileBooks)]
        ])->asBool();

        return $result;
    }

    private function deleteIndex()
    {
        $result = $this->client->indices()->exists([
            'index' => $this->indexName
        ])->asBool();

        if ($result) {
            $resultDelete = $this->client->indices()->delete([
                'index' => $this->indexName
            ]);
        }
    }

    private function createIndex()
    {
        $settings = $this->loadSettings();

        $result = $this->client->indices()->create([
            'index' => $this->indexName,
            'body' => $settings
        ]);
    }
}
