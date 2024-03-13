<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw7;

use GoroshnikovP\Hw7\Exception\AppException;
use Throwable;

class App
{
    const EMAIL_LISTS_PATH = 'emails.txt';

    /**
     * @throws AppException
     */
    public function run(): string
    {
        try {
            if (!file_exists(static::EMAIL_LISTS_PATH)) {
                throw new AppException("Не найден файл " . static::EMAIL_LISTS_PATH);
            }

            $emailsList = file(static::EMAIL_LISTS_PATH);
            if (empty($emailsList)) {
                throw new AppException("Не найдены email");
            }

            foreach ($emailsList as &$email) {
                $email = trim($email);
            }
            unset($email);

            $resultArray =  (new EmailValidator())->validateEmailSList($emailsList);
            $resultString = '';
            foreach ($resultArray as $item) {
                $resultString .= $item ? '+' : '-';
            }
            return $resultString;
        } catch (AppException $ex) {
            // Этот тип, выбрасываем умышленно, для передачи ошибки в приложение.
            // Поэтому выбрасываем опять.
            throw $ex;
        } catch (Throwable $ex) {
            // Любые другие экзепшены, не должны до сюда дойти. Если дошли, значит где-то ошиблись в коде.
            // И если так, то переписываем на наш экзепшен.
            throw new AppException('Внутренняя ошибка: ' . $ex->getMessage());
        }
    }
}
