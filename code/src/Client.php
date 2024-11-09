<?php
namespace AlexAgapitov\OtusComposerProject;

class Client
{
    public UnixSocket $client;

    /**
     * @throws \Exception
     */
    public function __construct($file, $length)
    {
        $this->client = new UnixSocket($file, $length);
    }

    public function app(bool $test = false): void
    {
        $this->connect();
        while (true) {
            foreach ($this->getMessage() as $msg) {
                if (!$this->sendMessage($msg)) {
                    echo 'Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL;
                    $this->close();
                    return;
                } else {
                    echo 'Отправленно сообщение: '. $msg . PHP_EOL;
                }
            }
            if ($test) break;
        }
    }

    public function connect()
    {
        $this->client->create();
        $this->client->socketConnect();
    }

    public function close()
    {
        $this->client->closeSession();
    }

    public function sendMessage(string $msg) {
        return $this->client->sendMessage($msg);
    }

    public function getMessage(): \Generator
    {
        echo 'Введите сообщение. Для выхода нажмите CTRL + C' . PHP_EOL;
        yield fgets(STDIN);
    }
}