<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp\Http\Controllers;

use SlavaMakhov\OtusWebserversApp\Http\Requests\Request;
use SlavaMakhov\OtusWebserversApp\View;

class MainController extends Controller
{
    /**
     * Метод генерирует главную страницу
     *
     * @return void
     */
    public function index(): void
    {
        (new View())->generatePage('index');
    }

    /**
     * Метод проверки валидности ссылки (()()()()))((((()()()))(()()()(((()))))))
     *
     * @param Request $request
     *
     * @return
     */
    public function stringValidate(Request $request)
    {
        $params = $request->params['post'];
        $code = 200;
        $result = ['status' => 'success', 'message' => 'Validate success!'];

        if (empty($params['str']) || !$this->isCorrectString($params['str'])) {
            $code = 400;
            $result = ['status' => 'error', 'message' => 'Validate failed!'];
        }

        $this->sendJsonResponse($result, $code);
    }

    /**
     * Проверка отправленной ссылки на корректность
     *
     * @param string $string
     *
     * @return bool
     */
    private function isCorrectString(string $string): bool
    {
        $counter = 0;
        foreach (str_split($string) as $letter) {
            if ($letter == '(') {
                ++$counter;
            }
            if ($letter == ')') {
                --$counter;
            }
            if ($counter < 0) {
                return false;
            }
        }

        if ($counter !== 0) {
            return false;
        }

        return true;
    }
}
