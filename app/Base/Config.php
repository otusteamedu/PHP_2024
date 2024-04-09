<?php

declare(strict_types=1);

namespace App\Base;

use Exception;

class Config
{

    protected static Config|null $instance = null;

    private array $settings = [];

    /**
     * @throws Exception
     */
    protected function __construct()
    {
    }

    public function load(array $settings): void
    {
        $this->settings = $settings;
    }

    public function getConfig(string $path)
    {
        $path = explode('.', $path);

        $pathList = new \SplDoublyLinkedList();

        foreach ($path as $prop) {
            $pathList->push($prop);
        }

        $pathList->rewind();

        $configVal = $this->settings;

        while ($pathList->valid()) {
            $configVal = $configVal[$pathList->current()];
            $pathList->next();
        }

        return $configVal;

    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }
}
