<?php

declare(strict_types=1);

namespace hw15;

class Creator
{
    public function __construct(
        private StorageInterface $storage
    ) {
    }

    /**
     * @return string
     */
    public function execute()
    {
        $method = $_SERVER["argv"][1] ?? '';
        $value = $_SERVER["argv"][2] ?? '';

        return $this->storage->exec($method, $value);
    }
}
