<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Controller;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\Web\Service\MessageProcess\MessageProcessRequest;
use AlexanderGladkov\Broker\Web\Component\View\View;
use AlexanderGladkov\Broker\Web\Request\Request;
use AlexanderGladkov\Broker\Web\Service\MessageProcess\MessageProcessService;
use AlexanderGladkov\Broker\Web\Service\MessageProcess\ValidationException;
use RuntimeException;

class MessageController
{
    public function form(Request $request): string
    {
        $email = '';
        $text = '';
        $errors = [];
        $infoMessage = '';
        if ($request->isPost()) {
            $email = $request->post('email', '');
            $text = $request->post('text', '');
            $messageProcessRequest = new MessageProcessRequest($email, $text);
            try {
                (new MessageProcessService(new Config()))->process($messageProcessRequest);
                $email = '';
                $text = '';
                $infoMessage = 'Сообщение отправлено на обработку';
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            } catch (RuntimeException) {
                $errors = ['Произошла ошибка'];
            }
        }

        $renderParams = compact('email', 'text', 'errors', 'infoMessage');
        return View::create('message/form')->render($renderParams);
    }
}
