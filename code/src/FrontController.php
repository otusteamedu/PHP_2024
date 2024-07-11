<?php

namespace Naimushina\Webservers;

use Exception;

class FrontController
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * GET /
     * @return void
     */
    public function show()
    {
        echo ' <div>Отправить запрос</div>
                <form method="post">
                    <input type="text" name="string">
                    <button type="submit">Отправить</button>
                </form>';
        echo '<p>Запрос обработал контейнер</p>' . $_SERVER['HOSTNAME'];
        echo '<p>Запрос обработал сервер</p>' . $_SERVER['SERVER_ADDR'];
        $count = $_SESSION['count'] ?? 1;
        echo '<p>Сессия</p>' . session_id();
        echo 'Загрузки страницы ' . $count;
        $_SESSION['count'] = ++$count;
    }

    /**
     * POST /
     * @param IValidator $validator
     * @return void
     */
    public function index(IValidator $validator)
    {
        try {
            $validator->validate($this->request);
            $this->response->send(200, 'всё хорошо');
        } catch (Exception $e) {
            $this->response->send(400, $e->getMessage());
        }
    }
}
