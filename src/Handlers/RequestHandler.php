<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dictionaries\QueueDictionary;
use App\Producer;
use App\Requests\RequestWithId;
use App\Responses\ErrorResponse;
use App\Responses\ResponseInterface;
use App\Responses\SuccessResponse;

readonly class RequestHandler
{
    public function __construct(private Producer $producer)
    {
    }

    public function handle(RequestWithId $requestWithId): ResponseInterface
    {
        $request = $requestWithId->request;
        if (!$request->validate()) {
            return new ErrorResponse('Неверные данные', $requestWithId->id);
        }

        $msgBody = array_merge($request->toArray(), ['id' => $requestWithId->id]);

        $this->producer->publish($msgBody, QueueDictionary::BankStatementQueue->value);
        return new SuccessResponse(
            "Запрос добавлен в обработку. Вы будете уведомлены по адресу $request->email, когда отчет будет готов.",
            $requestWithId->id
        );
    }
}
