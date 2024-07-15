<?php

namespace Ahor\Hw19\handler;

use Ahor\Hw19\queues\Queues;
use Ahor\Hw19\response\ResponseMessage;
use Ahor\Hw19\response\ResponseStatus;
use Ahor\Hw19\rabbit\Producer;
use Ahor\Hw19\request\Form;
use Ahor\Hw19\response\Error;

class RequestHandler
{
    public function __construct(private readonly Producer $producer)
    {
    }

    public function handle(Form $form): ResponseMessage
    {
        if (!$form->validate()) {
            return new Error(ResponseStatus::BAD_REQUEST, 'Ошибка данных');
        }

        $this->producer->publish(['start' => $form->start, 'end' => $form->end, 'email' => $form->email], Queues::GenerateReport->value);
        return new ResponseMessage(
            ResponseStatus::OK,
            "Добавлено в обработку."
        );
    }
}
