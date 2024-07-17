<?php

namespace Naimushina\Chat;

use Exception;

class Socket
{
    /**
     * @var false|\Socket
     */
    public \Socket|false $unixSocket;

    /**
     * Создаёт UNIX сокет (конечную точку для обмена информацией)
     * @throws Exception
     */
    public function create(): void
    {
        $this->unixSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if(!$this->unixSocket){
            $this->error("Не удалось создать Unix-сокет.");
        }

    }

    /**
     * Привязывает имя к сокету
     * @param $address string  путь к доменному сокету Unix
     * @return void
     * @throws Exception
     */
    public function bind(string $address): void
    {

        if (!socket_bind($this->unixSocket, $address)){
            $this->error("Не удалось выполнить socket_bind $address");
        }

    }
    public function block(){
        if (!socket_set_block($this->unixSocket)){
            $this->error("Не удалось выполнить socket_set_block.");
        }

    }
    public function unblock(){
        if (!socket_set_nonblock($this->unixSocket)){
            $this->error("Не удалось выполнить socket_set_nonblock.");
        }

    }

    /**
     * Прослушивает входящие соединения на сокете
     * @return void
     * @throws Exception
     */
    public function listen(): void
    {
        if (socket_listen($this->unixSocket, 5) === false) {
           $this->error('Ошибка прослушивания сокета');
        }
    }

    /**
     * Принимает соединение на сокете
     * @return false|\Socket экземпляр Socket, который может быть использован для связи
     * @throws Exception
     */
    public function accept(): bool|\Socket
    {
        $socket = socket_accept($this->unixSocket);
        if (!$socket) {
            $this->error('Ошибка приема соединения');
        }
        return $socket;
    }

    /**
     * Считывает из сокета максимальное количество байтов
     * @param $connectionSocket
     * @param $length
     * @return bool|string
     * @throws Exception
     */
    public function read($connectionSocket, $length): bool|string
    {
        $data = socket_read($connectionSocket, $length);
        if ($data === false) {
            $this->error('Ошибка чтения данных');
        }
        return $data;
    }

    /**
     * Записывает в сокет
     * @param $connectionSocket
     * @param $data
     * @return void
     * @throws Exception
     */
    public function write($connectionSocket, $data): void
    {
        if (!socket_write($connectionSocket, $data)) {
            $this->error('Ошибка отправки данных.');
        }
    }

    /**
     * Закрывает экземпляр Socket
     * @param Socket $socket
     * @return void
     * @throws Exception
     */
    public function close(Socket $socket): void
    {
        socket_close($socket);
    }


    public function getError(): string
    {
        return socket_strerror(socket_last_error());
    }

    /**
     * @throws Exception
     */
    public function error($message){
        throw new Exception($message.  " Ошибка:" . $this->getError());
    }

    /**
     * Привязывает имя к сокету
     * @param $address string  путь к доменному сокету Unix
     * @return void
     * @throws Exception
     */
    public function connect(string $address): void
    {

        if (!socket_connect($this->unixSocket, $address)){
            $this->error("Не удалось подсоединится к сокету $address");
        }

    }
}
