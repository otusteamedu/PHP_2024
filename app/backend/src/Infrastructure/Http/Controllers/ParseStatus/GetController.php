<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Http\Controllers\ParseStatus;

use AnatolyShilyaev\Backend\Application\UseCase\GetParseStatus\GetParseStatusUseCase;

class GetController
{
    public function __construct(
        private GetParseStatusUseCase $getParseStatusUseCase,
    ) {
        // Empty constructor
    }

    public function __invoke()
    {
        try {
            // Получаем загруженные данные
            $parseStatus = ($this->getParseStatusUseCase)();

            return [
                'message' => 'Текущий статус получен',
                'result' => $parseStatus['status'],
            ];
        } catch (\Throwable $e) {
            error_log('Критическая ошибка в GetController');
            return [
                'error' => 'Ошибка на сервере: ' . $e->getMessage(),
            ];
        }
    }
}
