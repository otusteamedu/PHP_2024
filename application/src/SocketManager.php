<?php

namespace Pavelsergeevich\Hw5;

use Exception;
use Socket;

class SocketManager
{
    const SOCKET_PATH = '/tmp/hw_socket/hw5.sock';
    //const SOCKET_PATH = '/hw5.sock';

    public Socket $socket;

    /**
     * @var bool Было ли принято соединение на сокете (используется, так как $this->acceptSocket() заменяет $this->socket)
     */
    public bool $isListenAccepted = false;

    /**
     * @var string 'listener' или 'server'
     */
    public string $whoAmI;


    /**
     * @param string $socketMode Режим в котором создается сокет - 'listener' - для сервера, 'writer' - для клиента
     * @note Типичное сетевое соединение состоит из двух сокетов, один из которых выполняет роль клиента, а другой выполняет роль сервера.
     * @throws Exception
     */
    public function __construct(string $socketMode)
    {
        $this->whoAmI = $socketMode;
        if ($socketMode === 'listener') {
            $this->createListenerSocket();
        } elseif ($socketMode === 'writer') {
            $this->createWriterSocket();
        } else {
            throw new Exception("Тип сокета (socketMode) должен быть \'listener\' для сервера или \'writer\' для клиента");
        }
    }

    /**
     * Создать \Socket и настроить его для прослушивания
     * @throws Exception
     */
    private function createListenerSocket(): void
    {
        $this->createSocket()
            ->removeSocketFile()
            ->socketBind()
            ->socketListen()
            ->socketAccept();
    }

    /**
     * Создать \Socket и настроить его для записи
     * @throws Exception
     */
    private function createWriterSocket(): void
    {
        $this->createSocket()
            ->socketConnect();
    }

    /**
     * Удаляет файл сокета, если есть
     * @return $this
     */
    public function removeSocketFile(): SocketManager
    {
        if (file_exists(self::SOCKET_PATH)) {
            unlink(self::SOCKET_PATH);
        }
        return $this;
    }

    /**
     * Создаёт STREAM UNIX-сокет
     * @return $this
     * @throws Exception
     */
    private function createSocket(): SocketManager
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) $this->throwLastError('Ошибка создания сокета');
        $this->socket = $socket;
        return $this;
    }

    /**
     * Начинает соединение с сокетом
     * @note Должно вызываться после $this->createSocket
     * @return $this
     * @throws Exception
     */
    private function socketConnect(): SocketManager
    {
        $isConnected = socket_connect($this->socket, self::SOCKET_PATH);
        if (!$isConnected) $this->throwLastError('Ошибка соединения с сокетом', $this->socket);
        return $this;
    }

    /**
     * Привязывает путь файла к сокету
     * @note Должно вызываться до $this->listenSocket
     * @return $this
     * @throws Exception
     */
    public function socketBind(): SocketManager
    {
        $isBound = socket_bind($this->socket, self::SOCKET_PATH);
        if (!$isBound) $this->throwLastError('Ошибка привязывания к сокету', $this->socket);
        return $this;
    }

    /**
     * Прослушивает входящие соединения на сокете
     * @note Должно вызываться после $this->createSocket и $this->socketBind
     * @return $this
     * @throws Exception
     */
    public function socketListen(): SocketManager
    {
        $isListened = socket_listen($this->socket);
        if (!$isListened) $this->throwLastError('Ошибка конфигурирования прослушивания сокета', $this->socket);
        return $this;
    }

    /**
     * Принимает соединение на сокете
     * @return $this
     * @throws Exception
     */
    public function socketAccept(): SocketManager
    {
        $socketAccepted = socket_accept($this->socket);
        if (!$socketAccepted) $this->throwLastError('Ошибка принятия соединения для прослушивания');
        $this->isListenAccepted = true;
        $this->socket = $socketAccepted;
        return $this;
    }

    /**
     * Читает строку из сокета
     * @return string|null
     * @throws Exception
     */
    public function socketRead(): ?string
    {
        if (!$this->isListenAccepted) throw new Exception('Перед чтением необходимо принять соединение для прослушивания');

        $message = socket_read($this->socket, 255, PHP_BINARY_READ); //todo: PHP_NORMAL_READ
        if ($message === false) $this->throwLastError('Ошибка чтения из сокета', $this->socket);

        return $message;
    }

    /**
     * Запись в сокет
     * @param string $message Сообщение
     * @return $this
     * @throws Exception
     */
    public function socketWrite(string $message): SocketManager
    {
        $isWrited = socket_write($this->socket, $message, strlen($message));
        if ($isWrited === false) $this->throwLastError("Ошибка записи в сокет", $this->socket);
        return $this;
    }

    /**
     * Закрывает экземпляр Socket
     * @return $this
     */
    public function socketClose(): SocketManager
    {
        socket_close($this->socket);
        return $this;
    }

    /**
     * Выбрасывает последнюю ошибку на сокете
     * @param string|null $message Сообщение
     * @param Socket|null $socket Сокет, если известен
     * @throws Exception
     */
    private function throwLastError(?string $message = 'Ошибка сокета', ?Socket $socket = null) {
        $lastErrorSocketCode = socket_last_error($socket);
        $lastErrorSocketMessage = socket_strerror($lastErrorSocketCode);
        throw new Exception("[{$this->whoAmI}] {$message}: [{$lastErrorSocketCode}] {$lastErrorSocketMessage}");
    }

}