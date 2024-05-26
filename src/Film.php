<?php

namespace Ahar\Hw13;

readonly class Film
{
    public function __construct(
       public int    $id,
       public string $name,
       public string $genre,
       public string $description,
    ) {
    }
}
