<?php

declare(strict_types=1);

namespace Otus\AppPDO;

class User
{
    private $id;
    private $name;
    private $lastName;
    private $phone;
    private $email;
    private array $dirtyFields = [];

    public function __construct($id, $name, $lastName, $phone, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setId($id)
    {
        $this->setField('id', $id);
    }

    public function setName($name)
    {
        $this->setField('name', $name);
    }

    public function setLastName($lastName)
    {
        $this->setField('lastName', $lastName);
    }

    public function setPhone($phone)
    {
        $this->setField('phone', $phone);
    }

    public function setEmail($email)
    {
        $this->setField('email', $email);
    }

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

    public function getDirtyFields(): array
    {
        return $this->dirtyFields;
    }

    public function clearDirtyFields(): void
    {
        $this->dirtyFields = [];
    }
}
