<?php

namespace Kyberlox\App;

require_once __DIR__ . "/vendor/autoload.php";

use Kyberlox\Rds\Redis as Redis;
use Kyberlox\Table\Table as Table;

class App
{
    public $host;
    public $port;
    public $password;

    public $dataBase;

    public function __construct()
    {
        $this->host = (string) getenv("HOST");
        $this->port = (string) getenv("PORT");
        $this->password = (string) getenv("REDIS_PASS");

        $this->dataBase = new Redis($this->host, $this->port, $this->password);
    }

    public function run($params)
    {
        switch ($params[1]) {
            case "add":
                $this->dataBase->addEvent($params[2]);
                break;
            case "bulk":
                $this->dataBase->addEvents($params[2]);
                break;
            case "search":
                $table = new Table($this->dataBase->search($params[2]));
                $table_display = $table->view();
                $table_display->display();
                break;
            case "clear":
                $this->dataBase->clear();
                break;
            default:
                echo "Доступные команды: \n add - добавить запись в БД; \n bulk - добавить несколько записей в БД; \n search - поиск в БД; \n clear - очистить БД;";
        };
    }
}
/*
$app = new App();
$app->run('add', '{"Name":"Степанов Акрадий Геннадьевич","Priority":0,"Params":{"photo":"img0.png","position":"Генеральный Директор","department":"ОАО «Купи-Продай»","phone":"777-000"}}');
$app->run("bulk", '[{"Name":"Иванов Евгений Вмитриевич","Priority":2,"Params":{"photo":"img1.png","position":"Руководитель","department":"Отдел Маркетинга","phone":"777-001","projects":["реклама","стратегия развития"]}},{"Name":"Вязов Сергей Фёдорович","Priority":4,"Params":{"photo":"img7.png","position":"Специалист","department":"Отдел Маркетинга","phone":"777-007","projects":["группа в вк","группа в телеграме","визитки"]}},{"Name":"Сидоров Акрадий Геннадьевич","Priority":1,"Params":{"photo":"img2.png","position":"Руководитель","department":"Коммерческий отдел","phone":"777-002","profit":350000,"expenses":250000}},{"Name":"Волков Сергей Эдуардович","Priority":5,"Params":{"photo":"img3.png","position":"Специалист","department":"Коммерческий отдел","phone":"777-003","profit":100000}},{"Name":"Шишкин Семён Игорьевич","Priority":5,"Params":{"photo":"img4.png","position":"Специалист","department":"Коммерческий отдел","phone":"777-004","profit":150000}},{"Name":"Жидков Егор","Priority":5,"Params":{"photo":"img5.png","position":"Специалист","department":"Коммерческий отдел","phone":"777-005","profit":75000}},{"Name":"Нерезов Данил Геннадьевич","Priority":3,"Params":{"photo":"img6.png","position":"Специалист по закупкам","department":"Коммерческий отдел","phone":"777-006","expenses":200000}}]');
echo "Кто главный? \n";
$app->run("search", '{"position":"Директор"}');
echo "Все сотрудники \n";
$app->run("search", '{"Name":""}');
echo "Все сотрудники коммерческого отдела \n";
$app->run("search", '{"department":"Коммерческий отдел"}');
echo "Все специалисты коммерческого отдела \n";
$app->run("search", '{"department":"Коммерческий отдел","position":"Специалист"}');
//$app->run("clear", '');
*/
