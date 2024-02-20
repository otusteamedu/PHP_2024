<?php

namespace Hukimato\SocketChat;

use InvalidArgumentException;

class App
{
    /**
     * @var string|null Имя по которому приложение будет идетифицироваться при общении с сервером
     */
    private ?string $name = null;

    /**
     * @var Type|null Тип приложения
     */
    private ?Type $type = null;

    /**
     * @param string $type
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct(string $type, string $name)
    {
        $this->type = Type::tryFrom(strtoupper($type));
        if (is_null($this->type)) {
            throw new InvalidArgumentException("Ошибка в типе приложения.");
        }

        $this->name = $name;
        if (empty($this->name)) {
            throw new InvalidArgumentException("Параметр name не может быть пустым");
        }
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        match ($this->type) {
            Type::SERVER => (new Server($this->name))->run(),
            Type::CLIENT => (new Client($this->name))->run()
        };
    }
}