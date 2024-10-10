<?php

declare(strict_types=1);

namespace Otus\AppPDO;

class User
{
    private array $dirtyFields = [];

    public function __construct(private ?int    $id,
                                private ?string $name,
                                private ?string $last_name,
                                private ?string $phone,
                                private ?string $email)
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param $id
     * @return void
     */
    public function setId($id): void
    {
        $this->setField('id', $id);
    }

    /**
     * @param $name
     * @return void
     */
    public function setName($name): void
    {
        $this->setField('name', $name);
    }

    /**
     * @param $last_name
     * @return void
     */
    public function setLastName($last_name): void
    {
        $this->setField('lastName', $last_name);
    }

    /**
     * @param $phone
     * @return void
     */
    public function setPhone($phone): void
    {
        $this->setField('phone', $phone);
    }

    /**
     * @param $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->setField('email', $email);
    }

    /**
     * @param string $fieldName
     * @param $newValue
     * @return void
     */
    private function setField(string $fieldName, $newValue): void
    {
        if (property_exists($this, $fieldName)) {
            $currentValue = $this->$fieldName;

            if ($currentValue !== $newValue) {
                $this->$fieldName = $newValue;
                $this->dirtyFields[$fieldName] = $newValue;
            }
        }
    }

    /**
     * @return array
     */
    public function getDirtyFields(): array
    {
        return $this->dirtyFields;
    }

    /**
     * @return void
     */
    public function clearDirtyFields(): void
    {
        $this->dirtyFields = [];
    }
}
