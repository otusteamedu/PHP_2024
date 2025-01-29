<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusDatabasePatternApp\Entities\Clients;

use SlavaMakhov\OtusDatabasePatternApp\Entities\BaseEntity;

class Client extends BaseEntity
{
    /** @var string */
    protected string $surname;

    /** @var string */
    protected string $name;

    /** @var string */
    protected string $email;

    /** @var string */
    protected string $phone;

    /** @var string */
    protected string $dob;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Метод возвращает список столбцов таблицы
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            'surname',
            'name',
            'email',
            'phone',
            'dob'
        ];
    }

    /**
     * Метод возвращает название таблицы
     *
     * @return string
     */
    protected function getTableName(): string
    {
        return 'clients';
    }

    /**
     * Метод возвращает название сущности на кирилице
     *
     * @return string
     */
    protected function getEntityName(): string
    {
        return 'Клиент';
    }

    /**
     * Получить фамилию
     *
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * Получить имя
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Получить телефон
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Получить дату рождения
     *
     * @return string
     */
    public function getDob(): string
    {
        return $this->dob;
    }

    /**
     * Добавить фамилию
     *
     * @param string $surname
     *
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Добавить имя
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Добавить email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Добавить телефон
     *
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Добавить дату рождения
     *
     * @param string $dob
     *
     * @return $this
     */
    public function setDob(string $dob): self
    {
        $this->dob = $dob;

        return $this;
    }
}
