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

    public function run(): string
    {
        $postData = $this->request->getData();
        $value = $postData['string'] ?? '';
        $hostname = $_SERVER['HOSTNAME'];

        try {
            $success = true;
            $result = '';

            if ($this->request->getMethod() === 'POST' && isset($postData['string'])) {
                $str = trim($postData['string']);
                if (!empty($str)) {
                    $validatorService = new ValidatorService();
                    if ($validatorService->validate($str)) {
                        $result = 'Все хорошо! Все скобки на месте!';
                    } else {
                        throw new Exception('Строка с некорректным соответствием скобок!', 400);
                    }
                } else {
                    throw new Exception('Параметр string не может быть пустым', 400);
                }
            }
        } catch (Exception $exception) {
            $success = false;
            $result = $exception->getMessage();
            http_response_code($exception->getCode());
        } finally {
            return $this->render('main', compact('value', ['hostname', 'result', 'success']));
        }
    }

    private function render(string $path, $data): string
    {
        foreach ($data as $key => $val) {
            $$key = $val;
        }

        ob_start();

        include __DIR__ . '/../templates/' . $path . '.php';

        return ob_get_clean();
    }
}
