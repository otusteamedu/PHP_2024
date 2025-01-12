<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw11;

class Movie
{
    public function __construct(
        private ?int $id,
        private ?string $name
    ) {
        //
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $id
     * @return void
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param $name
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}
