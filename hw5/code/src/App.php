<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw5;

use GoroshnikovP\Hw5\Exceptions\AppException;
use Throwable;

class App
{
    private ?string $strOfBraces;

    private function validateInput(): string
    {
        if ($this->strOfBraces === null) {
            return 'Требуется строка в post-параметре string.';
        }

        $strOfBraces = trim($this->strOfBraces);
        if ('' === $strOfBraces) {
            return 'Передана пустая строка.';
        }

        return '';
    }


    /**
* @return string пустая строка, скобки расставлены верно. Иначе, что именно не в порядке.
     */
    private function calculateBraces(): string
    {
        $isCorrect = true;
        $correctCharsOnly = true;
        $countOpenedBraces = 0;
        $len = strlen($this->strOfBraces);
        for ($index = 0; $index < $len; $index++) {
            $char = $this->strOfBraces[$index];
            if ($char === '(') {
                $countOpenedBraces++;
            } elseif ($char === ')') {
                $countOpenedBraces--;
                if ($countOpenedBraces < 0) {
                    break;
                }
            } else {
                return 'В строке посторонние символы.';
            }
        }

        return (0 === $countOpenedBraces) ? '' : 'Ошибка в расстановке скобок.';
    }


    /**
     * @throws AppException
     */
    public function run(): string
    {
        try {
            $this->strOfBraces = $_POST['string'] ?? null;
            $validateMsg = $this->validateInput();
            if (!empty($validateMsg)) {
                throw new AppException($validateMsg);
            }

            $result = $this->calculateBraces();

            if (empty($result)) {
                http_response_code(200);
                return 'Скобки раставлены правильно.';
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
