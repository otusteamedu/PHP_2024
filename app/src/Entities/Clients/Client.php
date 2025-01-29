<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusDatabasePatternApp\Entities\Clients;

use SlavaMakhov\OtusDatabasePatternApp\Services\DatabaseService;
use SlavaMakhov\OtusDatabasePatternApp\Entities\BaseEntity;
use Exception;

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

    /** @var int */
    protected int $age;

    /** @var DatabaseService */
    private DatabaseService $db;

    public function __construct()
    {
        $this->db = DatabaseService::getInstance();
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
     * Получить возраст
     *
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
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
     * Добавить возраст
     *
     * @param int $age
     *
     * @return $this
     */
    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Метод добавляет новую сущность
     *
     * @return string
     */
    public function insert(): string
    {
        try {
            $this->db->query(
                "INSERT INTO clients (surname, name, email, phone, age) VALUES (?, ?, ?, ?, ?)",
                [
                    $this->surname,
                    $this->name,
                    $this->email,
                    $this->phone,
                    $this->age
                ],
                static::class
            );

            $this->id = (int)$this->db->getPdo()->lastInsertId();

            return "Клиент с id: " . $this->id . ", успешно создан!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка при создании клиента:: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Метод обновляет сущность
     *
     * @return string
     */
    public function update(): string
    {
        try {
            $this->db->query(
                "UPDATE clients SET surname = ?, name = ?, email = ?, phone = ?, age = ? WHERE id = ?",
                [
                    $this->surname,
                    $this->name,
                    $this->email,
                    $this->phone,
                    $this->age,
                    $this->id
                ],
                static::class
            );

            return "Клиент с id: " . $this->id . ", успешно обновлен!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка при обновлении клиента: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Метод удаляет сущность
     *
     * @return string
     */
    public function delete(): string
    {
        try {
            $this->db->query("DELETE FROM clients WHERE id = ?", [$this->id], static::class);

            return "Клиент с id: " . $this->id . ", успешно удален!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка при удалении клиента: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'clients';
    }
}
