<?php

declare(strict_types=1);


namespace Main\Infrastructure;


interface BookParamsQueryBuilderInterface
{
    /**
     * @param string $title Название книги.
     * @return self
     */
    public function __construct(string $indexName);

    /**
     * @return self
     */
    public function build(): self;

    /**
     * @return array Массив параметров запроса.
     */
    public function getBodyParams(): array;

    /**
     * @return array Массив с индексом и телом запроса.
     */
    public function getQuery(): array;
}