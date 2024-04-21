<?php

namespace Pavelsergeevich\Hw5;

use Exception;

class ClientApp implements Runnable
{
    const ANSWER_INFO = "\n=== Возможные команды: ===\ninfo - Выводит список возможных команд\nmessage {text} - Отправить сообщение \"{text}\" на сервер\nkillme - завершить процесс клиента - увы, но повторно подключиться, не получится:(\nkillmeplease - завершить все процессы\n=====================\n";
    const ANSWER_KILLME = "\nbye-bye...\n";
    const ANSWER_MESSAGE_SUCCESS = "\nСообщение успешно доставлено\n";
    const ANSWER_MESSAGE_ERROR = "\nСообщение не отправилось\n";
    public bool $isRunning;
    public SocketManager $socketManager;
    public function __construct()
    {
        $this->socketManager = new SocketManager('writer');
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $this->isRunning = true;

        foreach ($this->yieldedRun() as $answer) {
            echo $answer;
        }

//        while ($this->isRunning) {
//
//            sleep(1);
//            $query = readline("\nВведите команду (info - для подсказки):\n >>> ");
//            $queryArgs = explode(' ', trim($query));
//            $answer = $this->getAnswerAndHandleQuery($queryArgs);
//            if ($answer['answer']) {
//                echo $answer['answer'];
//                //yield $answer['answer'];
//            }
//
//            if ($answer['isFinish']) {
//                $this->socketManager->socketClose();
//                $this->isRunning = false;
//            }
//        }
    }

    private function yieldedRun() {
        while ($this->isRunning) {

            sleep(1);
            $query = readline("\nВведите команду (info - для подсказки):\n >>> ");
            $queryArgs = explode(' ', trim($query));
            $answer = $this->getAnswerAndHandleQuery($queryArgs);
            if ($answer['answer']) {
                yield $answer['answer'];
            }

            if ($answer['isFinish']) {
                $this->socketManager->socketClose();
                $this->isRunning = false;
            }
        }
    }

    /**
     * Обработать запрос и получить ответ
     * @param array $queryArgs Массив аргументов запроса
     * @return array
     * @throws Exception
     */
    private function getAnswerAndHandleQuery(array $queryArgs): array
    {
        if (count($queryArgs) < 1) {
            return [
                'isFinish' => false,
                'isFinishServer' => false,
                'answer' => null
            ];
        }

        if ($queryArgs[0] == 'info') {
            return [
                'isFinish' => false,
                'isFinishServer' => false,
                'answer' => self::ANSWER_INFO
            ];
        }

        if ($queryArgs[0] == 'killme') {
            return [
                'isFinish' => true,
                'isFinishServer' => false,
                'answer' => self::ANSWER_KILLME
            ];
        }

        if ($queryArgs[0] == 'killmeplease') {
            $this->sendMessage('killmeplease');
            return [
                'isFinish' => true,
                'isFinishServer' => true,
                'answer' => self::ANSWER_KILLME
            ];
        }

        if ($queryArgs[0] == 'message') {
            if (count($queryArgs) > 1) {
                $fullMessage = trim(mb_substr(implode(" ", $queryArgs), 8));
                if ($fullMessage === 'killmeplease') {
                    return [
                        'isFinish' => false,
                        'isFinishServer' => false,
                        'answer' => "Используйте \"killmeplease\" только вне контекста message, подробнее по команде info"
                    ];
                } elseif (!$fullMessage) {
                    return [
                        'isFinish' => false,
                        'isFinishServer' => false,
                        'answer' => "Введите сообщение, пример:\nmessage \"Hello, world!\""
                    ];
                }

                $sendMessageResult = $this->sendMessage($fullMessage);
                return [
                    'isFinish' => false,
                    'isFinishServer' => false,
                    'answer' => $sendMessageResult ? self::ANSWER_MESSAGE_SUCCESS : self::ANSWER_MESSAGE_ERROR
                ];
            } else {
                return [
                    'isFinish' => false,
                    'isFinishServer' => false,
                    'answer' => "Введите сообщение, пример:\nmessage \"Hello, world!\""
                ];
            }
        }

        return [
            'isFinish' => false,
            'isFinishServer' => false,
            'answer' => null
        ];
    }

    /**
     * Отправить сообщение на сокет
     * @param string $message Сообщение
     * @return bool
     * @throws Exception
     */
    private function sendMessage(string $message): bool
    {
        $this->socketManager->socketWrite($message);
        return true;
    }
}