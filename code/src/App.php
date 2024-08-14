<?php

namespace Balance\app;

use Balance\chacker\Chacker as Chacker;
use Balance\session\Session as Session;
use Exception;

include_once __DIR__ . "/Checker.php";
include_once __DIR__ . "/Session.php";

class App
{
    public $app_string;
    public $app_code;
    public $app_logg;
    public $checker;
    public $session;

    public function __construct()
    {
        if (isset($_POST["string"])) {
            $this->app_string = $_POST["string"];
        } else {
            $this->app_string = "";
        };

        //Результат вычислений (код и логги)
        $this->checker = new Chacker($this->app_string);
        $this->checker->calculate();

        $this->app_code = $this->checker->getCode();
        $this->app_logg = $this->checker->getLogg();

        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $this->app_code . ' ' . $this->app_logg);
    }

    public function run()
    {

        echo "</br> <h3>Форма ввода данных</h3>";
        echo "<form action=\"index.php\" method=\"POST\">
            <p>Строка: <input type=\"text\" name=\"string\" /></p>
            <input type=\"submit\" value=\"Отправить\">
            </form>";
            echo "<h3 style=\"color:blue\"> Результат: </h3> Код ответа: $this->app_code </br> $this->app_logg  </br> </br>";

        //Работа сесси (код, логги, текст и имя сервера)
        echo "</br><h3>Сиссия Redis</h3>";
        $this->session = new Session($this->app_string, $this->app_code, $this->app_logg);

        try {
            echo $this->session->getLastSession();
        } catch (Exception $e) {
            echo "Рад знакомству!";
        }

        $this->session->setCurrentSession();
        echo "</br></br></br> Запрос обратотал контейнер: " . $_SESSION["this_try"]["server"];
    }
}
