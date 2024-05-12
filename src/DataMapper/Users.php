<?php

declare(strict_types=1);

namespace AShutov\Hw17\DataMapper;

class Users
{
    private int $id;
    private string $name;
    private int $age;
    private string $job;
    private int $departmentId;

    public function __construct(
        int $id,
        string $name,
        int $age,
        string $job,
        int $departmentId,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->job = $job;
        $this->departmentId = $departmentId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function setDepartmentId(?int $departmentId): self
    {
        $this->departmentId = $departmentId;

        return $this;
    }
}
