<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

use Generator;

interface AdapterInterface
{
    /**
     * @return void
     */
    public function flush(): void;

    /**
     * @param string $key
     * @param mixed $value
     * @param integer $priority
     * @return boolean
     */
    public function add(string $key, mixed $value, $priority = 0): bool;

    /**
     * @param string $key
     * @return Generator
     */
    public function getByKey(string $key): Generator;
}
