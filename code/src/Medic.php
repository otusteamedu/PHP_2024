<?php

namespace Naimushina\ElasticSearch;

class Medic
{
    public function __construct(
        private ?int $id,
        private string $fullName,
        private string $position_name,
        private int $cabinet_number
    )
    {

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getPositionName(): string
    {
        return $this->position_name;
    }

    /**
     * @param string $position_name
     */
    public function setPositionName(string $position_name): void
    {
        $this->position_name = $position_name;
    }

    /**
     * @return int
     */
    public function getCabinetNumber(): int
    {
        return $this->cabinet_number;
    }

    /**
     * @param int $cabinet_number
     */
    public function setCabinetNumber(int $cabinet_number): void
    {
        $this->cabinet_number = $cabinet_number;
    }

}