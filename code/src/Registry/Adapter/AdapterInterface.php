<?php
declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

interface AdapterInterface
{
    public function flush() : void;
}