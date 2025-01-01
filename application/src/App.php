<?php

namespace Den\Hw5;

use Den\Hw5\Http\Request;
use Den\Hw5\Services\ValidatorService;
use Exception;

class App
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    public function run(): ?string
    {
        $postData = $this->request->getData();
        $value = $postData['string'] ?? '';
        $result = <<<END
            <h1>Валидатор строки со скобками</h1>
            <form action="/" method="POST">
            <input size="50" type="text" name="string" placeholder="Введите строку со скобками пример(Привет(как(дела)))" value="{$value}">
            <button type="submit">Валидировать</button>
            </form>
        END;

        if ($this->request->getMethod() === 'POST' && isset($postData['string'])) {
            $str = trim($postData['string']);
            if (!empty($str)) {
                $validatorService = new ValidatorService();
                if ($validatorService->validate($str)) {
                    $result .= '<strong>Все хорошо! Все скобки на месте!</strong>';
                } else {
                    throw new Exception('Строка с некорректным соответствием скобок!', 400);
                }
            } else {
                throw new Exception('Параметр string не может быть пустым', 400);
            }
        }

        return $result;
    }
}
