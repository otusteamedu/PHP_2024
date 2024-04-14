<?php

declare(strict_types=1);

namespace App\Validators;

use App\Http\Request;
use App\Http\Response;
use Exception;

class StringValidator
{
    private Request $request;

    public function __construct(private readonly string $paramName)
    {
        $this->request = new Request();
    }

    /**
     * @throws Exception
     */
    public function validate(): string
    {
        return match (false) {
            $this->isEmptyValidate() => $this->validateError('пустая строка'),
            $this->isStartEndSymbolValidate() => $this->validateError('не корректное начало/конец строки'),
            $this->isSubstrCompareValidate() => $this->validateError(
                'количество открытых скобок не соответствует количеству закрытых'
            ),
            default => $this->validateSuccess()
        };
    }

    private function validateSuccess(): string
    {
        return new Response('строка валидна') . '<br>';
    }

    private function isEmptyValidate(): bool
    {
        return !empty($this->request->data($this->paramName));
    }

    private function isStartEndSymbolValidate(): bool
    {
        $str = $this->request->data($this->paramName);
        return $str[0] === '(' && $str[-1] === ')';
    }

    private function isSubstrCompareValidate(): bool
    {
        $str = $this->request->data($this->paramName);
        return mb_substr_count($str, '(') === mb_substr_count($str, ')');
    }

    /**
     * @throws Exception
     */
    private function validateError(string $message)
    {
        throw new Exception($message);
    }
}
