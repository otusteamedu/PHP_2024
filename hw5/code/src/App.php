<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw5;

use GoroshnikovP\Hw5\Exceptions\AppException;
use Throwable;

class App
{
    /**
     * @throws AppException
     */
    public function run(): string
    {
        try {
            $strOfBraces = $_POST['string'] ?? null;
            $bracesService = new BracesService();
            $result = $bracesService->calculateBraces($strOfBraces);

            if (empty($result)) {
                http_response_code(200);
                return 'Скобки расставлены правильно.';
            } else {
                throw new AppException($result);
            }
        } catch (AppException $ex) {
            // Этот тип, выбрасываем умышленно, для передачи ошибки в приложение.
            // Поэтому выбрасываем опять.
            http_response_code(400);
            throw $ex;
        } catch (Throwable $ex) {
            // Любые другие экзепшены, не должны до сюда дойти. Если дошли, значит где-то ошиблись в коде.
            // И если так, то переписываем на наш экзепшен.
            http_response_code(500);
            throw new AppException('Внутренняя ошибка: ' . $ex->getMessage());
        }
    }
}
