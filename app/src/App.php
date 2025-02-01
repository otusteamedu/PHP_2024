<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp;

use SlavaMakhov\OtusWebserversApp\Http\Requests\Request;
use SlavaMakhov\OtusWebserversApp\Services\RedisService;
use SlavaMakhov\OtusWebserversApp\Routes\Web;

class App
{
    /** @var RedisService */
    private RedisService $redisService;
    public Request $request;

    public function __construct()
    {
        $this->redisService = RedisService::getInstance();
        $this->request = new Request();
        $this->setSessionRedis();
    }

    /**
     * Старт приложения
     *
     * @return void
     */
    public function run()
    {
        (new Web($this->request))->start();
    }

    /**
     * Метод создает сессию в Redis
     *
     * @return void
     */
    protected function setSessionRedis(): void
    {
        session_start([
            'save_handler' => $this->redisService->host,
            'save_path' => $this->redisService->path
        ]);

        if (!isset($_SESSION['key'])) {
            $_SESSION['key'] = md5((string)strtotime(date('d-m-Y H:i:s')));
        }
    }
}
