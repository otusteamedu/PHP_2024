<?php

namespace Naimushina\Chat;

use Exception;

class Socket
{
    /**
     * @var \Socket
     */
    public \Socket $unixSocket;

    /**
     * Создаёт UNIX сокет (конечную точку для обмена информацией)
     * @throws Exception
     */
    public function create(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            $this->error("Не удалось создать Unix-сокет.");
        }
        $this->unixSocket = $socket;
    }

    /**
     * Привязывает имя к сокету
     * @param $address string  путь к доменному сокету Unix
     * @return void
     * @throws Exception
     */
    public function bind(string $address): void
    {
        if (!socket_bind($this->unixSocket, $address)) {
            $this->error("Не удалось выполнить socket_bind $address");
        }

    }

    /**
     * Прослушивает входящие соединения на сокете
     * @param int $maxConnections Максимум входящих соединений
     * @return void
     * @throws Exception
     */
    public function listen(int $maxConnections): void
    {
        if (socket_listen($this->unixSocket, $maxConnections) === false) {
            $this->error('Ошибка прослушивания сокета');
        }
    }

    /**
     * Принимает соединение на сокете
     * @return \Socket экземпляр Socket
     * @throws Exception
     */
    public function accept(): \Socket
    {
        $socket = socket_accept($this->unixSocket);
        if (!$socket) {
            $this->error('Ошибка приема соединения');
        }
        return $socket;
    }

    /**
     * Считывает из сокета максимальное количество байтов
     * @param \Socket $connectionSocket
     * @param int $length
     * @return bool|string
     * @throws Exception
     */
    public function read(\Socket $connectionSocket, int $length): bool|string
    {
        $data = socket_read($connectionSocket, $length);
        if ($data === false) {
            $this->error('Ошибка чтения данных');
        }
        return $data;
    }

    /**
     * Получает данные из сокета, независимо от того, подсоединён он или нет
     * @param \Socket $connectionSocket
     * @return array
     * @throws Exception
     */
    public function receive(\Socket $connectionSocket): array
    {
        $data = null;
        $bytes = socket_recvfrom($connectionSocket, $data, 65536, 0, $from);
        if ($bytes < 0) {
            $this->error('Ошибка получения данных');
        }
        return [$data, $bytes];
    }

    /**
     * Записывает в сокет
     * @param \Socket $connectionSocket
     * @param string $data
     * @return void
     * @throws Exception
     */
    public function write(\Socket $connectionSocket, string $data): void
    {
        if (!socket_write($connectionSocket, $data)) {
            $this->error('Ошибка отправки данных.');
        }
    }

    /**
     * Закрывает экземпляр Socket
     * @param \Socket $socket
     * @return void
     */
    public function close(\Socket $socket): void
    {
        socket_close($socket);
    }


    /**
     * Получаем последнюю ошибку сокета в виде строки
     * @return string
     */
    public function getError(): string
    {
        return socket_strerror(socket_last_error());
    }

    /**
     * Выбрасываем исключение с информацией об ошибке сокета
     * @throws Exception
     */
    public function error($message)
    {
        throw new Exception($message . " Ошибка:" . $this->getError());
    }

    /**
     * Привязывает имя к сокету
     * @param $address string  путь к доменному сокету Unix
     * @return void
     * @throws Exception
     */
    public function connect(string $address): void
    {

        if (!socket_connect($this->unixSocket, $address)) {
            $this->error("Не удалось подсоединится к сокету $address");
        }

    }

    /**
     * Очищаем файл сокета
     * @param string $file
     * @return void
     */
    public function clear(string $file): void
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
