<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusQueueApp\Http\Controllers;

use SlavaMakhov\OtusQueueApp\Http\Requests\Request;
use SlavaMakhov\OtusQueueApp\Services\RabbitMQService;
use SlavaMakhov\OtusQueueApp\View;

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
     * Метод принимает входящие параметры
     * и сохранаяет в очередь
     *
     * @param Request $request
     *
     * @return void
     */
    public function sendData(Request $request): void
    {
        $params = $request->params['post'];
        $code = 200;
        $queueService = new RabbitMQService();
        $result = ['status' => 'success', 'message' => 'Send message success!'];

        try {
            if (isset($params['str'])) {
                $queueService->sendMessage([
                    'start_date' => $params['start_date'],
                    'end_date' => $params['end_date'],
                    'user_message' => $params['str']
                ]);
            }
        } catch (\Exception $e) {
            $code = 400;
            $result = ['status' => 'error', 'message' => 'Send message failed: ' . $e->getMessage() . PHP_EOL];
        }

        $this->sendJsonResponse($result, $code);
    }
}
