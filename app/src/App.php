<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusQueueApp;

use SlavaMakhov\OtusQueueApp\Http\Requests\Request;
use SlavaMakhov\OtusQueueApp\Routes\Web;

class App
{
    /** @var Request */
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Старт приложения
     *
     * @return void
     */
    public function run(): void
    {
        (new Web($this->request))->start();
    }
}
