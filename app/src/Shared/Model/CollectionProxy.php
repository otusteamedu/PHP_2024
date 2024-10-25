<?php

declare(strict_types=1);

namespace App\Shared\Model;

use Closure;

final class CollectionProxy extends Collection
{
    private bool $isLoaded = false;

    public function __construct(
        private readonly Closure $getItemsCallback,
    ) {
        parent::__construct();
    }

    public function all(): array
    {
        if (false === $this->isLoaded) {
            $this->items = call_user_func($this->getItemsCallback);
            $this->isLoaded = true;
        }

        return parent::all();
    }
}
