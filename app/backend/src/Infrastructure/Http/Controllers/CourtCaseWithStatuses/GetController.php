<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Http\Controllers\CourtCaseWithStatuses;

use AnatolyShilyaev\Backend\Application\UseCase\GetAllCourtCases\GetAllCourtCasesUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\GetCourtCasesWithStatus\GetCourtCasesWithStatusUseCase;
use AnatolyShilyaev\Backend\Application\UseCase\GetTotalCountCourtCases\GetTotalCountCourtCasesUseCase;

class GetController
{
    public function __construct(
        private GetCourtCasesWithStatusUseCase $getCourtCasesWithStatusUseCase,
        private GetAllCourtCasesUseCase $getAllCourtCasesUseCase,
        private GetTotalCountCourtCasesUseCase $getTotalCountCourtCasesUseCase,
    ) {
        // Empty constructor
    }

    public function __invoke()
    {
        try {
            // Получаем обработанные данные
            $allCourtsCasesWithStatuses = ($this->getCourtCasesWithStatusUseCase)();

            // Получаем все загруженные данные
            $totalCountAllCourtsCases = ($this->getTotalCountCourtCasesUseCase)();

            return [
                'message' => 'Обработанные данные получены',
                'result' => $allCourtsCasesWithStatuses,
                'linkCount' => $totalCountAllCourtsCases,
            ];
        } catch (\Throwable $e) {
            error_log('Критическая ошибка в GetController');
            return [
                'error' => 'Ошибка на сервере: ' . $e->getMessage(),
            ];
        }
    }
}
