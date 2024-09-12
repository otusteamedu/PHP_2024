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

    public function app(): void
    {
        $this->client->socketConnect();
        while (true) {
            foreach ($this->getMsg() as $msg) {
                if (!$this->client->sendMessage($msg)) {
                    echo 'Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL;
                    $this->client->closeSession();
                    return;
                }
            }
        }
    }

    private function getMsg(): \Generator
    {
        echo 'Введите сообщение. Для выхода нажмите CTRL + C' . PHP_EOL;
        yield fgets(STDIN);
    }
}