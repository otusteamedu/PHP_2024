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
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
